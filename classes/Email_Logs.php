<?php
namespace NAVGU\Classes;

//Exit if accessed directly.
defined('ABSPATH') or exit;

class Email_Logs {
	
	//Defined properties
    protected static $instance;

    /**
     * @var NAVGU\Classes\Email_Logs\Admin_Menu
     */
    public $admin_menu = null;
    
    /**
     * Ensuring that only 1 instance of the class is loaded
     */
	public static function instance($version){
		if(is_null(self::$instance)){
			self::$instance = new self($version);
		}
		return self::$instance;
	}
    
    /**
     * Cloning is forbidden.
     */
	public function __clone() {
		$error = new WP_Error('forbidden', 'Cloning is forbidden.');
		return $error->get_error_message();
	}
    
    /**
     * Unserializing instances of this class is forbidden.
     */
	public function __wakeup() {
		$error = new WP_Error('forbidden', 'Unserializing instances of this class is forbidden.');
		return $error->get_error_message();
	}
    
    /**
     * Our constructor
     * @param string the version of the plugin
     */
	public function __construct(string $version){
        $this->version = $version;
        $this->_include();
        $this->_instantiate();
    }

    /**
     * Method to include the files
     */
    public function _include(){

        //Classes
        include_once NAVGU_DIR_PATH . 'classes/Admin_Menu.php';

    }

    /**
     * Method to instantiate each classes
     */
    public function _instantiate(){

        $this->admin_menu = new \NAVGU\Classes\Email_Logs\Admin_Menu;

    }

}