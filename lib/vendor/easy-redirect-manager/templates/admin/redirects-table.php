<?php
$error_msg = get_transient('wps-rule-exists');
  if ($error_msg) {
    delete_transient('wps-rule-exists');
?>
<div class="wps-error">
 <p><i class="dashicons dashicons-welcome-comments"></i><?php echo $error_msg; ?></p>
</div>
<?php
  }
?>
<div class="wps-wrapper">
<table id="wps-redirects-table" class="wp-list-table widefat fixed striped">
  <thead>
    <tr>
      <th>Source URL</th>
      <th>Target URL</th>
      <th>Redirect Code</th>
      <th>Unique Runs</th>
      <th>Total Runs</th>
      <th>Last Run</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php
    $redirects = get_posts(array('post_type' => 'wps-redirects', 'posts_per_page' => '-1'));
    if ($redirects) {
      foreach ($redirects as $redirect) {
        ?>
        <tr>
          <td><?php echo get_post_meta($redirect->ID, 'wps-source', true); ?></td>
          <td><?php echo get_post_meta($redirect->ID, 'wps-target', true); ?></td>
          <td><?php echo ucwords(get_post_meta($redirect->ID, 'wps-redirect_code', true)); ?></td>
          <td><?php echo get_post_meta($redirect->ID, 'wps-unique_runs', true); ?></td>
          <td><?php echo get_post_meta($redirect->ID, 'wps-total_runs', true); ?></td>
          <td><?php echo get_post_meta($redirect->ID, 'wps-last_run', true); ?></td>
          <td><a href="<?php echo admin_url('admin.php?page=wps-redirect-manager&edit=' . $redirect->ID); ?>">Edit</a> | <a href="<?php echo admin_url('admin.php?page=wps-redirect-manager&delete=' . $redirect->ID); ?>" class="wps-rm-delete" data-rule-id="<?php echo $redirect->ID; ?>">Delete</a></td>
        </tr>
        <?php
      }
    } else {
      ?>
      <tr id="no-results">
        <td colspan="7" style="text-align: center;">
          <strong>No redirects found.</strong><br/><br/>
        </td>
      </tr>
      <?php
    }
    ?>
  </tbody>

  <tfoot>
    <tr>
      <th>Source URL</th>
      <th>Target URL</th>
      <th>Redirect Code</th>
      <th>Unique Runs</th>
      <th>Total Runs</th>
      <th>Last Run</th>
      <th>Actions</th>
    </tr>
  </tfoot>
</table>
</div>