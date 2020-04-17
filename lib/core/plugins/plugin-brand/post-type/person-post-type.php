<?php

// Register Post Type
$person = tr_post_type(__('团队','BT_TEXTDOMAIN'), __('团队','BT_TEXTDOMAIN'));
$person->setId('person');
$person->setArgument('supports', ['title','thumbnail'] );

// disable permalink
$person->setArgument( 'public', false );
$person->setArgument( 'show_ui', true );

// enable archive page
$person->setArgument( 'has_archive', true );
$person->setArgument( 'show_in_nav_menus', true );

// parent menu
$person->setArgument( 'show_in_menu', 'brand' );

// Chain Methods with Eloquence
$person->setIcon('users')
    ->setArchivePostsPerPage(-1)
    ->setTitleForm( function() {
        $gender_options = [
            __('男','BT_TEXTDOMAIN') => 0,
            __('女','BT_TEXTDOMAIN') => 1
        ];
        $form = tr_form();
        echo $form->row(
            $form->text(__('职位','BT_TEXTDOMAIN'))->setName('position'), 
            $form->text(__('工号','BT_TEXTDOMAIN'))->setName('number'),
            $form->date(__('入职时间','BT_TEXTDOMAIN'))->setName('hire_date')->setFormat('yy-mm-dd')
        );
        echo $form->row(
            $form->text(__('电话','BT_TEXTDOMAIN'))->setName('tel'), 
            $form->text(__('手机','BT_TEXTDOMAIN'))->setName('phone'),
            $form->text(__('Email','BT_TEXTDOMAIN'))->setName('email')
        )->setAttribute( 'class', 'radio-horizontal' );
        echo $form->repeater(__('其他联系方式','BT_TEXTDOMAIN'))->setName('contacts')->setFields([
            $form->row(
                $form->text(__('参数名','BT_TEXTDOMAIN'))->setName('field'), 
                $form->text(__('参数值','BT_TEXTDOMAIN'))->setName('value')
            )
        ]);
        echo $form->repeater(__('社交媒体','BT_TEXTDOMAIN'))->setName('socials')->setFields([
            $form->row(
                $form->text(__('参数名','BT_TEXTDOMAIN'))->setName('field'), 
                $form->text(__('参数值','BT_TEXTDOMAIN'))->setName('value')
            )
        ]);
        echo $form->row(
            $form->radio(__('性别','BT_TEXTDOMAIN'))->setName('gender')->setOptions($gender_options)->setSetting('default', 0)
        )->setAttribute( 'class', 'radio-horizontal' );
        echo $form->editor(__('个人简介','BT_TEXTDOMAIN'))->setName('profile');
    });

// Add Taxonomy
tr_taxonomy(__('Person Category','BT_TEXTDOMAIN'), __('Person Categories','BT_TEXTDOMAIN'))
->setId('person_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($person);

// Add Sortable Columns to Admin Index View
$person->removeColumn('date');
$person->addColumn('position', true, __('职位','BT_TEXTDOMAIN'));
$person->addColumn('hire_date', true, __('入职时间','BT_TEXTDOMAIN'));
$person->addColumn('thumbnail', false, __('Avatar'), function($id) {
    $post_thumbnail_id = get_post_thumbnail_id( $id );
    echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$person->setRest('person');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('person', 'person_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('person', 'person_category') );