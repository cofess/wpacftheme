<h1>Theme Options</h1>

<?php
$form = tr_form();
$form->useJson();
$form->setGroup( $this->getName() );
?>

<div class="typerocket-container">
    <?php
    echo $form->open();

    // about
    $company = $form->text('Name');
    $company .= $form->image('Logo');
    $company .= $form->textarea('About');

    // about
    $general = $form->editor('Page Content');
    $general .= $form->row(
        $form->text('First Name'),
        $form->text('Last Name')
    );
    $general .= $form->image('Logo');
    $general .= $form->textarea('About');

    // save
    // $save = $form->submit( 'Save' );

    // layout
    tr_tabs()
    // ->setSidebar( $save )
    ->addTab( 'Company', $company )
    ->addTab( 'General', $general )
    ->render();

    echo $form->close('Submit');
    ?>
</div>