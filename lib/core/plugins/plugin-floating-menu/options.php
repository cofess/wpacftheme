<?php
if ( ! function_exists( 'add_action' )) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

// Setup Form
$form = tr_form()->useJson()->setGroup( 'floating-menus' );
?>

<h1>Floating Menu Setting</h1>
<div class="typerocket-container">
    <?php
    
    echo $form->open();
    
    echo '<br/>';
    echo $form->close('Submit');
    ?>

</div>
