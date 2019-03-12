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
* Lead Service
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
class Lead extends Component
{

      // Public Methods
      // =========================================================================

      /**
      * This function can literally be anything you want, and you can have as many service
      * functions as you want
      *
      * From any other plugin file, call it like this:
      *
      *     ClosumConnector::$plugin->lead->submit()
      *
      * @return mixed
      */
      public function submit($lead_data)
      {

            try {
                  //API Credentials
                  $options['headers'] = [
                        "Authorization: Bearer ".$_SESSION['closum_token']->token,
                        "Accept: application/json",
                        "Content-Type: application/json",
                        "cache-control: no-cache"
                  ];
                  $options['body'] = json_encode($lead_data);

                  $curl = curl_init();

                  curl_setopt_array($curl, array(
                        CURLOPT_URL => Closumconnector::getInstance()->getSettings()->endpoint.'/lead',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $options['body'],
                        CURLOPT_HTTPHEADER => $options['headers'],
                  ));

                  $response = curl_exec($curl);
                  $err = curl_error($curl);

                  // var_dump($response);die();
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
