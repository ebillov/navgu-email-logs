<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

class NAVGU_Main {
	
	//Defined properties
    protected static $instance = null; //A single instance of the class
    
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
        $this->include();
    }

    /**
     * Method to include the files
     */
    public function include(){

        //Classes
        //include_once NAVGU_DIR_PATH . 'classes/VEXEL_Product_Variation.php';

    }

}