<?php

/**
 * Class Name: wp_category_walker
 * URI: https://wordpress.stackexchange.com/questions/135654/make-parent-category-an-optgroup
 * Description: Make parent category an optgroup
 */
/**
 * // usage test
wp_dropdown_categories(
  array(
    'orderby' => 'name',
    'hide_empty' => 0,
    'show_count' => 1,
    'show_option_none' => 'Select one',
    'class' => 'cat',
    'hierarchical' => 1,
    'name' => 'cat',
    'walker' => new Top_level_Optgroup
  )
);
 */
class wp_category_walker extends Walker_CategoryDropdown {

  var $optgroup = false;

  function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

    $pad = str_repeat('&nbsp;', $depth * 3);

    $cat_name = apply_filters('list_cats', $category->name, $category);
    if (0 == $depth) {
	  // $this->optgroup = true;
      $output .= "<optgroup class=\"level-$depth\" label=\"".$cat_name."\" >";
    } else {
      $output .= "<option class=\"level-$depth\" value=\"".$category->term_id."\"";
      if ( $category->term_id == $args['selected'] )
              $output .= ' selected="selected"';
      $output .= '>';
      $output .= $pad.$cat_name;
      if ( $args['show_count'] )
              $output .= '&nbsp;&nbsp;('. $category->count .')';
      $output .= "</option>";
    }

  }

  function end_el( &$output, $object, $depth = 0, $args = array() ) {
    if (0 == $depth/* && true == $this->optgroup*/) {
      $output .= '</optgroup>';
    }
  }
}
