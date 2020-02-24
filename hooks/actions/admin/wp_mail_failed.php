<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

/**
 * Action hook to get the failed mail message errors referenced at wp-includes/pluggable.php wp_mail() method
 */
add_action('wp_mail_failed', function($error){

    //Get the recipients from the error data
    $recipients = $error->get_error_data();
    $recipients = $recipients['to'];

    //Get the subject of the email log
    $subject = $error->get_error_data();
    $subject = $subject['subject'];

    //Get the email log
    $mail_log = $this->get_log($subject, $recipients);

    //Quick check
    if($mail_log !== false){

        //Set the email log
        $this->set_log(
            $mail_log,
            [
                'error_codes' => $error->get_error_codes(),
                'error_messages' => $error->get_error_messages(),
                'error_data' => $error->get_error_data(),
                'mail_status' => 'failed'
            ]
        );

    }

});