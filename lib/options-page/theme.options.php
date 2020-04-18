<?php

function my_acf_add_local_field_groups() {
  if (!function_exists('acf_add_options_page')) {
    return;
  } 

  // $options = array();
  // require '_theme/base.fields.php';

  acf_add_local_field_group(array(
    'key' => 'group_5e6ec344a808e',
    'title' => 'Product image',
    'menu_order' => 5,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'fields' => array(
        array(
            'key' => 'field_5e6ec36ee4bbc',
            'label' => 'Product image',
            'name' => 'product_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'id',
            'preview_size' => 'full',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
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

  acf_add_local_field_group(array('key' => 'group_contact_info',
      'title' => 'Contact Info',
      'menu_order' => 0,
      'position' => 'normal',
      // 'style' => 'seamless',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
      'fields' => array (
        array (
            'key' => 'field_5bead261dabb4',
            'label' => '基础设置',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' =>  0,
            'conditional_logic' =>  0,
            'placement' =>  'top',
            "endpoint" =>  0
        ),
        array ('key' => 'field_1',
          'label' => 'Sub Title2',
          'name' => 'sub_title',
          'type' => 'text',
          ),
        array (
            'key' => 'field_2',
            'label' => '优化设置',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' =>  0,
            'conditional_logic' =>  0,
            'placement' =>  'top',
            "endpoint" =>  0
        ),
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
