<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Get icons from admin ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_get_icons' ) ) {
  function cs_get_icons() {

    do_action( 'cs_add_icons_before' );

    $jsons = apply_filters( 'cs_add_icons_json', glob( CS_DIR . '/fields/icon/*.json' ) );

    if( ! empty( $jsons ) ) {

      foreach ( $jsons as $path ) {

        $object = cs_get_icon_fonts( 'fields/icon/'. basename( $path ) );

        if( is_object( $object ) ) {

          echo ( count( $jsons ) >= 2 ) ? '<h4 class="cs-icon-title">'. $object->name .'</h4>' : '';

          foreach ( $object->icons as $icon ) {
            echo '<a class="cs-icon-tooltip" data-cs-icon="'. $icon .'" data-title="'. $icon .'"><span class="cs-icon cs-selector"><i class="'. $icon .'"></i></span></a>';
          }

        } else {
          echo '<h4 class="cs-icon-title">'. esc_html__( 'Error! Can not load json file.', 'cs-framework' ) .'</h4>';
        }

      }

    }

    do_action( 'cs_add_icons' );
    do_action( 'cs_add_icons_after' );

    die();
  }
  add_action( 'wp_ajax_cs-get-icons', 'cs_get_icons' );
}

/**
 *
 * Export options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_export_options' ) ) {
  function cs_export_options() {

    $option_array = ! empty( $_GET['option_array'] ) ? $_GET['option_array'] : CS_OPTION;

    header('Content-Type: plain/text');
    header('Content-disposition: attachment; filename=backup'.$option_array.'-'. gmdate( 'Y-m-d' ) .'.txt');
    header('Content-Transfer-Encoding: binary');
    header('Pragma: no-cache');
    header('Expires: 0');

    // echo cs_encode_string( get_option( CS_OPTION ) );
    echo cs_encode_string( get_option( $option_array ) );

    die();
  }
  add_action( 'wp_ajax_cs-export-options', 'cs_export_options' );
}

/**
 *
 * Set icons for wp dialog
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! function_exists( 'cs_set_icons' ) ) {
  function cs_set_icons() {

    echo '<div id="cs-icon-dialog" class="cs-dialog" title="'. esc_html__( 'Add Icon', 'cs-framework' ) .'">';
    echo '<div class="cs-dialog-header cs-text-center"><input type="text" placeholder="'. esc_html__( 'Search a Icon...', 'cs-framework' ) .'" class="cs-icon-search" /></div>';
    echo '<div class="cs-dialog-load"><div class="cs-icon-loading">'. esc_html__( 'Loading...', 'cs-framework' ) .'</div></div>';
    echo '</div>';

  }
  add_action( 'admin_footer', 'cs_set_icons' );
  add_action( 'customize_controls_print_footer_scripts', 'cs_set_icons' );
}


// This action for theme options not metaboxes or customize panel
if( ! function_exists( 'update_config_file_hook' ) ) {
  function update_config_file_hook( $options ) {

    $option_array = ! empty( $_REQUEST['option_page'] ) ? $_REQUEST['option_page'] : CS_OPTION;
    $option_array = ! empty( $_REQUEST['page'] ) ? $_REQUEST['page'] : $option_array;

    // 截取字符串
    $filenameprefix = substr($option_array,0,strpos($option_array, '_'));
    // 第一个字符为下划线“_”
    if($option_array[0] === '_'){
      $filenameprefix = substr(substr($option_array,1),0,strpos(substr($option_array,1), '_'));
    }
    // 字符包含中横线“-”
    if( substr($option_array,0,strpos($option_array, '-')) ){
      $filenameprefix = substr($option_array,0,strpos($option_array, '-'));
    }

    // 获取配置项数组
    $settings = $options;
    // if(!is_array($settings)){
    //   $settings = [];
    // }

    // 文件路径及名称
    $filename = get_template_directory().'/config/'.$filenameprefix.'.php';
    // 打开文件,不存在则创建新文件(一般都存在,并在配置文件中引入)
    $file = fopen($filename, 'a+');
    $contents = "<?php\n\r\treturn\t".var_export($settings,true).';';
    $result = file_put_contents($filename,$contents);

  }
  add_filter( 'cs_validate_save_after', 'update_config_file_hook' );
}
