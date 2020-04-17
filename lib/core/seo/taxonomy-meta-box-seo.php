<?php

add_action( 'admin_init', 'add_taxonomy_seo_options' );

function add_taxonomy_seo_options() {
    foreach ( get_taxonomies(
        array(
            'public' => true,
        )
    ) as $tax_name ) {
        add_action( $tax_name . '_edit_form', 'taxonomy_seo_options', 10, 2 );
    }
}

function taxonomy_seo_options(){
    echo '<div class="typerocket-container">';

    // build form
    $form = new \TypeRocket\Elements\Form();
    // $form->setDebugStatus( false );
    $form->setGroup( 'seo.meta' );

    // General
    $general = function() use ($form){

        $title = [
            'label' => __('Title')
        ];

        $desc = [
            'label' => __('Description')
        ];

        echo $form->text( 'title', ['id' => 'tr_title'], $title );
        echo $form->textarea( 'description', ['id' => 'tr_description'], $desc );

    };

    // Social
    $social = function() use ($form){

        $og_title = [
            'label' => __('Title'),
            'help'  => __('The open graph protocol is used by social networks like FB, Google+ and Pinterest. Set the title used when sharing.')
        ];

        $og_desc = [
            'label' => __('Description'),
            'help'  => __('Set the open graph description to override "Search Result Description". Will be used by FB, Google+ and Pinterest.')
        ];

        $img = [
            'label' => __('Image'),
            'help'  => __("The image is shown when sharing socially using the open graph protocol. Will be used by FB, Google+ and Pinterest. Need help? Try the Facebook <a href=\"https://developers.facebook.com/tools/debug/og/object/\" target=\"_blank\">open graph object debugger</a> and <a href=\"https://developers.facebook.com/docs/sharing/best-practices\" target=\"_blank\">best practices</a>.")
        ];

        echo $form->text( 'og_title', [], $og_title );
        echo $form->textarea( 'og_desc', [], $og_desc );
        echo $form->image( 'meta_img', [], $img );
    };

    // Twitter
    $twitter = function() use ($form){

        $tw_img = [
            'label' => __('Image'),
            'help'  => __("Images for a 'summary_large_image' card should be at least 280px in width, and at least 150px in height. Image must be less than 1MB in size. Do not use a generic image such as your website logo, author photo, or other image that spans multiple pages.")
        ];

        $tw_help = __("Need help? Try the Twitter <a href=\"https://cards-dev.twitter.com/validator/\" target=\"_blank\">card validator</a>, <a href=\"https://dev.twitter.com/cards/getting-started\" target=\"_blank\">getting started guide</a>, and <a href=\"https://business.twitter.com/en/help/campaign-setup/advertiser-card-specifications.html\" target=\"_blank\">advertiser creative specifications</a>.");

        $card_opts = [
            __('Summary')             => 'summary',
            __('Summary large image') => 'summary_large_image',
        ];

        echo $form->text( 'tw_site')->setLabel('Twitter account')->setAttribute('placeholder', '@username');
        echo $form->select( 'tw_card')->setOptions($card_opts)->setLabel('Card Type')->setSetting('help', $tw_help);
        echo $form->text( 'tw_title')->setLabel('Title')->setAttribute('maxlength', 70 );
        echo $form->textarea( 'tw_desc')->setLabel('Description')->setHelp( __('Description length is dependent on card type.') );
        echo $form->image( 'tw_img', [], $tw_img );
    };

    // Advanced
    $advanced = function() use ($form){

        $redirect = [
            'label'    => __('301 Redirect'),
            'help'     => __('Move this page permanently to a new URL.') . '<a href="#tr_redirect" id="tr_redirect_lock">' . __('Unlock 301 Redirect') .'</a>',
            'readonly' => true
        ];

        $follow = [
            'label' => __('Robots Follow?'),
            'desc'  => __("Don't Follow"),
            'help'  => __('This instructs search engines not to follow links on this page. This only applies to links on this page. It\'s entirely likely that a robot might find the same links on some other page and still arrive at your undesired page.')
        ];

        $follow_opts = [
            __('Not Set')      => 'none',
            __('Follow')       => 'follow',
            __("Don't Follow") => 'nofollow'
        ];

        $index_opts = [
            __('Not Set')     => 'none',
            __('Index')       => 'index',
            __("Don't Index") => 'noindex'
        ];

        $canon = [
            'label' => __('Canonical URL'),
            'help'  => __('The canonical URL that this page should point to, leave empty to default to permalink.')
        ];

        $help = [
            'label' => __('Robots Index?'),
            'desc'  => __("Don't Index"),
            'help'  => __('This instructs search engines not to show this page in its web search results.')
        ];

        echo $form->text( 'canonical', [], $canon );
        echo $form->text( 'redirect', ['readonly' => 'readonly', 'id' => 'tr_redirect'], $redirect );
        echo $form->row([
            $form->select( 'follow', [], $follow )->setOptions($follow_opts),
            $form->select( 'index', [], $help )->setOptions($index_opts)
        ]);
    };

    $tabs = new \TypeRocket\Elements\Tabs();
    $tabs->addTab( [
            'id'       => 'seo-general',
            'title'    => __("Basic"),
            'callback' => $general
        ])
        ->addTab( [
             'id'      => 'seo-social',
             'title'   => __("Social"),
             'callback' => $social
         ])
        ->addTab( [
            'id'      => 'seo-twitter',
            'title'   => __("Twitter Cards"),
            'callback' => $twitter
        ])
        ->addTab( [
             'id'      => 'seo-advanced',
             'title'   => __("Advanced"),
             'callback' => $advanced
         ])
        ->render();

    echo '</div>';

}