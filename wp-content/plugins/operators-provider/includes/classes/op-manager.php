<?php

if (!defined('ABSPATH')) {
    die('ACCESS_DENIED');
}

class OP_Manager extends Operators_Provider_Core
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_op_manager_menu']);
    }

    /**
     * Register custom menu options
     */
    public function register_op_manager_menu()
    {
        add_menu_page(
            'Operators',
            'Operators',
            'manage_options',
            'operators-manager',
            [$this, 'render_op_manager_page']
        );
    }

    /**
     * Render the operators data manager settings page
     */
    public function render_op_manager_page()
    {
        $table_headers = [
            'Position',
            'Operator',
            'Permalink',
            'Logo Background Color',
            'Bonus Type',
            'Amount',
            'Promo Code',
            'Terms Link',
            'Affiliate Link'
        ];

        $response = wp_remote_get(get_site_url(null, 'wp-json/operator-provider/v1/list?ordered=true'));
        $operators = json_decode($response['body'], true);

        $table_keys = [
            'position',
            'operator',
            'permalink',
            'logo_bg_color',
            'bonus_type',
            'amount',
            'promo_code',
            'terms_link',
            'affiliate_link',
        ];

        $table_contents = [];

        foreach ($operators as $key => $operator) {
            foreach ($table_keys as $table_key) {
                $value = $operator[$table_key] ?? ' - ';

                if ($value != '') {
                    switch ($table_key) {
                        case 'terms_link':
                        case 'affiliate_link':
                            $value = "<a href='{$value}' target='_blank'>{$value}</a>";
                            break;
                        case 'permalink':
                            $permalink = get_site_url(null, $value);
                            $value = "<a href='{$permalink}' target='_blank'>$value</a>";
                            break;
                        case 'logo_bg_color':
                            $value = "<div style='background-color: {$value}; height: 20px; width: 20px'></div>";
                            break;
                    }
                }

                $table_contents[$key][$table_key] = $value;
            }
        }

        echo $this->render_template(
            'admin/operators-api-page',
            [
                'table_headers' => $table_headers,
                'table_contents' => $table_contents
            ]
        );
    }
}
