<?php
/**
 * Closum Connector plugin for Craft CMS 3.x
 *
 * Connects contact form with Closum to save contacts.
 *
 * @link      https://twitter.com/popperz0r
 * @copyright Copyright (c) 2019 popperz0r
 */

namespace closum\closumconnector\models;

use closum\closumconnector\ClosumConnector;

use Craft;
use craft\base\Model;

/**
 * ClosumConnector Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    popperz0r
 * @package   ClosumConnector
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $apiUsername = 'Closum Api Username';
    public $apiPw = 'Closum Api Password';
    public $endpoint = 'https://api.closum.com/api';
    public $tokenEndpoint = 'https://api.closum.com/api/token';
    public $emailNotification;
    public $emailToNotify;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['apiUsername', 'string'],
            ['apiUsername', 'default', 'value' => 'Closum Api Username'],
            ['apiPw', 'string'],
            ['apiPw', 'default', 'value' => 'Closum Api Password'],
        ];
    }
}
