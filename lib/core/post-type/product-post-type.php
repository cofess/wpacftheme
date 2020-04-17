<?php

// Register Post Type
$product = tr_post_type(__('产品','BT_TEXTDOMAIN'), __('产品','BT_TEXTDOMAIN'));
$product->setId('product');
$product->setArgument('supports', ['title','editor','excerpt','comments','page-attributes'] );
// add tags
$product->addTaxonomy('post_tag');

// Chain Methods with Eloquence
$product->setIcon('cube')
    ->setArchivePostsPerPage(-1);

// Add Taxonomy
tr_taxonomy(__('Product Category','BT_TEXTDOMAIN'), __('Product Categories','BT_TEXTDOMAIN'))
->setId('product_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($product);

tr_taxonomy(__('Product Brand','BT_TEXTDOMAIN'), __('Product Brands','BT_TEXTDOMAIN'))
->setId('product_brand')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($product);

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($product);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $tabs = tr_tabs();
    $form = tr_form();

    // product params tab
    $productParamsTab = function() use ($form){
        echo $form->row(
            $form->text(__('产品型号','BT_TEXTDOMAIN'))->setName('model'),  
            $form->text(__('产地','BT_TEXTDOMAIN'))->setName('source')->setSetting('default', 'China')
        );
        echo $form->row(
            $form->text(__('产能','BT_TEXTDOMAIN'))->setName('capacity'),  
            $form->text(__('最小起订量','BT_TEXTDOMAIN'))->setName('moq')->setType('number')->setSetting('default', 1)
        );
        echo $form->repeater(__('添加自定义参数','BT_TEXTDOMAIN'))->setName('params')->setFields([
            $form->row(
                $form->text(__('参数名','BT_TEXTDOMAIN'))->setName('field'), 
                $form->text(__('参数值','BT_TEXTDOMAIN'))->setName('value')
            )
        ]);
    };

    // product extra tab
    $productExtraTab = function() use ($form){
        echo $form->editor(__('产品亮点','BT_TEXTDOMAIN'))->setName('point');
        echo $form->text(__('产品视频','BT_TEXTDOMAIN'))->setName('video');
        echo $form->row(
            $form->text(__('Amazon亚马逊购买链接','BT_TEXTDOMAIN'))->setName('amazon_url'),
            $form->text(__('阿里巴巴购买链接','BT_TEXTDOMAIN'))->setName('alibaba_url')
        );
    };

    $tabs->addTab([
        'id'       => 'product-params',
        'title'    => __('产品参数','BT_TEXTDOMAIN'),
        'callback' => $productParamsTab
    ]);

    $post_types = \TypeRocket\Core\Config::locate('typerocket.post-types');
    if(in_array("faq", $post_types)){
        // product faq tab
        $productFaqTab = function() use ($form){
            echo $form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('常见问题','BT_TEXTDOMAIN'));
            echo $form->repeater(__('Add'))->setName('lists')->setFields([
                $form->search('Search')->setName('item')->setPostType('faq')
            ]);
        };

        $tabs->addTab([
            'id'       => 'product-faq',
            'title'    => __('常见问题','BT_TEXTDOMAIN'),
            'callback' => $productFaqTab
        ]);
    }
                
    $tabs->addTab([
        'id'       => 'product-extra',
        'title'    => __('其他信息','BT_TEXTDOMAIN'),
        'callback' => $productExtraTab
    ]);
                
    $tabs->render();
});

// Add Custom Side MetaBox
$sideBox = tr_meta_box('custom_extra_box')->apply($product);
$sideBox->setLabel(__('images'));
$sideBox->setContext('side');
$sideBox->setPriority('default');
$sideBox->setCallback(function(){
    $form = tr_form();
    echo $form->gallery(__('images','BT_TEXTDOMAIN'))->setName('images')->setLabel('')->setHelp(__('<font color="red">产品图片尺寸：800x800，默认使用第一张图片作为产品主图，温馨提示：拖动图片可以调整图片顺序</font>','BT_TEXTDOMAIN'));
});

// Add Sortable Columns to Admin Index View
$product->addColumn('images', false, __('Image'), function($value) {
    echo wp_get_attachment_image($value[0], 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$product->setRest('product');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('product', 'product_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('product', 'product_category') );

add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('product', 'product_brand') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('product', 'product_brand') );

// Custom Post Type Set Comments Open
function productType_comments_on( $data ) {
    if( $data['post_type'] == 'product' ) {
        $data['comment_status'] = 'open';
    }
    return $data;
}
add_filter('wp_insert_post_data', 'productType_comments_on');

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
    add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('product','product_category')]);
}
