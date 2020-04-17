<?php

/**
 * contact form 7 disable email
 * https://stackoverflow.com/questions/20016228/wordpress-contact-form-7-disable-email
 */
return function() 
{
    add_filter('wpcf7_before_send_mail', 'disable_cf7_email');

    function disable_cf7_email( $form)
    {
        $submission = WPCF7_Submission::get_instance();

        $submission->skip_mail = true;

    }
};
