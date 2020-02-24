<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

$email_logs = $this->get_logs();
?>
<div class="wrap">
    <h2><?php echo __('Navgu Email Logs'); ?></h2>
    <p>test</p>
    <pre>
    <?php
    $mail = $email_logs[0];
    var_dump( $this->get_meta($mail->ID, 'mail_status') );
    ?>
    </pre>
</div>