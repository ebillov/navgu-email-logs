<?php
namespace NAVGU\Classes\Email_Logs;

use NAVGU\Classes\Email_Logs;

//Exit if accessed directly.
defined('ABSPATH') or exit;

class Email_Post_Type extends Email_Logs {

    /**
     * Our constructor
     */
    public function __construct(){
        $this->_register_post_type();
    }

    /**
     * Method to register our post type
     */
    public function _register_post_type(){

        add_action('init', function(){

            //Define labels
            $labels = array(
                'name'                  => 'Emails',
                'singular_name'         => 'Email',
                'menu_name'             => 'Emails',
                'name_admin_bar'        => 'Email',
                'add_new'               => 'Add New',
                'add_new_item'          => 'Add New Email',
                'new_item'              => 'New Email',
                'edit_item'             => 'Edit Email',
                'view_item'             => 'View Email',
                'all_items'             => 'All Emails',
                'search_items'          => 'Search Emails',
                'parent_item_colon'     => 'Parent Emails:',
                'not_found'             => 'No emails found.',
                'not_found_in_trash'    => 'No emails found in Trash.',
                'featured_image'        => 'Email Cover Image',
                'set_featured_image'    => 'Set cover image',
                'remove_featured_image' => 'Remove cover image',
                'use_featured_image'    => 'Use as cover image',
                'archives'              => 'Email archives',
                'insert_into_item'      => 'Insert into email',
                'uploaded_to_this_item' => 'Uploaded to this email',
                'filter_items_list'     => 'Filter emails list',
                'items_list_navigation' => 'Emails list navigation',
                'items_list'            => 'Emails list',
            );
         
            //Define the options
            $args = array(
                'labels'              => $labels,
                'description'         => 'Post type for email logs.',
                'public'              => true,
                'hierarchical'        => false,
                'publicly_queryable'  => false,
                'show_ui'             => false,
                'show_in_menu'        => false,
                'query_var'           => true,
                'rewrite'             => false,
                'exclude_from_search' => true,
                'supports'            => array( 'title', 'editor', 'custom-fields'),
            );

            //Register the post type
            register_post_type( 'email', $args );

        });

    }

}