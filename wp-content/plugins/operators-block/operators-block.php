<?php

/**
 * Plugin Name:       Operators Block
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       operators-block
 *
 * @package CreateBlock
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_operators_block_block_init()
{
	register_block_type(__DIR__ . '/build/operators-block');
}
add_action('init', 'create_block_operators_block_block_init');

add_action('wp_enqueue_scripts', 'enqueue_scripts');

function enqueue_scripts()
{
	wp_enqueue_style('font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css');

	wp_enqueue_script('ajax-script', plugin_dir_url(__FILE__) . 'src/operators-block/ajax-scripts.js', array('jquery'));
	wp_localize_script('ajax-script', 'ajaxObj', array('ajaxUrl' => admin_url('admin-ajax.php')));
}

add_action('wp_ajax_filter_operators', 'filter_operators_toplist');
add_action('wp_ajax_no_priv_filter_operators', 'filter_operators_toplist');

function filter_operators_toplist()
{
	$query_params = [
		'ordered' => 'position',
		'order_by' => 'ASC',
		'filter_promo' => $_POST['filter_promo'],
		'bonus_type' => $_POST['bonus_type']
	];

	$api_url = 'wp-json/operator-provider/v1/list?' . http_build_query($query_params);

	$response = wp_remote_get(get_site_url(null, $api_url));
	$operators = json_decode($response['body'], true);

	$result = '';

	ob_start();
	if (empty($operators)) {
		include(__DIR__ . '/src/operators-block/views/no-operators-message.php');
	} else {
		foreach ($operators as $operator) {
			include(__DIR__ . '/src/operators-block/views/single-operator-card.php');
		}
	}
	ob_get_contents();
	$result = ob_get_clean();

	wp_send_json_success([
		'result' => $result,
	]);
}


function write_log($data): void
{
	if (true === WP_DEBUG) {
		if (is_array($data) || is_object($data)) {
			error_log(print_r($data, true));
		} else {
			error_log($data);
		}
	}
}
