<?php
namespace NAVGU\Classes\Email_Logs;

use NAVGU\Classes\Email_Logs;

//Exit if accessed directly.
defined('ABSPATH') or exit;

class Log_Writer extends Email_Logs {

    /**
     * Our constructor
     */
    public function __construct(){
        $this->_action_hooks();
    }

    /**
     * Method to initialize action hooks
     */
    public function _action_hooks(){

        //Admin action hooks
        include_once NEL_DIR_PATH . 'hooks/actions/admin/phpmailer_init.php';
        include_once NEL_DIR_PATH . 'hooks/actions/admin/wp_mail_failed.php';

    }

    /**
     * Method to add an email log
     * @param array $args the post array data to insert
     * @param bool $wp_error whether to return WP_Error on failure
     * @return int the ID on success, 0 or WP_Error on failure
     */
    public static function add_log($args, $wp_error = false){

        //Define defaults
        $defaults = [
            'post_status' => 'publish',
            'post_type' => 'email',
        ];

        //Parse incoming $args into an array and merge it with $defaults
        $args = wp_parse_args( $args, $defaults );

        //Insert the log
        return wp_insert_post($args, $wp_error);

    }

    /**
     * Method to set or update an email log
     * @param object $email_log the email log to set
     * @param array  $data the data to process
     * @return bool
     */
    public function set_log(object $email_log, array $data = []){

        //Quick check
        if( empty($data) ){
            return false;
        }

        //Begin setting meta based on data given
        foreach($data as $key => $_data){

            //Quick check on data key
            if(is_int($key)){
                return false;
            }

            //Begin setting meta
            $this->set_meta($email_log->ID, $key, $_data);

        }

        return true;

    }

}