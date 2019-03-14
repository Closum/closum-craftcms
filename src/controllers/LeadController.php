<?php
/**
* Closum Connector plugin for Craft CMS 3.x
*
* Connects contact form with Closum to save contacts.
*
* @link      https://twitter.com/popperz0r
* @copyright Copyright (c) 2019 popperz0r
*/

namespace closum\closumconnector\controllers;

use closum\closumconnector\ClosumConnector;
use craft\mail\Message;

use Craft;
use craft\web\Controller;

/**
* Lead Controller
*
* Generally speaking, controllers are the middlemen between the front end of
* the CP/website and your plugin’s services. They contain action methods which
* handle individual tasks.
*
* A common pattern used throughout Craft involves a controller action gathering
* post data, saving it on a model, passing the model off to a service, and then
* responding to the request appropriately depending on the service method’s response.
*
* Action methods begin with the prefix “action”, followed by a description of what
* the method does (for example, actionSaveIngredient()).
*
* https://craftcms.com/docs/plugins/controllers
*
* @author    popperz0r
* @package   ClosumConnector
* @since     1.0.0
*/
class LeadController extends Controller
{

      // Protected Properties
      // =========================================================================

      /**
      * @var    bool|array Allows anonymous access to this controller's actions.
      *         The actions must be in 'kebab-case'
      * @access protected
      */
      protected $allowAnonymous = ['submit-lead', 'get-cities'];

      // Public Properties
      // =========================================================================

      // Private Methods
      // =========================================================================

      // Public Methods
      // =========================================================================

      /**
      * Handle a request going to our plugin's index action URL,
      * e.g.: actions/closum-connector/lead
      *
      * @return mixed
      */
      public function actionSubmitLead(){

            $request = Craft::$app->getRequest();

            $wanted_enviroment_params = ['CONTENT_LENGTH', 'HTTP_USER_AGENT', 'HTTP_REFERER', 'HTTP_ACCEPT_LANGUAGE', 'REMOTE_ADDR', 'REMOTE_PORT', 'REQUEST_URI', 'REQUEST_TIME_FLOAT'];

            $enviroment_params = [];

            foreach ($wanted_enviroment_params as $var) {
                  $enviroment_params[$var] = $_SERVER[$var];
            }

            //lets format lead data
            $lead_data = [
                  "name" => $request->getBodyParam('name'),
                  "city_id" => $request->getBodyParam('city_id'),
                  "custom_data" => json_encode(['Mensagem' => $request->getBodyParam('custom-data')], JSON_UNESCAPED_UNICODE),
                  "email" => ["email" => $request->getBodyParam('email')],
                  "phone" => ["extension" => "00351", "number" => $request->getBodyParam('phone-number')],
                  "lead_opt_in" => ["sms" => $request->getBodyParam('consent_sms')?: 0, "email" => $request->getBodyParam('consent_email')?: 0, "enviroment" => $enviroment_params]
            ];

            if(!isset($_SESSION) || strtotime(date(DATE_ATOM)) >= strtotime($_SESSION['closum_token']->expiration_date)){
                  $getToken = ClosumConnector::$plugin->token->getToken();

                  Craft::$app->getSession()->set('closum_token', $getToken->data);
            }

            $lead = ClosumConnector::$plugin->lead->submit($lead_data);

            $response = [
                  'status' => 0,
                  'message' => 'Verifique os dados inseridos.'
            ];

            if($lead->success){
                  $response['status'] = 1;
                  $response['message'] = 'O seu pedido foi enviado com sucesso!';

                  //lets send email
                  if(ClosumConnector::getInstance()->getSettings()->emailNotification){

                        $variables = [
                              'name' =>  $request->getBodyParam('name'),
                              'email' => $request->getBodyParam('email'),
                              'telemovel' => $request->getBodyParam('phone-number'),
                              'mensagem' => $request->getBodyParam('custom-data'),
                              'closum_url' => 'https://www.closum.com/lead/view/'.$lead->data->id,
                        ];

                        $this->sendMail($variables, 'Nova mensagem através do website - Closum');
                  }
            }

            return json_encode($response);
      }

      /**
      * Handle a request going to our plugin's actionDoSomething URL,
      * e.g.: actions/closum-connector/lead/do-something
      *
      * @return mixed
      */
      public function actionGetCities()
      {

            if(!isset($_SESSION['closum_token']) || strtotime(date(DATE_ATOM)) >= strtotime($_SESSION['closum_token']->expiration_date)){
                  $getToken = ClosumConnector::$plugin->token->getToken();

                  Craft::$app->getSession()->set('closum_token', $getToken->data);
            }

            $cities = ClosumConnector::$plugin->cities->getCities();

            return json_encode($cities->data);

      }

      /**
      * @param $html
      * @param $subject
      * @param null $mail
      * @param array $attachments
      * @return bool
      */
      private function sendMail($variables, $subject, $mail = null, array $attachments = array()): bool
      {
            $email_to = ClosumConnector::getInstance()->getSettings()->emailToNotify;
            $message = new Message();

            //lets load html
            $view = Craft::$app->getView();
            $oldTemplatesPath = $view->getTemplatesPath();
            $view->setTemplatesPath(ClosumConnector::getInstance()->getBasePath());
            $html = $view->renderTemplate('/templates/_mail/default.html', $variables);

            $message->setFrom([$email_to => $email_to]);
            $message->setTo($email_to);
            $message->setSubject($subject);
            $message->setHtmlBody($html);
            if (!empty($attachments) && \is_array($attachments)) {

                  foreach ($attachments as $fileId) {
                        if ($file = Craft::$app->assets->getAssetById((int)$fileId)) {
                              $message->attach($this->getFolderPath() . '/' . $file->filename, array(
                                    'fileName' => $file->title . '.' . $file->getExtension()
                              ));
                        }
                  }
            }

            return Craft::$app->mailer->send($message);
      }
}
