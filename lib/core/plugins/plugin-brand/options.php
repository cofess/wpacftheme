<?php
if ( ! function_exists( 'add_action' )) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

// Setup Form
$form = tr_form()->useJson()->setGroup('brand_options');
?>

<div class="typerocket-container">
    <?php
    echo $form->open();

    // Profile Setting
    $profileSetting = function() use ($form) {
        echo $form->row(
            $form->toggle('PC端首页显示')->setName('module_profile_display')->setText(__('Yes')), 
            $form->toggle('移动端首页显示')->setName('m_module_profile_display')->setText(__('Yes')),
            $form->toggle('显示模块下边距')->setName('show_module_profile_margin')->setText(__('Yes'))
        );
        echo $form->row(
            $form->text(__('Module Prefix Class','BT_TEXTDOMAIN'))->setName('module_profile_prefix_class')
        );
        echo $form->row(
            $form->text(__('模块标题','BT_TEXTDOMAIN'))->setName('module_profile_title'), 
            $form->text(__('模块副标题','BT_TEXTDOMAIN'))->setName('module_profile_subtitle')
        );
        echo $form->editor(__('模块描述','BT_TEXTDOMAIN'))->setName('module_profile_description');
        echo $form->row(
            $form->image('PC端背景图')->setName('module_profile_image')->setSetting('button', 'Insert Image'),
            $form->image('移动端背景图')->setName('m_module_profile_image')->setSetting('button', 'Insert Image')
        );
        echo $form->toggle('显示ViewMore链接')->setName('show_more')->setText(__('Yes'));
        echo $form->row(
            $form->text(__('ViewMore链接文本','BT_TEXTDOMAIN'))->setName('more_text')->setSetting('default', __('关于我们','BT_TEXTDOMAIN')),
            $form->text(__('ViewMore链接URL','BT_TEXTDOMAIN'))->setName('more_url')
        );

        $generalTabs = tr_tabs();

        $tabContentOne = function() use ($form) {
            // echo '<h3>'.__('基本信息','BT_TEXTDOMAIN').'</h3>';
            echo $form->row(
                $form->text(__('公司名称','BT_TEXTDOMAIN'))->setName('company'),
                $form->text(__('公司创建于哪一年？','BT_TEXTDOMAIN'))->setName('year')
            );
            echo $form->row(
                $form->text(__('广告语Slogan','BT_TEXTDOMAIN'))->setName('slogan'),
                $form->text(__('宣传视频','BT_TEXTDOMAIN'))->setName('video')
            );
            echo $form->editor(__('公司简介','BT_TEXTDOMAIN'))->setName('profile');
        };

        $tabContentTwo = function() use ($form) {
            // echo '<h3>'.__('联系方式','BT_TEXTDOMAIN').'</h3>';
            echo $form->row(
                $form->text(__('邮箱','BT_TEXTDOMAIN'))->setName('email'),
                $form->text(__('手机','BT_TEXTDOMAIN'))->setName('mobile'),
                $form->text(__('电话','BT_TEXTDOMAIN'))->setName('tel'),
                $form->text(__('传真','BT_TEXTDOMAIN'))->setName('fax')
            );
            echo '<div>温馨提示：邮箱、手机、电话支持多个，多个使用英文逗号","隔开，否则无法正常识别</div><br/>';
                    
            echo $form->row(
                $form->text(__('Skype','BT_TEXTDOMAIN'))->setName('skype'),
                $form->text(__('WhatsApp','BT_TEXTDOMAIN'))->setName('whatsapp'),
                $form->text(__('QQ','BT_TEXTDOMAIN'))->setName('qq'),
                $form->text(__('微信公众号','BT_TEXTDOMAIN'))->setName('wechat')
            );

            echo $form->row(
                $form->text(__('办公地址','BT_TEXTDOMAIN'))->setName('address'),
                $form->text(__('地图链接','BT_TEXTDOMAIN'))->setName('map')
            );

            echo $form->row(
                $form->text(__('工厂地址','BT_TEXTDOMAIN'))->setName('factory_address'),
                $form->text(__('地图链接','BT_TEXTDOMAIN'))->setName('factory_map')
            );   
        };

        $tabContentThree = function() use ($form) {
            // echo '<h3>'.__('社交媒体','BT_TEXTDOMAIN').'</h3>';
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
            echo $form->image(__('微信公众号二维码','BT_TEXTDOMAIN'))->setName('wechat_qrcode');
        };

        $generalTabs->addTab([
            'id'       => 'profile-info-setting',
            'title'    => __('基本信息','BT_TEXTDOMAIN'),
            'callback' => $tabContentOne
        ]);
        $generalTabs->addTab([
            'id'       => 'profile-contact-setting',
            'title'    => __('联系方式','BT_TEXTDOMAIN'),
            'callback' => $tabContentTwo
        ]);
        $generalTabs->addTab([
            'id'       => 'profile-social-setting',
            'title'    => __('社交媒体','BT_TEXTDOMAIN'),
            'callback' => $tabContentThree
        ]);

        $generalTabs->render();        
    };

    // Values Setting
    $valueSetting = function() use ($form) {
        echo $form->row(
            $form->text(__('模块标题','BT_TEXTDOMAIN'))->setName('module_value_title'), 
            $form->text(__('模块副标题','BT_TEXTDOMAIN'))->setName('module_value_subtitle')
        );
        echo $form->editor(__('模块描述','BT_TEXTDOMAIN'))->setName('module_value_description');
        echo $form->repeater(__('价值观','BT_TEXTDOMAIN'))->setName('values')->setFields([
            $form->row(
                $form->column(
                    $form->text(__('Title'))->setName('title'), 
                    $form->textarea(__('Content'))->setName('description')
                ),
                $form->column(
                    $form->image(__('Image'))->setName('image')
                )   
            )
        ]);
    };

    // Honor Setting
    $honorSetting = function() use ($form) {
        echo $form->row(
            $form->text(__('模块标题','BT_TEXTDOMAIN'))->setName('module_honor_title'), 
            $form->text(__('模块副标题','BT_TEXTDOMAIN'))->setName('module_honor_subtitle')
        );
        echo $form->editor(__('模块描述','BT_TEXTDOMAIN'))->setName('module_honor_description');
        echo $form->gallery(__('资质证书','BT_TEXTDOMAIN'))->setName('certificates');
    };

    // Brand Story Setting
    $storySetting = function() use ($form) {
        echo $form->row(
            $form->text(__('模块标题','BT_TEXTDOMAIN'))->setName('module_story_title'), 
            $form->text(__('模块副标题','BT_TEXTDOMAIN'))->setName('module_story_subtitle')
        );
        echo $form->editor(__('模块描述','BT_TEXTDOMAIN'))->setName('module_story_description');
        echo $form->repeater(__('发展历程','BT_TEXTDOMAIN'))->setName('stories')->setFields([
            $form->row(
                $form->column(
                    $form->text(__('Time','BT_TEXTDOMAIN'))->setName('date'),
                    $form->textarea(__('事件','BT_TEXTDOMAIN'))->setName('event')
                ),
                $form->column(
                    $form->image(__('Image'))->setName('image')
                )   
            )
	    ]);
    };

    // Data Setting
    $dataSetting = function() use ($form) {
        echo $form->row(
            $form->toggle('PC端首页显示')->setName('module_data_display')->setText(__('Yes')), 
            $form->toggle('移动端首页显示')->setName('m_module_data_display')->setText(__('Yes')),
            $form->toggle('显示模块下边距')->setName('show_module_data_margin')->setText(__('Yes'))
        );
        echo $form->row(
            $form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('module_data_limit')->setSetting('default', 8), 
            $form->text(__('Module Prefix Class','BT_TEXTDOMAIN'))->setName('module_data_prefix_class')
        );
        echo $form->row(
            $form->text(__('模块标题','BT_TEXTDOMAIN'))->setName('module_data_title'), 
            $form->text(__('模块副标题','BT_TEXTDOMAIN'))->setName('module_data_subtitle')
        );
        echo $form->editor(__('模块描述','BT_TEXTDOMAIN'))->setName('module_data_description');
        echo $form->row(
            $form->image('PC端背景图')->setName('module_data_image')->setSetting('button', 'Insert Image'),
            $form->image('移动端背景图')->setName('m_module_data_image')->setSetting('button', 'Insert Image')
        );
        echo $form->repeater(__('数据展示','BT_TEXTDOMAIN'))->setName('datas')->setFields([
            $form->row(
                $form->text(__('数据','BT_TEXTDOMAIN'))->setName('data'), 
                $form->text(__('后缀','BT_TEXTDOMAIN'))->setName('suffix')
            ),
            $form->row(
                $form->text(__('说明','BT_TEXTDOMAIN'))->setName('description'), 
                $form->text(__('图标（<a href="http://www.fontawesome.com.cn/" target="_blank">Font Awesome</a>）','BT_TEXTDOMAIN'))->setName('icon')
            )
	    ]);
    };

    // Feature Setting
    $featureSetting = function() use ($form) {
        echo $form->row(
            $form->toggle('PC端首页显示')->setName('module_feature_display')->setText(__('Yes')), 
            $form->toggle('移动端首页显示')->setName('m_module_feature_display')->setText(__('Yes')),
            $form->toggle('显示模块下边距')->setName('show_module_feature_margin')->setText(__('Yes'))
        );
        echo $form->row(
            $form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('module_feature_limit')->setSetting('default', 8), 
            $form->text(__('Module Prefix Class','BT_TEXTDOMAIN'))->setName('module_feature_prefix_class')
        );
        echo $form->row(
            $form->text(__('模块标题','BT_TEXTDOMAIN'))->setName('module_feature_title'), 
            $form->text(__('模块副标题','BT_TEXTDOMAIN'))->setName('module_feature_subtitle')
        );
        echo $form->editor(__('模块描述','BT_TEXTDOMAIN'))->setName('module_feature_description');
        echo $form->row(
            $form->image('PC端背景图')->setName('module_feature_image')->setSetting('button', 'Insert Image'),
            $form->image('移动端背景图')->setName('m_module_feature_image')->setSetting('button', 'Insert Image')
        );
        echo $form->repeater(__('核心优势','BT_TEXTDOMAIN'))->setName('features')->setFields([
            $form->row(
                $form->column(
                    $form->text(__('Title'))->setName('title'), 
                    $form->text(__('Link'))->setName('url'),
                    $form->text(__('图标（<a href="http://www.fontawesome.com.cn/" target="_blank">Font Awesome</a>）','BT_TEXTDOMAIN'))->setName('icon')
                ),
                $form->column(
                    $form->textarea(__('Content'))->setName('description')->setAttribute('style', "min-height:167px")
                )   
            )
	    ]);
    };

    // Partners Setting
    $partnerSetting = function() use ($form) {
        echo $form->row(
            $form->toggle('PC端首页显示')->setName('module_partner_display')->setText(__('Yes')), 
            $form->toggle('移动端首页显示')->setName('m_module_partner_display')->setText(__('Yes')),
            $form->toggle('显示模块下边距')->setName('show_module_partner_margin')->setText(__('Yes'))
        );
        echo $form->row(
            $form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('module_partner_limit')->setSetting('default', 12), 
            $form->text(__('Module Prefix Class','BT_TEXTDOMAIN'))->setName('module_partner_prefix_class')
        );
        echo $form->row(
            $form->text(__('模块标题','BT_TEXTDOMAIN'))->setName('module_partner_title'), 
            $form->text(__('模块副标题','BT_TEXTDOMAIN'))->setName('module_partner_subtitle')
        );
        echo $form->editor(__('模块描述','BT_TEXTDOMAIN'))->setName('module_partner_description');
        echo $form->row(
            $form->image('PC端背景图')->setName('module_partner_image')->setSetting('button', 'Insert Image'),
            $form->image('移动端背景图')->setName('m_module_partner_image')->setSetting('button', 'Insert Image')
        );
        echo $form->repeater(__('合作伙伴','BT_TEXTDOMAIN'))->setName('partners')->setFields([
            $form->row(
                $form->column(
                    $form->text(__('公司名','BT_TEXTDOMAIN'))->setName('name'),
                    $form->textarea(__('Content'))->setName('description')
                ),
                $form->column(
                    $form->image(__('Logo','BT_TEXTDOMAIN'))->setName('logo')
                )   
            ) 
	    ]);
    };

    // Layout
    $config = \TypeRocket\Core\Config::locate('typerocket.plugin-brand.options');
    $tabs = tr_tabs();
    $tabs->addTab([
        'id'       => 'brand-info',
        'title'    => __('公司信息','BT_TEXTDOMAIN'),
        'callback' => $profileSetting
    ]);

    if(in_array('brand-values',$config)){
        $tabs->addTab([
            'id'       => 'brand-values',
            'title'    => __('文化价值观','BT_TEXTDOMAIN'),
            'callback' => $valueSetting
        ]);
    }

    if(in_array('brand-honors',$config)){
        $tabs->addTab([
            'id'       => 'brand-honors',
            'title'    => __('企业荣誉','BT_TEXTDOMAIN'),
            'callback' => $honorSetting
        ]);
    }

    if(in_array('brand-story',$config)){
        $tabs->addTab([
            'id'       => 'brand-story',
            'title'    => __('发展历程','BT_TEXTDOMAIN'),
            'callback' => $storySetting
        ]);
    }

    if(in_array('brand-data',$config)){
        $tabs->addTab([
            'id'       => 'brand-data',
            'title'    => __('数据展示','BT_TEXTDOMAIN'),
            'callback' => $dataSetting
        ]);
    }

    if(in_array('brand-features',$config)){
        $tabs->addTab([
            'id'       => 'brand-features',
            'title'    => __('核心优势','BT_TEXTDOMAIN'),
            'callback' => $featureSetting
        ]);
    }

    if(in_array('brand-partners',$config)){
        $tabs->addTab([
            'id'       => 'brand-partners',
            'title'    => __('合作伙伴','BT_TEXTDOMAIN'),
            'callback' => $partnerSetting
        ]);
    }

    $tabs->render();
    
    echo '<br/>';
    echo $form->close('Submit');
    ?>

</div>
