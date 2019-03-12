<?php
/**
* Closum Connector plugin for Craft CMS 3.x
*
* Connects contact form with Closum to save contacts.
*
* @link      https://twitter.com/popperz0r
* @copyright Copyright (c) 2019 popperz0r
*/

namespace closum\closumconnector\services;

use closum\closumconnector\ClosumConnector;

use Craft;
use craft\base\Component;

/**
* Token Service
*
* All of your plugin’s business logic should go in services, including saving data,
* retrieving data, etc. They provide APIs that your controllers, template variables,
* and other plugins can interact with.
*
* https://craftcms.com/docs/plugins/services
*
* @author    popperz0r
* @package   ClosumConnector
* @since     1.0.0
*/
class Token extends Component
{

      // Public Methods
      // =========================================================================

      /**
      * This function can literally be anything you want, and you can have as many service
      * functions as you want
      *
      * From any other plugin file, call it like this:
      *
      *     ClosumConnector::$plugin->token->getToken()
      *
      * @return mixed
      */
      public function getToken()
      {
            try {

                  //API Credentials
                  $login = Closumconnector::getInstance()->getSettings()->apiUsername;
                  $password = Closumconnector::getInstance()->getSettings()->apiPw;
                  $auth = json_encode(['api_username' => $login, 'api_pw' => $password]);
                  $options['headers'] = [
                        "Accept: application/json",
                        "Content-Type: application/json",
                        "cache-control: no-cache"
                  ];
                  $options['body'] = $auth;

                  $curl = curl_init();

                  curl_setopt_array($curl, array(
                        CURLOPT_URL => Closumconnector::getInstance()->getSettings()->tokenEndpoint,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $options['body'],
                        CURLOPT_HTTPHEADER => $options['headers'],
                  ));

                  $response = curl_exec($curl);
                  $err = curl_error($curl);

                  if ($err) {
                        return json_decode($err);
                  } else {
                        return json_decode($response);
                  }



            } catch (Exception $e) {

                  return false;

            }
      }
}
