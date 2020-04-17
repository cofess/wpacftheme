<?php

/**
 * 前台不加载语言包
 * http://blog.wpjam.com/m/setup-different-admin-and-frontend-language-on-wordpress/
 */
return function($option)
{
	add_filter('language_attributes',function ($language_attributes){

        $wpjam_locale = get_locale();

		if ( function_exists( 'is_rtl' ) && is_rtl() )
			$attributes[] = 'dir="rtl"';

		if($wpjam_locale){
			if (get_option('html_type') == 'text/html')
				$attributes[] = 'lang="'.$wpjam_locale.'"';

			if(get_option('html_type') != 'text/html')
				$attributes[] = 'xml:lang="'.$wpjam_locale.'"';
		}

		return implode(' ', $attributes);
	});

	add_filter('locale', function($locale) use($option) {
        return (is_admin()) ? $locale : $option; 
    });
};