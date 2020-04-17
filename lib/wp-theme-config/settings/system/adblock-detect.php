<?php

/**
 * dequeue jetpack devicepx
 */
return function() 
{
    global $adbd_type,$adbd_title,$adbd_text,$adbd_button_text,$adbd_button_color;
    $adbd_type = WpThemeConfig\Configurator::getInstance()->get('system.adbd-type');
    $adbd_title = WpThemeConfig\Configurator::getInstance()->get('system.adbd-title');
    $adbd_text = WpThemeConfig\Configurator::getInstance()->get('system.adbd-text');
    $adbd_button_text = WpThemeConfig\Configurator::getInstance()->get('system.adbd-button-text');
    $adbd_button_color = WpThemeConfig\Configurator::getInstance()->get('system.adbd-button-color');

    function sweetalert_header_src() {
        global $adbd_type,$adbd_title,$adbd_text,$adbd_button_text,$adbd_button_color;
        ob_start(); 
     ?>   
        <script type="text/javascript" src="<?php echo WP_THEME_CONFIG_STATIC_URI;?>/js/adbdetect.packed.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.25.6/dist/sweetalert2.all.min.js"></script>
        <script>
        jQuery(window).load(function() {
           var adBD = adBDetect();
           if(adBD.isDetected()) {
              swal({
                 title: "<?= $adbd_title; ?>", 
                 text: "<?= $adbd_text; ?>",
                 type: "<?= $adbd_type;?>",
                 confirmButtonColor: "<?= $adbd_button_color; ?>",
                 allowOutsideClick: false,
                 confirmButtonText:"<?= $adbd_button_text; ?>", showCancelButton: false,
              }).then((value) => { location.reload(); });
           }   
        });
        </script>
        <?php $contents = ob_get_clean();
        _e($contents);
     }
     add_action('wp_head', 'sweetalert_header_src');
};
