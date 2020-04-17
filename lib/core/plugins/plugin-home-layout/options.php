<?php
if (! function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
} 
// Setup Form
$form = tr_form()->useJson()->setGroup('module_layout_options');
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
echo $form->open();
$brand_options = tr_options_field('brand_options');
// var_dump(tr_options_field('module_layout_options'));
?>

<h1>Home Layout Setting</h1>
<br/>
<div class="typerocket-container">
    <table class="wp-list-table widefat fixed striped module-layout-groups-table">
      <thead>
        <tr>
          <th scope="col" class="order-column" style="width:2.2em;"><span class="dashicons dashicons-menu"></span></th>
          <th scope="col" class="column-primary">Module Name</th>
          <th scope="col" class="small-column">Post Type</th>
          <th scope="col" class="small-column">PC端显示</th>
          <th scope="col" class="small-column">移动端显示</th>
          <th scope="col" class="small-column">权限</th>
          <th scope="col" class="small-column">
              <span><?php echo __('Order');?></span>
          </th>
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
          <td>
              <?php 
              $order_input = $form->text(__('Order','BT_TEXTDOMAIN'))->setName('module_'.$value.'_order');
              $order_input->setLabel('');
              $order_input->setType('number');
              $order_input->setSetting('default', 1);
              $order_input->setSetting('class', 'short_number_input');
              echo $order_input;?>
          </td>
          <td class="align-middle">
            <a class="button" href="<?php echo $edit_link;?>" target="_blank"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Settings');?></a>
          </td>
        </tr>
        <?php }} ?>
        <tr>
          <td class="order-anchor align-middle"><span class="dashicons dashicons-menu"></span></td>
          <td class="column-primary"><a><strong>数据展示</strong></a></td>
          <td>-</td>
          <td>
            <?php if(isset($brand_options["module_data_display"]) && $brand_options["module_data_display"]){
                echo '<i class="dashicons dashicons-yes"></i>';
            }else{
                echo '<i class="dashicons dashicons-hidden"></i>';
            }?>
          </td>
          <td>
            <?php if(isset($brand_options["m_module_data_display"]) && $brand_options["m_module_data_display"]){
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
          <td>
              <?php 
              $order_input = $form->text(__('Order','BT_TEXTDOMAIN'))->setName('module_data_order');
              $order_input->setLabel('');
              $order_input->setType('number');
              $order_input->setSetting('default', 1);
              $order_input->setSetting('class', 'short_number_input');
              echo $order_input;?>
          </td>
          <td class="align-middle">
            <a class="button" href="admin.php?page=brand_settings" target="_blank"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Settings');?></a>
          </td>
        </tr>
        <tr>
          <td class="order-anchor align-middle"><span class="dashicons dashicons-menu"></span></td>
          <td class="column-primary"><a><strong>核心优势</strong></a></td>
          <td>-</td>
          <td>
            <?php if(isset($brand_options["module_feature_display"]) && $brand_options["module_feature_display"]){
                echo '<i class="dashicons dashicons-yes"></i>';
            }else{
                echo '<i class="dashicons dashicons-hidden"></i>';
            }?>
          </td>
          <td>
            <?php if(isset($brand_options["m_module_feature_display"]) && $brand_options["m_module_feature_display"]){
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
          <td>
              <?php 
              $order_input = $form->text(__('Order','BT_TEXTDOMAIN'))->setName('module_data_order');
              $order_input->setLabel('');
              $order_input->setType('number');
              $order_input->setSetting('default', 1);
              $order_input->setSetting('class', 'short_number_input');
              echo $order_input;?>
          </td>
          <td class="align-middle">
            <a class="button" href="admin.php?page=brand_settings" target="_blank"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Settings');?></a>
          </td>
        </tr>
        <tr>
          <td class="order-anchor align-middle"><span class="dashicons dashicons-menu"></span></td>
          <td class="column-primary"><a><strong>合作伙伴</strong></a></td>
          <td>-</td>
          <td>
            <?php if(isset($brand_options["module_partner_display"]) && $brand_options["module_partner_display"]){
                echo '<i class="dashicons dashicons-yes"></i>';
            }else{
                echo '<i class="dashicons dashicons-hidden"></i>';
            }?>
          </td>
          <td>
            <?php if(isset($brand_options["m_module_partner_display"]) && $brand_options["m_module_partner_display"]){
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
          <td>
              <?php 
              $order_input = $form->text(__('Order','BT_TEXTDOMAIN'))->setName('module_data_order');
              $order_input->setLabel('');
              $order_input->setType('number');
              $order_input->setSetting('default', 1);
              $order_input->setSetting('class', 'short_number_input');
              echo $order_input;?>
          </td>
          <td class="align-middle">
            <a class="button" href="admin.php?page=brand_settings" target="_blank"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Settings');?></a>
          </td>
        </tr>
        <tr>
          <td class="order-anchor align-middle"><span class="dashicons dashicons-menu"></span></td>
          <td class="column-primary"><a><strong>关于我们</strong></a></td>
          <td>-</td>
          <td>
            <?php if(isset($brand_options["module_profile_display"]) && $brand_options["module_profile_display"]){
                echo '<i class="dashicons dashicons-yes"></i>';
            }else{
                echo '<i class="dashicons dashicons-hidden"></i>';
            }?>
          </td>
          <td>
            <?php if(isset($brand_options["m_module_profile_display"]) && $brand_options["m_module_profile_display"]){
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
          <td>
              <?php 
              $order_input = $form->text(__('Order','BT_TEXTDOMAIN'))->setName('module_profile_order');
              $order_input->setLabel('');
              $order_input->setType('number');
              $order_input->setSetting('default', 1);
              $order_input->setSetting('class', 'short_number_input');
              echo $order_input;?>
          </td>
          <td class="align-middle">
            <a class="button" href="admin.php?page=brand_settings" target="_blank"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Settings');?></a>
          </td>
        </tr>
      </tbody>
    </table>
</div>
<?php
    echo '<br/>';
    echo $form->close('Submit');
?>
