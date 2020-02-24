<?php
namespace NAVGU\Classes\Email_Logs;

use NAVGU\Classes\Email_Logs;

//Exit if accessed directly.
defined('ABSPATH') or exit;

class Admin_Menu extends Email_Logs {

    /**
     * Our constructor
     */
    public function __construct(){
        $this->_admin_menu();
        $this->_action_hooks();
    }

    /**
     * Method to add the admin menu page
     */
    public function _admin_menu(){
    
        add_action('admin_menu', function(){
            add_menu_page(
                'Navgu Email Logs',
                'Email Logs',
                'administrator',
                'navgu-email-logs',
                [$this, '_admin_page_template'],
                '',
                4
            );
        });

    }

    /**
     * Method to output the page template
     */
    public function _admin_page_template(){
        include_once NEL_DIR_PATH . 'templates/admin_page_template.php';
    }

    /**
     * Method to initialize action hooks
     */
    public function _action_hooks(){

        //Admin hooks
        include_once NEL_DIR_PATH . 'hooks/actions/admin/current_screen.php';

    }

}