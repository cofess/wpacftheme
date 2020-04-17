<?php

// Register Post Type
$glossary = tr_post_type(__('术语','BT_TEXTDOMAIN'), __('术语','BT_TEXTDOMAIN'));
$glossary->setId('glossary');
$glossary->setArgument('supports', ['title','page-attributes']);

// disable permalink
$glossary->setArgument('public', false);
$glossary->setArgument('show_ui', true);

// enable archive page
$glossary->setArgument('has_archive', true);
$glossary->setArgument('show_in_nav_menus', true);

// Chain Methods with Eloquence
$glossary->setIcon('book')
    ->setArchivePostsPerPage(-1)
    ->setEditorForm( function() {
        $form = tr_form();
        $settings = array(
            'teeny' => false,
            'media_buttons' => true,
            'dfw' => true,
            // 'editor_height' => 300,
            // 'tinymce' => true,
            'tinymce' => array(
                'toolbar1' => 'formatselect,styleselect,bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignright,alignjustify,link,unlink,media,spellchecker,undo,redo,wp_more,wp_page,wp_adv,fullscreen',
                'toolbar2' => 'fontselect,fontsizeselect,strikethrough,hr,underline,outdent,indent,forecolor,backcolor,cleanup,sub,sup,copy,paste,cut,pastetext,removeformat,charmap,wp_help',
            ),
            // 'quicktags'=> false,
            'textarea_name' => 'content'
        );
        $wpEditor = $form->wpEditor(__('Content','BT_TEXTDOMAIN'))->setName('content');
        $wpEditor->setSetting('options', $settings);
        echo $wpEditor;
    });

// Add Taxonomy
tr_taxonomy(__('Glossary Category','BT_TEXTDOMAIN'), __('Glossary Categories','BT_TEXTDOMAIN'))
->setId('glossary_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($glossary);

// REST API
$glossary->setRest('glossary');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('glossary', 'glossary_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('glossary', 'glossary_category') );

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
    add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('glossary','glossary_category')]);
}
