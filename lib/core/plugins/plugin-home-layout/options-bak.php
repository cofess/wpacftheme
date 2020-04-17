<?php
if (! function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
} 
// Setup Form
$form = tr_form() -> useJson() -> setGroup('module-layout');
$args = array(
   // 'public'   => true,
   'show_ui'   => true,
   // 'has_archive' => true
);
$output = 'names'; // names or objects, note names is the default
$operator = 'and'; // 'and' or 'or'

$post_types = get_post_types($args, $output, $operator);
unset($post_types['page'],$post_types['attachment']);
// var_dump(get_post_type_object( 'post' ));
?>

<h1>Module Layout Settings</h1>
<div class="typerocket-container">
    <table class="wp-list-table widefat fixed striped wpum-fields-groups-table">
      <thead>
        <tr>
          <th scope="col" data-balloon="Drag and drop the rows below to change the order." data-balloon-pos="right" class="order-column"><span class="dashicons dashicons-menu"></span></th>
          <th scope="col" class="column-primary">Module Name</th>
          <th scope="col" class="small-column">Post Type</th>
          <th scope="col" class="small-column">PC端</th>
          <th scope="col" class="small-column">移动端</th>
          <th scope="col" data-balloon="Fields marked as locked, can only be edited by an administrator and will not be visible in any form." data-balloon-pos="up" class="small-column">Editable</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($post_types as $key => $value) {
            $obj = get_post_type_object($value);
            $options = tr_options_field('module_'.$value.'_options');
            if(isset($options) && !empty($options)){
                $edit_link = 'edit.php?post_type='.$value.'&page=module_'.$value.'_setting';
                if($value == 'post'){
                    $edit_link = 'edit.php?page=module_'.$value.'_setting';
                }
                // Counting each post
                $num_posts = wp_count_posts($value);
                // Number format
                $num = number_format_i18n($num_posts->publish);
        ?>
        <tr>
          <td class="order-anchor align-middle"><i class="dashicons dashicons-menu"></i></td>
          <td class="column-primary"><a><strong><?php echo $obj->label;?></strong></a></td>
          <td>
            <?php echo $value.'('.$num.')';?>
          </td>
          <td>
            <?php if(isset($options["module_display"])){
                echo '<i class="dashicons dashicons-yes"></i>';
            }else{
                echo '<i class="dashicons dashicons-hidden"></i>';
            }?>
          </td>
          <td>
            <?php if(isset($options["m_module_display"])){
                echo '<i class="dashicons dashicons-yes"></i>';
            }else{
                echo '<i class="dashicons dashicons-hidden"></i>';
            }?>
          </td>
          <td>
            <?php if(current_user_can('manage_options')){
                echo '<i class="dashicons dashicons-unlock"></i>';
            }else{
                echo '<i class="dashicons dashicons-lock"></i>';
            }?>
          </td>
          <td class="align-middle">
            <a class="button" href="<?php echo $edit_link;?>" target="_blank"><i class="dashicons dashicons-edit"></i> Edit field</a>
          </td>
        </tr>
        <?php }} ?>
        <!-- <tr>
          <td class="order-anchor align-middle"><span class="dashicons dashicons-menu"></span></td>
          <td class="column-primary"><a><strong>Username</strong></a></td>
          <td>
            Username
          </td>
          <td><span class="dashicons dashicons-yes"></span></td>
          <td><span class="dashicons dashicons-yes"></span></td>
          <td><span class="dashicons dashicons-lock"></span></td>
          <td class="align-middle">
            <button type="submit" class="button"><span class="dashicons dashicons-edit"></span> Edit field</button>
          </td>
        </tr> -->
      </tbody>
    </table>
    <?php

?>

</div>
