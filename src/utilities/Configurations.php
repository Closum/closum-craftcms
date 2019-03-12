<?php
/**
 * Closum Connector plugin for Craft CMS 3.x
 *
 * Connects contact form with Closum to save contacts.
 *
 * @link      https://twitter.com/popperz0r
 * @copyright Copyright (c) 2019 popperz0r
 */

namespace closum\closumconnector\utilities;

use closum\closumconnector\ClosumConnector;
use closum\closumconnector\assetbundles\configurationsutility\ConfigurationsUtilityAsset;

use Craft;
use craft\base\Utility;

/**
 * Closum Connector Utility
 *
 * Utility is the base class for classes representing Control Panel utilities.
 *
 * https://craftcms.com/docs/plugins/utilities
 *
 * @author    popperz0r
 * @package   ClosumConnector
 * @since     1.0.0
 */
class Configurations extends Utility
{
    // Static
    // =========================================================================

    /**
     * Returns the display name of this utility.
     *
     * @return string The display name of this utility.
     */
    public static function displayName(): string
    {
        return Craft::t('closum-connector', 'Configurations');
    }

    /**
     * Returns the utility’s unique identifier.
     *
     * The ID should be in `kebab-case`, as it will be visible in the URL (`admin/utilities/the-handle`).
     *
     * @return string
     */
    public static function id(): string
    {
        return 'closumconnector-configurations';
    }

    /**
     * Returns the path to the utility's SVG icon.
     *
     * @return string|null The path to the utility SVG icon
     */
    public static function iconPath()
    {
        return Craft::getAlias("@closum/closumconnector/assetbundles/configurationsutility/dist/img/Configurations-icon.svg");
    }

    /**
     * Returns the number that should be shown in the utility’s nav item badge.
     *
     * If `0` is returned, no badge will be shown
     *
     * @return int
     */
    public static function badgeCount(): int
    {
        return 0;
    }

    /**
     * Returns the utility's content HTML.
     *
     * @return string
     */
    public static function contentHtml(): string
    {
        Craft::$app->getView()->registerAssetBundle(ConfigurationsUtilityAsset::class);

        $someVar = 'Have a nice day!';
        return Craft::$app->getView()->renderTemplate(
            'closum-connector/_components/utilities/Configurations_content',
            [
                'someVar' => $someVar
            ]
        );
    }
}
