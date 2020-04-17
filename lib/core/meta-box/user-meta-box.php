<?php

add_action('tr_user_profile', function($user) {
    $form = tr_form();
    echo '<h2>'.__('其他信息','BT_TEXTDOMAIN').'</h2>';
    echo $form->text(__('手机号','BT_TEXTDOMAIN'))->setName('mobile');
    echo $form->text(__('职位','BT_TEXTDOMAIN'))->setName('position');
});

/**
 * Customize WordPress User Profile’s Contact Info
 * https://w3guy.com/customize-wordpress-user-profiles-contact-info/
 */
function modify_user_contact_methods( $user_contact ){
	/* Add user contact methods */
	$user_contact['facebook'] = __('Facebook Username'); 
	$user_contact['twitter'] = __('Twitter Username');
	$user_contact['google'] = __('Google+ Profile');

	return $user_contact;
}

add_filter('user_contactmethods', 'modify_user_contact_methods');
