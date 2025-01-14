<?php

if (!defined('ABSPATH')) {
    die('ACCESS_DENIED');
}

class Operators_Provider_Core
{
    const PREFIX = 'op_';

    protected $modules;

    private static $instances = [];

    public function __construct()
    {
        $this->modules = array(
            'OP_Manager' => OP_Manager::get_instance(),
            'Operators_Controller' => Operators_Controller::get_instance(),
        );
    }

    /**
     * Loads a single instance of a class
     *
     * @return object
     */
    public static function get_instance(): object
    {
        $module = get_called_class();

        if (!isset(self::$instances[$module])) {
            self::$instances[$module] = new $module();
        }

        return self::$instances[$module];
    }

    /**
     * Prepares the site to use the plugin
     *
     * @mvc Controller
     *
     * @param bool $network_wide
     */
    public function activate($network_wide)
    {
        foreach ($this->modules as $module) {
            $module->activate($network_wide);
        }

        flush_rewrite_rules();
    }

    /**
     * Rolls back plugin activation and cleans up
     *
     * @mvc Controller
     */
    public function deactivate()
    {
        foreach ($this->modules as $module) {
            $module->deactivate();
        }

        flush_rewrite_rules();
    }

    /**
     * Render a template for internal plugin use
     *
     * @param  string $default_template_path Relative to the plugin's `assets/views` folder
     * @param  array  $variables             Extra variables to pass to template
     * @param  string $require               How template should be required
     * @return string
     */
    public function render_template($default_template_path = false, $variables = [], $require = 'once'): string
    {
        $template_path = dirname(__DIR__) . '/assets/views/' . $default_template_path . '.php';

        $template_content = '';

        //If the file is found, gather the variables and load the contents
        if (is_file($template_path)) {
            extract($variables);
            ob_start();

            //Loading the file in different ways
            if ('always' == $require) {
                require($template_path);
            } else {
                require_once($template_path);
            }

            $template_content = ob_get_clean();
        }

        return $template_content;
    }

    /**
     * Logs information for debugging
     */
    public function write_log($data): void
    {
        if (true === WP_DEBUG) {
            if (is_array($data) || is_object($data)) {
                error_log(print_r($data, true));
            } else {
                error_log($data);
            }
        }
    }
}
