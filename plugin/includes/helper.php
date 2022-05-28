<?php
/**
 * Filter to change invoice strings.
 */
if ( ! function_exists('challan_filter_label') ) {
    function challan_filter_label( $label, $order, $template ) {
        return apply_filters(
            'challan_filter_template_label',
            __($label, 'webappick-pdf-invoice-for-woocommerce'), //phpcs:ignore
            $order,
            $template
        );
    }
}

/**
 * Function to switch language according to order language.
 * @param $language_code
 * @param bool $cookie_lang
 */
function challan_switch_language_callback( $language_code, $cookie_lang = true ) {
    if ( ! empty($language_code) ) {
        if ( class_exists('SitePress', false) ) {
            // WPML Switch Language.
            global $sitepress;
            if ( $sitepress->get_current_language() !== $language_code ) {
                $sitepress->switch_lang($language_code, $cookie_lang);
            }
        }
        // when polylang plugin is activated
        if ( defined('POLYLANG_BASENAME') || function_exists('PLL') ) {
            if ( pll_current_language() !== $language_code ) {
                PLL()->curlang = PLL()->model->get_language($language_code);
            }
        }
    }
}

/**
 * Function to restore language.
 */
function challan_restore_language_callback() {
    $language_code = '';
    if ( class_exists('SitePress', false) ) {
        // WPML restore Language.
        global $sitepress;
        $language_code = $sitepress->get_default_language();
    }

    // when polylang plugin is activated
    if ( defined('POLYLANG_BASENAME') || function_exists('PLL') ) {
        $language_code = pll_default_language();
    }
    /**
     * Filter to hijack Default Language code before restore
     *
     * @param string $language_code
     */

    if ( ! empty($language_code) ) {
        challan_switch_language_callback($language_code);
    }
}

/**
 * Reload text domain after switch language.
 */
function challan_reload_text_domain() {
    load_plugin_textdomain(
        'webappick-pdf-invoice-for-woocommerce',
        false,
        dirname(CHALLAN_PRO_PLUGIN_BASE_NAME) . '/languages/'
    );

}


