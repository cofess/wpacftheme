<?php

function my_acf_add_local_field_groups() {
  if (!function_exists('acf_add_options_page')) {
    return;
  } 

  acf_add_local_field_group(array('key' => 'group_cso_contact_info',
      'title' => 'Contact Info',
      'fields' => array (
        array ('key' => 'field_1',
          'label' => 'Sub Title',
          'name' => 'sub_title',
          'type' => 'text',
          )
        ),
      'location' => array (
        array (
          array ('param' => 'options_page',
            'operator' => '==',
            'value' => 'acf-options-contact-info',
            ),
          ),
        ),
      ));
} 

add_action('acf/init', 'my_acf_add_local_field_groups');
