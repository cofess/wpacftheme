<?php

/**
 * 自定义登录页面样式
 * http://www.wpdaxue.com/custom-wordpress-login-page.html
 */
return function($template) 
{
    $login_stylesheet = WP_THEME_CONFIG_STATIC_URI . '/css/login_style'.$template.'.css';
    
    $background_image = $this->config['system.login-background-image'];
    $bgckground_color = $this->config['system.login-background-color'];

    if($template == '1'){
        $html='<style type="text/css">';
        $html.='.login {
            background-color       : '.$bgckground_color.';
            background-image       : url('.$background_image.');
            background-position    : center;
            background-repeat      : no-repeat;
            background-attachment  : fixed;
            background-size        : cover;
            -webkit-background-size: cover;
        }';
        $html.='</style>'."\n";
    }

    if($template != '1'){
        $html='<style type="text/css">';
        $html.='.login:before{
            background-color       : '.$bgckground_color.';
            background-image       : url('.$background_image.');
            background-position    : center;
            background-repeat      : no-repeat;
            background-attachment  : fixed;
            background-size        : cover;
            -webkit-background-size: cover;
        }';
        $html.='</style>'."\n";
    }

    if($template == '2'){
        add_filter( 'login_message', 'custom_login_message' );
        function custom_login_message( $message ) {
            $message = '<div id="owl-login">
            <div class="hand"></div>
            <div class="hand hand-r"></div>
            <div class="arms">
            <div class="arm"></div>
            <div class="arm arm-r"></div>
            </div>
            </div>';
            return $message;
        }

        add_action( 'login_footer', function(){
            $html='<script>';
            $html.='function hasClass(ele, cls) {return ele.className.match(new RegExp("(\\s|^)" + cls + "(\\s|$)"));}';
            //为指定的dom元素添加样式
            $html.='function addClass(ele, cls) {if (!this.hasClass(ele, cls)) ele.className += " " + cls;}';
            //删除指定dom元素的样式
            // $html.='function removeClass(ele, cls) {if (hasClass(ele, cls)) {var reg = new RegExp("(\\s|^)" + cls + "(\\s|$)");ele.className = ele.className.replace(reg, " ");}}';
            // //如果存在(不存在)，就删除(添加)一个样式
            // $html.='function toggleClass(ele,cls){ if(hasClass(ele,cls)){ removeClass(ele, cls); }else{ addClass(ele, cls); } }';
            $html.='var target = document.getElementById("user_pass");var owl = document.getElementById("owl-login");';
            $html.='target.onfocus=function(){addClass(owl,"password");};';
            $html.='function owlToggleClass(){var owl = document.getElementById("owl-login");owl.removeAttribute("class");}';
            $html.='target.setAttribute("onblur", "owlToggleClass()");';
            $html.='</script>'."\n";
            echo $html;
        } );
    }

    // if($template == '3'){

    // }

    add_action( 'login_head', function() use( $login_stylesheet,$html ){
        echo '<link rel="stylesheet" type="text/css" href="' . $login_stylesheet . '" />';
        echo $html;
    } );
};