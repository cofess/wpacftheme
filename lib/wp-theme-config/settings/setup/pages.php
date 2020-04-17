<?php

return function ($pages) {
	foreach($pages as $page) {
		Lib\Core\Page::create_page($page['title'], $page['slug'], $page['template']);
	} 
};
