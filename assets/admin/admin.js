jQuery(document).ready(function(){

    //Initialize the datatable
    var $email_logs = jQuery('#email_logs').DataTable(
        {
            pageLength: 50, //Default page results
            dom: 'l<"subject_filter">frtip',
            initComplete: function(){

                //Insert the select element
                jQuery('div.subject_filter').html('<label>Filter by subject: ' + jQuery('#subject_filter_template').html());
                
                //Initialize the select2 library
                jQuery('div.subject_filter').find('#subject_filter').select2(
                    {
                        placeholder: 'Select or type a subject (Optional)'
                    }
                );

                //Attach event handler to select2 element
                jQuery('div.subject_filter').find('#subject_filter').on('change.select2', function(){

                    //Get the value
                    var subjects = jQuery(this).val();

                    //Quick check
                    if(subjects != null && subjects.length > 0){

                        //Loop through each values and modify content
                        for(var i = 0; i < subjects.length; i++){

                            //Regex escaping
                            subjects[i] = jQuery.fn.dataTable.util.escapeRegex(
                                subjects[i].split('_').join(' ') //Split to array
                            );

                        }

                        //Joing to regex patter with separator
                        subjects = subjects.join('|');

                        //Begin search in 3rd column via regex
                        $email_logs.column( 2 ).search(subjects, true, false).draw();

                    } else {
                        $email_logs.column( 2 ).search('').draw(); //Reset the table
                    }

                });

            },
            order: [[ 3, "desc" ]],
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                { responsivePriority: 3, targets: -1 }
            ]
        }
    );

    //For showing the email content modal
    jQuery('#email_content').on('show.bs.modal', function(e){

        //Get the elements
        var button = jQuery(e.relatedTarget),
            data = button.data('email'),
            modal = jQuery(this);

        //Change z-index property on left sidebar dashboard menu
        jQuery('#adminmenuwrap').css('z-index', 1000);

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

        modal.find('#email_content').html( (data.content_type == 'text/html') ? data.content : data.content.replace(/\n/g, '<br>') );

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

        //Remove z-index property
        jQuery('#adminmenuwrap').removeAttr('style');

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