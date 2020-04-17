<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Switcher
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_switcher extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();
    $label = ( isset( $this->field['label'] ) ) ? '<div class="cs-text-desc">'. $this->field['label'] . '</div>' : '';
    // Custom Attribute for On/Off Texts
    $on_text = ( isset( $this->field['on_text'] ) ) ? $this->field['on_text'] : __( 'on', 'cs-framework' );
    $off_text = ( isset( $this->field['off_text'] ) ) ? $this->field['off_text'] : __( 'Off', 'cs-framework' );
    echo '<label><input type="checkbox" name="'. $this->element_name() .'" value="1"'. $this->element_class() . $this->element_attributes() . checked( $this->element_value(), 1, false ) .'/><em data-on="'. $on_text .'" data-off="'. $off_text .'"></em><span></span></label>' . $label;
    echo $this->element_after();

  }

}
