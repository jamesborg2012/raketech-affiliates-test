<?php

if (!defined('ABSPATH')) {
    die('ACCESS_DENIED');
}

class Operators_Controller extends Operators_Provider_Core
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_op_api_routes']);
    }

    /**
     * Registers custom routes
     */
    public function register_op_api_routes()
    {
        register_rest_route('operator-provider/v1', 'list', [
            'methods' => 'GET',
            'callback' => [$this, 'list_operators'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * Simple list API route to get the contents of the file and filter the results
     */
    public function list_operators(WP_REST_Request $request)
    {
        $query_params = $request->get_query_params();
        try {
            $operators_json = file_get_contents(dirname(__FILE__, 3) . '/assets/json/operators.json');
            $operators = json_decode($operators_json, true);

            if (!empty($query_params['bonus_type'])) {
                foreach ($operators as $key => $operator) {
                    if ($operator['bonus_type'] != $query_params['bonus_type']) {
                        unset($operators[$key]);
                    }
                }
            }

            if (!empty($query_params['filter_promo']) && $query_params['filter_promo'] == 'yes') {
                foreach ($operators as $key => $operator) {
                    if (empty($operator['promo_code'])) {
                        unset($operators[$key]);
                    }
                }
            }

            //If requested to ordered, ordering by position
            if (!empty($query_params['ordered']) && $query_params['ordered'] == true) {
                usort($operators, function ($a, $b) {
                    return $a['position'] <=> $b['position'];
                });
            }

            return $operators;
        } catch (Exception $e) {
            $this->write_log("File could not be read!");
            $this->write_log($e->getMessage());
        }
    }
}
