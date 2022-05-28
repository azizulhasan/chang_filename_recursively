<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://webappick.com
 * @since 1.0.0
 *
 * @package    Challan
 * @subpackage Challan/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Challan
 * @subpackage Challan/admin
 * @author     Md Ohidul Islam <wahid@webappick.com>
 */
class Challan_Admin
{



    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_styles() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Challan_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Challan_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style('slick', plugin_dir_url(__FILE__) . 'css/minify/slick.min.css', array(), $this->version);
        wp_enqueue_style('slick-theme', plugin_dir_url(__FILE__) . 'css/minify/slick-theme.min.css', array(), $this->version);
        wp_enqueue_style('webappick-boilerplate', plugin_dir_url(__FILE__) . 'css/minify/webappick-boilerplate-admin.min.css', array(), $this->version, 'all');
        wp_enqueue_style('flatpickr', plugin_dir_url(__FILE__) . 'css/minify/flatpickr.min.css', array(), $this->version, 'all');
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_base_styles() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Challan_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Challan_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/minify/webappick-pdf-invoice-for-woocommerce-admin.min.css', array(), $this->version, 'all');

    }


    /**
     * Register the JavaScript for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Challan_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Challan_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/webappick-pdf-invoice-for-woocommerce-admin.js', array( 'jquery' ), $this->version, true);
        // Download Custom Fonts Js.
        wp_enqueue_script($this->plugin_name . 'download-fonts', plugin_dir_url(__FILE__) . 'js/challan-font.min.js', array( 'jquery' ), $this->version, true);
        $wpifw_nonce = wp_create_nonce('wpifw_pdf_nonce');
        wp_localize_script(
            $this->plugin_name . 'download-fonts',
            'wpifw_ajax_obj_font',
            array(
				'wpifw_ajax_font_url' => admin_url('admin-ajax.php'),
				'nonce'               => $wpifw_nonce,
            )
        );
        wp_enqueue_script($this->plugin_name, 'challan_ajax_url', array( 'jquery' ), $this->version, false);
        wp_enqueue_script($this->plugin_name . '_boilerplate', plugin_dir_url(__FILE__) . 'js/webappick-pdf-invoice-for-woocommerce-bundle.min.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script($this->plugin_name . '_flatpickr-js', plugin_dir_url(__FILE__) . 'js/flatpickr.min.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script($this->plugin_name . '_jquery-slick', plugin_dir_url(__FILE__) . 'js/slick.min.js', array( 'jquery', 'jquery-migrate' ), $this->version, false);

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_common_scripts() {
        wp_enqueue_script($this->plugin_name . 'common', plugin_dir_url(__FILE__) . 'js/webappick-pdf-invoice-for-woocommerce-common.min.js', array( 'jquery' ), $this->version, false);

        $wpifw_nonce = wp_create_nonce('challan_ajax_nonce');
        wp_localize_script(
            $this->plugin_name . 'common',
            'challan_ajax_obj_2',
            array(
				'challan_ajax_url_2' => admin_url('admin-ajax.php'),
				'nonce'                  => $wpifw_nonce,
            )
        );
        wp_enqueue_script($this->plugin_name . 'common', 'challan_ajax_obj_2', array( 'jquery' ), $this->version, true);

    }

    /**
     * Register PDF Invoice Menu.
     */
    public function load_admin_menu() {

        global $submenu;
        $capability = 'manage_options';
        $slug       = 'webappick-challan';
        $hook = add_menu_page( __( 'Challan', 'webappick-pdf-invoice-for-woocommerce' ), __( 'Challan', 'webappick-pdf-invoice-for-woocommerce' ), $capability, $slug, [ $this, 'challan' ], 'dashicons-media-spreadsheet' );

        if ( current_user_can( $capability ) ) {
            $submenu[ $slug ][] = [ __( 'Settings', 'webappick-pdf-invoice-for-woocommerce' ), $capability, 'admin.php?page=' . $slug . '#/settings' ];//phpcs:ignore;
            add_submenu_page( $slug, __( 'Docs', 'webappick-pdf-invoice-for-woocommerce' ), '<span class="challan-docs">' . __( 'Docs', 'webappick-pdf-invoice-for-woocommerce' ). '</span>', $capability, 'webappick-challan-docs', 'challan_docs' );
            add_submenu_page( $slug, __( 'Premium', 'webappick-pdf-invoice-for-woocommerce' ), '<span class="challan-premium">' . __( 'Premium', 'webappick-pdf-invoice-for-woocommerce' ). '</span>', $capability, 'webappick-challan-pro-vs-free', 'challan_pro_vs_free' );
        }

        add_action( 'admin_print_scripts-' . $hook, array( $this, 'enqueue_styles' ) );
        add_action( 'admin_print_scripts-' . $hook, array( $this, 'enqueue_scripts' ) );
    }

    /**
     * this function trigger the vue UI.
     */
    public function challan(){

        echo '<div class="wrap"><div id="challan_vue_free">
hasan
</div></div>';
    }
}
