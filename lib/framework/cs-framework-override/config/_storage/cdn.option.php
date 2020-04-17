<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

$coupon_div = '
    <div id="qiniu_coupon" style="display:none;">
    <p>简单说使用<strong>WordPress插件用户专属的优惠码</strong>“<strong style="color:red;">d706b222</strong>”充值，一次性充值2000元及以内99折，2000元以上则95折</strong>，建议至少充值2001元。详细使用流程：</p>
    <p>1. 登陆<a href="https://portal.qiniu.com/signup?code=3liqw9t56d1ea" target="_blank">七牛开发者平台</a></p>
    <p>2. 然后点击“充值”，进入充值页面</p>
    <p>3. 点击“使用优惠码”，并输入优惠码“<strong><span style="color:red;">d706b222</span></strong>”，点击“使用”。</p>
    <p>4. 输入计划充值的金额，点击“马上充值”，进入支付宝页面，完成支付。</p>
    <p>5. 完成支付后，可至财务->>财务概况->>账户余额 查看实际到账金额。</p>
    </div>';

$cdn_html = '
    <p>七牛云存储用户：请点击这里注册和申请<a href="https://portal.qiniu.com/signup?code=3liqw9t56d1ea" target="_blank">七牛云</a>，充值可以使用用户专属的优惠码：“<span style="color:red; font-weight:bold;">d706b222</span>”，点击查看<strong><a title="如何使用七牛云存储的优惠码" class="thickbox" href="#TB_inline?width=600&height=300&inlineId=qiniu_coupon">详细使用指南</a></strong>。</p>
    <p>阿里云OSS用户：请点击这里注册和申请<a href="https://promotion.aliyun.com/ntms/yunparter/invite.html?userCode=ypdz34gi" target="_blank">阿里云</a>可获得代金券。</p>
    <p>腾讯云COS用户：请点击这里注册和申请<a href="https://cloud.tencent.com/developer/support-plan?invite_code=2rj0fnjo7e04s" target="_blank">腾讯云</a>可获得优惠券。</p>
    '.$coupon_div;

$remote_html = '
    <h4>'.__('远程图片设置','CS_TEXTDOMAIN').'</h4>
    <ul>
        <li>'.__('· 自动将远程图片镜像到七牛需要你的博客支持固定链接。','CS_TEXTDOMAIN').'</li>
        <li>'.__('· 如果前面设置的静态文件域名和博客域名不一致，该功能也可能出问题。','CS_TEXTDOMAIN').'</li>
        <li>'.__('· 远程 GIF 图片保存到七牛将失去动画效果，所以目前不支持 GIF 图片。','CS_TEXTDOMAIN').'</li>
    </ul>';

// ------------------------------
// CDN设置         
// ------------------------------
$options[]   = array(
    'name'   => 'storage-cdn_section',
    'title'  => __('CDN设置','CS_TEXTDOMAIN'),
    'icon'   => 'fa fa-cloud-upload',
    'fields' => array( 

        array(
            'type'    => 'subheading',
            'content' => $cdn_html,
        ),
        
        array(
            'id'      => 'cdn-server',
            'type'    => 'select',
            'title'   => __('云存储','CS_TEXTDOMAIN'),
            'options' => array(
              'qiniu'      => __('七牛云存储','CS_TEXTDOMAIN'),
              'aliyun_oss' => __('阿里云OSS','CS_TEXTDOMAIN'),
              'qcloud_cos' => __('腾讯云COS','CS_TEXTDOMAIN'),
            ),
            'default_option' => __('请选择','CS_TEXTDOMAIN'),
        ),

        array(
            'id'         => 'host',
            'type'       => 'text',
            'title'      => __('CDN域名','CS_TEXTDOMAIN'),
            'help'       => __('设置为CDN云存储提供的测试域名或者在云存储绑定的域名。<strong>注意要域名前面要加上 http://或https://</strong>。','CS_TEXTDOMAIN'),
        ), 
      
    )
);