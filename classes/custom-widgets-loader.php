<?php
/*
@package: custom elementor widget
*/
final class CEW_widgets_Loader
{

    const VERSION = '1.0.0';

    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    const MINIMUM_PHP_VERSION = '7.0';

    private static $instance;

    public static function instance()
    {

        if (is_null(self::$instance)) {

            self::$instance = new self();
        }

        return self::$instance;
    }
    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'on_plugin_loaded']);
        
    }
    public function on_plugin_loaded()
    {

        if ($this->compatible()) {
            add_action('elementor/init', [$this, 'init']);
            add_action('elementor/init', [ $this, 'init' ] );
        }
    }
    public function load_text_domain(){
        load_plugin_textdomain('custom-elementor-widgets');
    }
    public function init()
    {
        $this->load_text_domain();
        //register plugin  widget 
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ]);
        
        // Add Plugin control
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
        
        //enqueue widget script
        add_action('elementor/frontend/after_register_scripts',[$this,'widgets_scripts']);

        //enqueue widget CSS
        add_action('elementor/frontend/after_enqueue_styles',[$this,'widgets_styles']);
    }
    public function init_widgets(){
        if(file_exists(CEW_PLUGIN_PATH.'/widgets-register/test-widget-register.php')){
            require_once CEW_PLUGIN_PATH.'/widgets-register/test-widget-register.php';
        }
    }
    public function init_controls(){
        if(file_exists(CEW_PLUGIN_PATH.'/widgets-controls/test-widgets-controls.php')){
            require_once CEW_PLUGIN_PATH.'/widgets-controls/test-widgets-controls.php';
        }
    }

    public function widgets_scripts(){

    }
    public function widgets_styles(){

    }

    public function compatible()
    {

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {

            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);

            return false;
        }
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return false;
        }
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return false;
        }
        return true;
    }

    public function admin_notice_missing_main_plugin()
    {

        if (isset($_GET['activate'])) deactivate_plugins(dirname(__FILE__, 2) . '/custom-elementor-widgets.php');

        $message = '<strong>Custom Elementor Widgets</strong> require <strong>Elementor Plugin</strong> for working';
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_elementor_version()
    {
        if (isset($_GET['activate'])) deactivate_plugins(dirname(__FILE__, 2) . '/custom-elementor-widgets.php');
        $message = '<strong>Custom Elementor Widgets</strong> require <strong>Elementor Plugin</strong> version <strong>2.0.0</strong> or above for working';
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_php_version()
    {

        if (isset($_GET['activate'])) deactivate_plugins(dirname(__FILE__, 2) . '/custom-elementor-widgets.php');
        $message = '<strong>Custom Elementor Widgets</strong> require <strong>PHP </strong> version<strong> 7.0.0</strong> or above for working';
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
}


