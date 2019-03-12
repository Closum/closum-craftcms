<?php
/**
 * Closum Connector plugin for Craft CMS 3.x
 *
 * Connects contact form with Closum to save contacts.
 *
 * @link      https://twitter.com/popperz0r
 * @copyright Copyright (c) 2019 popperz0r
 */

namespace closum\closumconnector\assetbundles\configurationsutility;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * ConfigurationsUtilityAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    popperz0r
 * @package   ClosumConnector
 * @since     1.0.0
 */
class ConfigurationsUtilityAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = "@closum/closumconnector/assetbundles/configurationsutility/dist";

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/Configurations.js',
        ];

        $this->css = [
            'css/Configurations.css',
        ];

        parent::init();
    }
}
