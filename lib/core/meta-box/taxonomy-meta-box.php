<?php

add_action( 'admin_init', 'add_taxonomy_common_options' );

function add_taxonomy_common_options() {
    foreach ( get_taxonomies(
        array(
            'public' => true,
        )
    ) as $tax_name ) {
        $cat = new \TypeRocket\Register\Taxonomy($tax_name);
        $cat->setMainForm(function() {
            $form = tr_form();
            echo $form->image('image')->setLabel(__('Image'))->setHelp(__('图片尺寸：400x400','BT_TEXTDOMAIN'));
            echo $form->image('cover_image')->setLabel(__('Cover'))->setHelp(__('图片尺寸：1920x640','BT_TEXTDOMAIN'));
            echo $form->toggle('隐藏当前类别所有内容')->setName('is_exclude')->setText(__('Yes'));
        });
        \TypeRocket\Register\Registry::taxonomyFormContent( $cat );

        add_filter('manage_edit-'.$tax_name.'_columns', function($columns){
            $columns['image'] = __('Image');
            $columns['cover_image'] = __('Cover');
            $columns['is_exclude'] = __('前台显示');
            unset($columns['description']);
            return $columns;
        });

        add_filter('manage_'.$tax_name.'_custom_column', function ($value, $column_name, $term_id){
            switch ($column_name) {
                case 'image':
                    $value = wp_get_attachment_image(get_term_meta($term_id,'image')[0], 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
                    break;
                case 'cover_image':
                    $value = wp_get_attachment_image(get_term_meta($term_id,'cover_image')[0], 'thumbnail', '');
                    break;
                case 'is_exclude':
                    $value = (get_term_meta($term_id,'is_exclude')[0] == '1') ? __('隐藏','BT_TEXTDOMAIN') : __('显示','BT_TEXTDOMAIN');
                    break;  
                default:
                    break;
            }
            return $value;
        }, 10, 3);
    }
}