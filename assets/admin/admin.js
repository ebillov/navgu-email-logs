jQuery(document).ready(function(){

    //Initialize the datatable
    jQuery('#email_logs').DataTable(
        {
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                { responsivePriority: 3, targets: -1 }
            ]
        }
    );

    //For showing the email content modal
    jQuery('#email_content').on('shown.bs.modal', function(e){

        //Get the elements
        var button = jQuery(e.relatedTarget),
            data = button.data('email'),
            modal = jQuery(this);

        //Render to modal template
        modal.find('#email_title').html(data.subject);
        modal.find('#email_status').html(data.mail_status);

        //Color the email status string
        switch(data.mail_status){
            case 'Failed':
                modal.find('#email_status').addClass('text-danger');

                //Render details of error messages
                modal.find('#email_errors').removeClass('hide_element').find('#error_codes').html(data.error_codes);
                modal.find('#email_errors').removeClass('hide_element').find('#error_messages').html(data.error_codes);

                break;
            case 'Sent':
                modal.find('#email_status').addClass('text-success');
                break;
        }

        if(data.recipients != ''){
            modal.find('#email_details').append('<p><b>Recipients: </b>' + data.recipients + '</p>');
        }
        if(data.cc_email != ''){
            modal.find('#email_details').append('<p><b>Cc: </b>' + data.cc_email + '</p>');
        }
        if(data.bcc_email != ''){
            modal.find('#email_details').append('<p><b>Bcc: </b>' + data.bcc_email + '</p>');
        }
        if(data.from_name != ''){
            modal.find('#email_details').append('<p><b>From Name: </b>' + data.from_name + '</p>');
        }
        if(data.from_email != ''){
            modal.find('#email_details').append('<p><b>From Email: </b>' + data.from_email + '</p>');
        }

        modal.find('#email_content').html( (data.is_html) ? data.content : data.content.replace(/\n/g, '<br>') );

        if(data.attachments != ''){
            modal.find('#email_attachments').html('<p><b>Attachments: </b>' + data.attachments + '</p>');
        }

    });

    //For showing the email content modal
    jQuery('#email_content').on('hidden.bs.modal', function(e){

        //Get the elements
        var button = jQuery(e.relatedTarget),
            data = button.data('email'),
            modal = jQuery(this);

        //Empty the html containers
        modal.find('#email_title').html('');
        modal.find('#email_status').html('').removeClass('text-success').removeClass('text-danger');
        modal.find('#email_errors').addClass('hide_element').find('#error_codes').html('');
        modal.find('#email_errors').addClass('hide_element').find('#error_messages').html('');
        modal.find('#email_details').html('');
        modal.find('#email_content').html('');
        modal.find('#email_attachments').html('');

    });

});