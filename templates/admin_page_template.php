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
                        'recipients' => implode( ', ', $this->get_meta($log->ID, 'all_recipients_email') ),
                        'cc_email' => implode( ', ', $this->get_meta($log->ID, 'cc_email') ),
                        'bcc_email' => implode( ', ', $this->get_meta($log->ID, 'bcc_email') ),
                        'from_email' => $this->get_meta($log->ID, 'from_email'),
                        'from_name' => $this->get_meta($log->ID, 'from_name'),
                        'attachments' => implode( ', ', $this->get_meta($log->ID, 'attachments') ),
                        'mail_status' => ucfirst( $this->get_meta($log->ID, 'mail_status') )
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="email_title">Modal title</h5>
                <h6>Status: <span id="email_status"></span></h6>
            </div>
            <div class="modal-body">
                <div id="email_details"></div>
                <h6>Email Content:</h6>
                <div id="email_content"></div>
                <div id="email_attachments"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>