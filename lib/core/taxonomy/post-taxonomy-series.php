<?php
/**
 * 分类：专栏
 */
tr_taxonomy(__('专栏','BT_TEXTDOMAIN'), __('专栏','BT_TEXTDOMAIN'))
->setSlug('series')
->setId('series')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', false)
->setArgument('show_in_rest', true)
->addPostType('post');