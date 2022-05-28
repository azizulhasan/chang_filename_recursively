<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link  https://webappick.com
 * @since 1.0.0
 *
 * @package    Challan
 * @subpackage Challan/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Challan
 * @subpackage Challan/includes
 * @author     Md Ohidul Islam <wahid@webappick.com>
 */
class Challan_I18n
{

    /**
     * Load the plugin text domain for translation.
     *
     * @since 1.0.0
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'webappick-pdf-invoice-for-woocommerce',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }
}
