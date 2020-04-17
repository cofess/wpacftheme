<?php

// Register Post Type
$office = tr_post_type(__('分公司','BT_TEXTDOMAIN'), __('分公司','BT_TEXTDOMAIN'));
$office->setId('office');
$office->setArgument('supports', ['title','thumbnail','page-attributes'] );

// disable permalink
$office->setArgument('public', false);
$office->setArgument('show_ui', true);

// disable archive page
$office->setArgument('has_archive', false);

// parent menu
$office->setArgument('show_in_menu', 'brand');

// Chain Methods with Eloquence
$office->setIcon('office')
    ->setArchivePostsPerPage(-1)
    ->setTitleForm( function() {
        $form = tr_form();

        echo '<h3 class="title">'.__('基本信息','BT_TEXTDOMAIN').'</h3>';

        echo $form->row(
            $form->text(__('公司名称','BT_TEXTDOMAIN'))->setName('company'),
            $form->text(__('别名','BT_TEXTDOMAIN'))->setName('slug'),
            $form->text(__('联系人','BT_TEXTDOMAIN'))->setName('name')
        );
        
        echo $form->row(
            $form->text(__('邮箱','BT_TEXTDOMAIN'))->setName('email'),
            $form->text(__('手机','BT_TEXTDOMAIN'))->setName('mobile'),
            $form->text(__('电话','BT_TEXTDOMAIN'))->setName('tel'),
            $form->text(__('传真','BT_TEXTDOMAIN'))->setName('fax')
        );
        
        echo $form->row(
            $form->text(__('Skype','BT_TEXTDOMAIN'))->setName('skype'),
            $form->text(__('WhatsApp','BT_TEXTDOMAIN'))->setName('whatsapp'),
            $form->text(__('QQ','BT_TEXTDOMAIN'))->setName('qq'),
            $form->text(__('微信公众号','BT_TEXTDOMAIN'))->setName('wechat')
        );

        echo $form->row(
            $form->text(__('地址','BT_TEXTDOMAIN'))->setName('address'),
            $form->text(__('地图','BT_TEXTDOMAIN'))->setName('map')
        );

        echo $form->location(__('地理位置','BT_TEXTDOMAIN'))->setName('location');

        echo $form->text(__('网站','BT_TEXTDOMAIN'))->setName('site');

        echo '<h3 class="title">'.__('社交媒体','BT_TEXTDOMAIN').'</h3>';

        echo $form->row( 
            $form->text(__('Facebook','BT_TEXTDOMAIN'))->setName('facebook'),
            $form->text(__('Twitter','BT_TEXTDOMAIN'))->setName('twitter')
        );
        echo $form->row(
            $form->text(__('Google Plus','BT_TEXTDOMAIN'))->setName('google-plus'),
            $form->text(__('Pinterest','BT_TEXTDOMAIN'))->setName('pinterest')
        );
        echo $form->row(
            $form->text(__('Instagram','BT_TEXTDOMAIN'))->setName('instagram'),
            $form->text(__('LinkedIn','BT_TEXTDOMAIN'))->setName('linkedin')
        );

        echo $form->text(__('微博','BT_TEXTDOMAIN'))->setName('weibo');

        echo '<h3 class="title">'.__('其他信息','BT_TEXTDOMAIN').'</h3>';

        echo $form->editor(__('备注','BT_TEXTDOMAIN'))->setName('note');
        echo $form->image(__('微信公众号二维码','BT_TEXTDOMAIN'))->setName('wechat_qrcode');
    }); 

// Add Taxonomy
tr_taxonomy(__('Office Category','BT_TEXTDOMAIN'), __('Office Categories','BT_TEXTDOMAIN'))
->setId('office_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($office);

// Add Sortable Columns to Admin Index View
$office->addColumn('slug', true, __('别名','BT_TEXTDOMAIN'));

$office->addColumn('company', true, __('公司名称','BT_TEXTDOMAIN'));

$office->addColumn('thumbnail', false, __('Image'), function($id) {
	$post_thumbnail_id = get_post_thumbnail_id( $id );
    echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$office->setRest('office');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('office', 'office_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('office', 'office_category') );
