<?php 
/*
Template Name: 联系我们
*/

get_header(); ?>
    <div class="typerocket-container">
        <?php
        $form = tr_form('marketing', 'create');
        $list = 14829;
        $form->useUrl('POST', '/marketing/pdf/' . $list );
        echo $form->open();
        echo $form->text('Email')->setType('email');
        echo $form->close('Subscribe');
        ?>
    </div>
<?php get_footer(); ?>
