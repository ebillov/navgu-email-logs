<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

//Action hook that will trigger when viewing the targeted admin page
add_action('current_screen', function($current_screen){

    //Only do this for the targeted admin page
    if($current_screen->base == 'toplevel_page_navgu-email-logs'){
        
        //Add the scripts
        add_action('admin_enqueue_scripts', function(){

            wp_enqueue_script('jquery');

            //Bootstrap
            wp_enqueue_script(
                'bootstrap',
                NEL_DIR_URL . 'lib/bootstrap/js/bootstrap.min.js',
                [],
                '4.4.1'
            );
            wp_enqueue_style(
                'bootstrap',
                NEL_DIR_URL . 'lib/bootstrap/css/bootstrap.min.css',
                [],
                '4.4.1'
            );

            //Datatables
            wp_enqueue_script(
                'navgu-email-logs-datatables',
                NEL_DIR_URL . 'lib/datatables/datatables.min.js',
                ['jquery'],
                '1.10.20'
            );
            wp_enqueue_style(
                'navgu-email-logs-datatables',
                NEL_DIR_URL . 'lib/datatables/datatables.min.css',
                [],
                '1.10.20'
            );

            //Our custom script
            wp_enqueue_script(
                'navgu-email-logs-admin',
                NEL_DIR_URL . 'assets/admin/admin.js',
                ['jquery'],
                NEL()->version,
                true
            );

            //Our custom CSS
            wp_enqueue_style(
                'navgu-email-logs-admin',
                NEL_DIR_URL . 'assets/admin/admin.css',
                [],
                NEL()->version
            );
            
        });
        
    }

});