<?php

namespace DG2\Addons;

class WooCompany
{
    // class instance
    private static $instance = null;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        // add custom company billing fields
        add_action('woocommerce_billing_fields', [$this, 'pib_add_custom_checkout_fields'], 10, 1);
        // remove default billing_company
        add_filter('woocommerce_checkout_fields', [$this, 'pib_remove_default_billing_company']);

        //update fields order meta
        add_action('woocommerce_checkout_update_order_meta', [$this, 'pib_checkout_field_update_order_meta']);

        // add this custom fields data to admin order view
        add_action(
            'woocommerce_admin_order_data_after_billing_address',
            [$this, 'pib_checkout_field_admin_order_meta'],

        );

        //
        add_action(
            'woocommerce_order_details_after_order_table',
            [$this, 'pib_field_display_custom_order_meta'],

        );

        // add company details to email
        add_filter('woocommerce_email_order_meta_keys', [$this, 'pib_woocommerce_email_order_meta_keys']);

        // add column to admin columns for orders
        add_filter('manage_edit-shop_order_columns', [$this, 'pib_order_column'], 20);
        add_action('manage_shop_order_posts_custom_column', [$this, 'pib_order_column_values'], 2);

        // fields validation
        add_action('woocommerce_after_checkout_validation', [$this, 'pib_custom_validation_on_checkout'], 9999, 2);
    }





    function pib_remove_default_billing_company($fields)
    {
        unset($fields['billing']['billing_company']);
        return $fields;
    }


    function pib_add_custom_checkout_fields($fields)
    {

        $fields['pib_racun'] = array(
            'type' => 'radio',
            'class' => array('form-row-wide', 'dg2-company'),
            'options' => array('1' => __('Person', 'dg2-woo-company'), '2' => __('Company', 'dg2-woo-company'),),
            'default'  => '1',
            'required' => true,
            'priority' => 25,
        );

        $fields['pib_ime_firme'] = array(
            'type'  => 'text',
            'class' => array('form-row-wide', 'dg2-pib'),
            'label' => __('Company name', 'dg2-woo-company'),
            'required' => true,
            'placeholder'   => _x('Company name', 'placeholder', 'dg2-woo-company'),
            'priority' => 25,
        );


        $fields['pib_pib'] = array(
            'type'  => 'text',
            'class' => array('form-row-wide', 'dg2-pib'),
            'label' => __('PIB', 'dg2-woo-company'),
            'required' => true,
            'placeholder'   => _x('PIB', 'placeholder', 'dg2-woo-company'),
            'priority' => 25,
        );

        $fields['pib_mb'] = array(
            'type'  => 'text',
            'class' => array('form-row-wide', 'dg2-pib'),
            'label' => __('Company id number', 'dg2-woo-company'),
            'required' => true,
            'placeholder'   => _x('Company id number', 'placeholder', 'dg2-woo-company'),
            'priority' => 25,
        );

        return $fields;
    }

    function pib_checkout_field_update_order_meta($order_id)
    {

        if ($_POST['pib_racun'] == 2) {
            update_post_meta($order_id, 'pib_racun', esc_attr($_POST['pib_racun']));
        }
        if ($_POST['pib_ime_firme']) {
            update_post_meta($order_id, 'pib_ime_firme', esc_attr($_POST['pl_ime_firme']));
        }

        if ($_POST['pib_pib']) {
            update_post_meta($order_id, 'pib_pib', esc_attr($_POST['pl_pib']));
        }
        if ($_POST['pib_mb']) {
            update_post_meta($order_id, 'pib_mb', esc_attr($_POST['pl_mb']));
        }
    }


    function pib_checkout_field_admin_order_meta($order)
    {

        $dg2_company = get_post_meta($order->get_id(), 'pib_racun', true);
        if (!empty($dg2_company)) {

            echo '<h4>' . __('Billing', 'dg2-woo-company') . '</h4>';
            echo '<p><strong>' . __('Company name', 'dg2-woo-company') . ':</strong> ' . get_post_meta($order->get_id(), 'pib_ime_firme', true) . '<br/>';
            echo '<strong>' . __('PIB', 'dg2-woo-company') . ':</strong> ' . get_post_meta($order->get_id(), 'pib_pib', true) . '<br/>';
            echo '<strong>' . __('Company id number', 'dg2-woo-company') . ':</strong> ' . get_post_meta($order->get_id(), 'pib_mb', true) . '</p>';
        }
    }


    function pib_field_display_custom_order_meta($order)
    {

        $dg2_company = get_post_meta($order->get_id(), 'pib_racun', true);
        if (!empty($dg2_company)) {

            echo '<h2>' . __('Billing', 'dg2-woo-company') . '</h2>';
            echo '<p><strong>' . __('Company name', 'dg2-woo-company') . ':</strong> ' . get_post_meta($order->get_id(), 'pib_ime_firme', true) . '<br/>';
            echo '<strong>' . __('PIB', 'dg2-woo-company') . ':</strong> ' . get_post_meta($order->get_id(), 'pib_pib', true) . '<br/>';
            echo '<strong>' . __('Company id number', 'dg2-woo-company') . ':</strong> ' . get_post_meta($order->get_id(), 'pib_mb', true) . '</p>';
        }
    }


    function pib_woocommerce_email_order_meta_keys($keys)
    {

        if ($_POST['pib_racun'] == 2) {
            echo '<h2>' . __('Company billing', 'dg2-woo-company') . '</h2>';

            $keys[] = __('Company name', 'dg2-woo-company');
            $keys[] = __('PIB', 'dg2-woo-company');
            $keys[] = __('Company id number', 'dg2-woo-company');

            return $keys;
        }
    }


    function pib_order_column($columns)
    {
        $offset = 9;
        $updated_columns = array_slice($columns, 0, $offset, true) +
            array('pib_racun' => esc_html__('Company billing', 'dg2-woo-company')) +
            array_slice($columns, $offset, NULL, true);
        return $updated_columns;
    }


    function pib_order_column_values($column)
    {
        global $post;

        if ($column == 'pib_racun') {
            $dg2_checkbox = get_post_meta($post->ID, 'pib_racun', true);
            if ($dg2_checkbox == 2)
                echo __('Yes', 'dg2-woo-company');
            else print '-';
        }
    }

    function pib_custom_validation_on_checkout($fields, $errors)
    {

        // check for errors
        if (!empty($errors->get_error_codes())) {

            if (isset($_POST['pib_racun']) && ($_POST['pib_racun'] == 1)) {

                foreach ($errors->get_error_codes() as $code) {
                    if (in_array($code, ['pib_ime_firme_required', 'pib_adresa_firme_required', 'pib_pib_required', 'pib_mb_required'])) {
                        $errors->remove($code);
                    }
                }
            }
        }
    }




    static public function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
