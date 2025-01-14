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
