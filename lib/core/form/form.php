<?php
if ( ! defined( 'ABSPATH' ) ) { die; } 

$contact_page = tr_resource_pages( 'Form' )->setIcon('fire');
// $contact_page->addPage(
//     tr_page('Form', 'custom', 'Custom')
//         ->mapAction('POST', 'custom_post')
//         ->useController()
// );