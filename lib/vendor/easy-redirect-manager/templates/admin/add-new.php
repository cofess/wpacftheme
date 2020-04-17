<div class="wps-box">
  <!-- <div class="wps-box-title">
    <h2>Add new rule</h2>
  </div> -->

  <div class="wps-box-content">
    <br/>
    <form method="POST" action="<?php echo admin_url('tools.php?page=wps-redirect-manager'); ?>">
      
      <?php
        if (!empty($_GET['edit'])) {
          $redirect = get_post($_GET['edit']);
          if ($redirect) {
            echo '<input type="hidden" name="wps-rm[edit-id]" id="wps-edit-it" value="' . $_GET['edit'] . '" />';
            $source = get_post_meta($redirect->ID, 'wps-source', true);
            $target = get_post_meta($redirect->ID, 'wps-target', true);
            $status_s = get_post_meta($redirect->ID, 'wps-redirect_code', true);
          }
        } else {
          $source = '';
          $target = '';
          $status_s = '';
        }
      ?>
    
      <label for="wps-source-url"><strong>Source URL:</strong></label>
      <input type="text" class="widefat" name="wps-rm[source-url]" id="wps-source-url" value="<?php echo $source; ?>" />
      <p class="desc"><code>Note:</code> Make sure your URL starts with <code>/</code>.<br/><br/>You can use wildcard by inserting <code>*</code>.</p>
      
      <div class="clear"></div>
      
      <label for="wps-target-url"><strong>Target URL:</strong></label>
      <input type="text" class="widefat" name="wps-rm[target-url]" id="wps-target-url" value="<?php echo $target; ?>" />
      <p class="desc"><code>External URLs</code> need to start with <code>http://</code> or <code>https://</code>.<br/><br/><code>Internal URLs</code> can have absolute path to the content starting with <code>/</code>.</p>
      
      <div class="clear"></div>
      
      <label for="wps-redirect-code"><strong>Redirect Code:</strong></label>
      <select class="widefat" name="wps-rm[redirect-code]" id="wps-redirect-code">
        <?php
          $status = array();
          $status['cloak'] = 'Cloaking URL';
          $status['301'] = '301';
          $status['302'] = '302';
          $status['303'] = '303';
          $status['307'] = '307';
          
          foreach ($status as $code => $status_code) {
            if ($code == $status_s) {
              echo '<option value="' . $code . '" selected="selected">' . $status_code . '</option>';
            } else {
              echo '<option value="' . $code . '">' . $status_code . '</option>';
            }
          }
        ?>
      </select>
      <p class="desc">Setup prefered redirect code notice.</p>
      
      <input type="submit" name="wps-rm-insert" class="button button-primary" value="Save new rule" />
      
    </form>
  </div>
</div>