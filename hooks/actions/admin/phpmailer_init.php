<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

/**
 * Action hook to get the phpmailer referenced from wp-includes/pluggable.php wp_mail() method
 */
add_action('phpmailer_init', function($phpmailer){

    //Log the phpmailer contents
    $log_id = self::add_log(
        [
            'post_title' => $phpmailer->Subject,
            'post_content' => $phpmailer->Body,
        ]
    );

    //Quick check
    if($log_id > 0){
        $this->set_meta($log_id, 'all_recipients_email', $phpmailer->getAllRecipientAddresses());
        $this->set_meta($log_id, 'cc_email', $phpmailer->getCcAddresses());
        $this->set_meta($log_id, 'bcc_email', $phpmailer->getBccAddresses());
        $this->set_meta($log_id, 'from_email', $phpmailer->From);
        $this->set_meta($log_id, 'from_name', $phpmailer->FromName);
        $this->set_meta($log_id, 'attachments', $phpmailer->getAttachments());
        $this->set_meta($log_id, 'mail_status', 'success');
    }

});