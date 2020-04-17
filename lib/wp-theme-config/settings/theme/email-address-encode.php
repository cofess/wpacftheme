<?php

/**
 * WordPress转义文章和评论中的邮箱地址以防被恶意采集
 * 参考：http://www.wpdaxue.com/security-remove-emails.html
 */
return function() 
{
    function security_remove_emails($content) {
        $pattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4})/i';
        $fix = preg_replace_callback($pattern,"security_remove_emails_logic", $content);
    
        return $fix;
    }
    function security_remove_emails_logic($result) {
        return antispambot($result[1]);
    }
    add_filter( 'the_content', 'security_remove_emails', 20 );
    add_filter( 'widget_text', 'security_remove_emails', 20 );
};
