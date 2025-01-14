<?php
/*
Plugin Name: Operators Provider
Plugin URI:  https://jamesborg.me
Description: Retrieves Affiliate Operators from API and provides API routes to display them
Version:     1.0
Author:      James Borg
Author URI:  https://jamesborg.me
*/

if (! defined('ABSPATH')) {
    die('Access denied');
}

define('OP_NAME',                 'Operators Provider');
define('OP_REQUIRED_PHP_VERSION', '8.0');
define('OP_REQUIRED_WP_VERSION',  '6.0');

if (verify_requirements_met()) {
    require('includes/operators-provider-core.php');
    require('includes/classes/op-manager.php');
    require('includes/controllers/operators-controller.php');

    if (class_exists('Operators_Provider_Core')) {
        $GLOBALS['op'] = Operators_Provider_Core::get_instance();
        register_activation_hook(__FILE__, [$GLOBALS['op'], 'activate']);
        register_deactivation_hook(__FILE__, [$GLOBALS['op'], 'deactivate']);
    }
}

function verify_requirements_met()
{
    global $wp_version;

    if (version_compare(PHP_VERSION, OP_REQUIRED_PHP_VERSION, '<')) {
        return false;
    }

    if (version_compare($wp_version, OP_REQUIRED_WP_VERSION, '<')) {
        return false;
    }

    return true;
}
