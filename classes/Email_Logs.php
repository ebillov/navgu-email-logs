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
        include_once NEL_DIR_PATH . 'classes/Admin_Menu.php';
        include_once NEL_DIR_PATH . 'classes/Email_Post_Type.php';
        include_once NEL_DIR_PATH . 'classes/Log_Writer.php';

    }

    /**
     * Method to instantiate each classes
     */
    public function _instantiate(){

        $this->admin_menu = new \NAVGU\Classes\Email_Logs\Admin_Menu;
        $this->post_type = new \NAVGU\Classes\Email_Logs\Email_Post_Type;
        $this->log_writer = new \NAVGU\Classes\Email_Logs\Log_Writer;

    }

    /**
     * Method to get the email log by email address
     * @param string $subject the email subject
     * @param array $recipients the email recipients
     * @param array $args (Optional) some optional values
     * @return mixed object email log or false on failure
     */
    public function get_log(string $subject, array $recipients = [], array $args = []){

        //Quick check
        if( empty($recipients) ){
            return false;
        }

        //define defaults
        $defaults = [
            'numberposts' => -1,
            'post_type' => 'email',
            'order' => 'DESC',
            'orderby' => 'date'
        ];

        //Parse incoming $args into an array and merge it with $defaults
        $args = wp_parse_args( $args, $defaults );

        //Get all the email logs
        $email_logs = get_posts($args);

        //Returns the current email log
        return current(
            array_filter(
                $email_logs,
                function($email) use($subject, $recipients) {

                    //Get the all recipients meta
                    $_recipients = $this->get_meta($email->ID, 'all_recipients_email');

                    //Check if there are any valid contents
                    if( !empty($_recipients) ){

                        //Normalize the index keys
                        foreach($_recipients as $key => $_recipient){
                            $_recipients[$key] = $key;
                        }

                        //Normalize indexes
                        $_recipients = array_values($_recipients);

                        //Loop through the recipients
                        foreach($recipients as $recipient){

                            //Begin searching
                            return array_search($recipient, $_recipients) !== false && $email->post_title == $subject;

                        }

                    }

                    return false;

                }
            )
        );

    }

    /**
     * Method to get all the email logs
     * @param array $args (Optional) some optional values
     * @return mixed the email log or false on failure
     */
    public function get_logs(array $args = []){

        //define defaults
        $defaults = [
            'numberposts' => -1,
            'post_type' => 'email',
            'order' => 'DESC',
            'orderby' => 'date'
        ];

        //Parse incoming $args into an array and merge it with $defaults
        $args = wp_parse_args( $args, $defaults );

        //Get all the email logs
        return get_posts($args);

    }

    /**
     * Method to get the post meta
     * @param int $id the id of the post to get
     * @param string $meta_key the meta key to query
     * @param bool $bool (Optional) whether to display in array or in single value. Default true.
     * @return mixed
     */
    public function get_meta(int $id, string $meta_key, bool $bool = true){
        return get_post_meta($id, $meta_key, $bool);
    }

    /**
     * Method to set the post meta via update method
     * @param int $id the id of the post to get
     * @param string $meta_key the meta key to query
     * @param mixed $data the data to save
     * @return bool
     */
    public function set_meta(int $id, string $meta_key, $data){
        return update_post_meta($id, $meta_key, $data);
    }

}