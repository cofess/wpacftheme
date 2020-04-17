<?php

/*
|--------------------------------------------------------------------------
| 快速编辑-修改文章缩略图
|--------------------------------------------------------------------------
| https://rudrastyh.com/wordpress/quick-edit-featured-image.html
*/

return function ($option)
{
    add_action('quick_edit_custom_box',  'misha_add_featured_image_quick_edit', 10, 2);
    function misha_add_featured_image_quick_edit( $column_name, $post_type ) {
     
        // add it only if we have featured image column
        if ($column_name != 'image') return;
     
        // we add #misha_featured_image to use it in JavaScript in CSS
        echo '<fieldset id="misha_featured_image" class="inline-edit-col-left">
            <div class="inline-edit-col">
                <span class="title">Featured Image</span>
                <div>
                    <a href="#" class="misha_upload_featured_image">Set featured image</a>
                    <input type="hidden" name="_thumbnail_id" value="" />
                    <a href="#" class="misha_remove_featured_image">Remove Featured Image</a>
                </div>
            </div></fieldset>';
     
            // please look at _thumbnail_id as a name attribute - I use it to skip save_post action
     
    }

    // add_action( 'admin_enqueue_scripts', 'enqueue_media_scrip' );
    function enqueue_media_script() {
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
    }

    function enqueue_quick_edit_script() {
    ?>
        <script>
        jQuery(function($) {
          $('body').on('click', '.misha_upload_featured_image', function(e) {
            e.preventDefault();
            var button = $(this),
              custom_uploader = wp.media({
                title: 'Set featured image',
                library: {
                  type: 'image'
                },
                button: {
                  text: 'Set featured image'
                },
              }).on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $(button).html('<img src="' + attachment.url + '" />').next().val(attachment.id).parent().next().show();
              }).open();
          });

          $('body').on('click', '.misha_remove_featured_image', function() {
            $(this).hide().prev().val('-1').prev().html('Set featured Image');
            return false;
          });

          var $wp_inline_edit = inlineEditPost.edit;
          inlineEditPost.edit = function(id) {
            $wp_inline_edit.apply(this, arguments);
            var $post_id = 0;
            if (typeof(id) == 'object') {
              $post_id = parseInt(this.getId(id));
            }

            if ($post_id > 0) {
              var $edit_row = $('#edit-' + $post_id),
                $post_row = $('#post-' + $post_id),
                $featured_image = $('.column-image', $post_row).html(),
                $featured_image_id = $('.column-image', $post_row).find('img').attr('data-id');

              if ($featured_image_id != -1) {
                $(':input[name="_thumbnail_id"]', $edit_row).val($featured_image_id); // ID
                $('.misha_upload_featured_image', $edit_row).html($featured_image); // image HTML
                $('.misha_remove_featured_image', $edit_row).show(); // the remove link
              }
            }
          }
        });
        </script>
    <?php
    }

    add_action('admin_footer', 'load_quick_edit_js');
    function load_quick_edit_js() {
     
        global $current_screen;
        
        // add this JS function only if we are on all posts page
        if (($current_screen->base != 'edit') && ($current_screen->post_type == ''))
            return;
        
        add_action( 'admin_enqueue_scripts', 'enqueue_media_scrip' );
        enqueue_quick_edit_script();
    }
};