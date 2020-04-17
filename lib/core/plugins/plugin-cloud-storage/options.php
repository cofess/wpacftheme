<?php
if ( ! function_exists( 'add_action' )) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

// Setup Form
$form = tr_form()->useJson()->setGroup( 'storage' );
?>

<h1>Cloud Storage Setting</h1>
<div class="typerocket-container">
    <?php
    
    echo $form->open();

    // 七牛云
    $qiniuSetting = function() use ($form) {
        
    };

    // 阿里云OSS
    $ossSetting = function() use ($form) {

    };

    // 缩略图设置
    $thumbnailSetting = function() use ($form) {

    };

    // 远程图片
    $remoteSetting = function() use ($form) {

    };

    // 水印设置
    $watermarkSetting = function() use ($form) {

    };

    // Layout
    $tabs = tr_tabs();
    $tabs->addTab([
        'id'       => 'qiniu',
        'title'    => __('七牛云','BT_TEXTDOMAIN'),
        'callback' => $qiniuSetting
    ]);
    $tabs->addTab([
        'id'       => 'oss',
        'title'    => __('阿里云OSS','BT_TEXTDOMAIN'),
        'callback' => $ossSetting
    ]);
    $tabs->addTab([
        'id'       => 'thumbnail',
        'title'    => __('缩略图','BT_TEXTDOMAIN'),
        'callback' => $thumbnailSetting
    ]);
    $tabs->addTab([
        'id'       => 'remote',
        'title'    => __('远程图片','BT_TEXTDOMAIN'),
        'callback' => $remoteSetting
    ]);
    $tabs->addTab([
        'id'       => 'watermark',
        'title'    => __('水印设置','BT_TEXTDOMAIN'),
        'callback' => $watermarkSetting
    ]);
    $tabs->render();
    echo '<br/>';
    echo $form->close('Submit');
    ?>

</div>
