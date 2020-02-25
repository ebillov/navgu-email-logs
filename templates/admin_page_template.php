<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

//Get all the email logs
$email_logs = $this->get_logs();
?>

<div class="wrap">
    <h2>Navgu Email Logs</h2>
    <p>View contents of all emails sent from the site.</p>

    <?php if(!empty($email_logs)): ?>

        <table id="email_logs" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Recipients</th>
                    <th>Action</th>
                    <th>Subject</th>
                    <th>Sent Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($email_logs as $log):
                    
                    //Set the data to encode in json
                    $data = [
                        'subject' => $log->post_title,
                        'content' => $log->post_content,
                        'recipients' => (!empty($this->get_meta($log->ID, 'all_recipients_email'))) ? implode( ', ', $this->get_meta($log->ID, 'all_recipients_email') ) : '',
                        'cc_email' => (!empty($this->get_meta($log->ID, 'cc_email'))) ? implode( ', ', $this->get_meta($log->ID, 'cc_email') ) : '',
                        'bcc_email' => (!empty($this->get_meta($log->ID, 'bcc_email'))) ? implode( ', ', $this->get_meta($log->ID, 'bcc_email') ) : '',
                        'from_email' => $this->get_meta($log->ID, 'from_email'),
                        'from_name' => $this->get_meta($log->ID, 'from_name'),
                        'attachments' => (!empty($this->get_meta($log->ID, 'attachments'))) ? implode( ', ', $this->get_meta($log->ID, 'attachments') ) : '',
                        'error_codes' => (!empty($this->get_meta($log->ID, 'error_codes'))) ? implode( ', ', $this->get_meta($log->ID, 'error_codes') ) : '',
                        'error_messages' => (!empty($this->get_meta($log->ID, 'error_messages'))) ? implode( ', ', $this->get_meta($log->ID, 'error_messages') ) : '',
                        'mail_status' => ucfirst( $this->get_meta($log->ID, 'mail_status') ),
                        'is_html' => $this->get_meta($log->ID, 'is_html'),
                    ];

                ?>
                    <tr>
                        <td>
                            <?php echo implode( ', ', $this->get_meta($log->ID, 'all_recipients_email') ); ?>
                        </td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-info btn-sm"
                                data-toggle="modal"
                                data-target="#email_content"
                                data-email="<?php echo $this->json_encode($data); ?>"
                                >
                                View Email
                            </button>
                        </td>
                        <td><?php echo $log->post_title; ?></td>
                        <td><?php echo $log->post_modified; ?></td>
                        <td><?php echo ucfirst( $this->get_meta($log->ID, 'mail_status') ); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                    <th>Recipients</th>
                    <th>Action</th>
                    <th>Subject</th>
                    <th>Sent Date</th>
                    <th>Status</th>
            </tfoot>

        </table>

    <?php else: ?>

        <p>There are no email logs found.</p>

    <?php endif; ?>

</div>


<!-- Modal -->
<div class="modal fade mt-5" id="email_content" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"class="text_break">
                    <span id="email_title" class="email_title"></span>
                    <span class="email_status">Status: <span id="email_status"></span></span>
                </h5>
            </div>
            <div class="modal-body">
                <div id="email_details" class="text_break"></div>
                <div id="email_attachments" class="text_break"></div>
                <hr>
                <h6>Email Content:</h6>
                <div id="email_content" class="text_break"></div>
                <div id="email_errors" class="hide_element">
                    <hr>
                    <h6>Error Codes</h6>
                    <p id="error_codes"></p>
                    <h6>Error Messages</h6>
                    <p id="error_messages"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>