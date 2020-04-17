<div class="wrap">
  <h1 class="wp-heading-inline">Redirect Log <a href="#" id="wps-erm-clear-logs" class="button button-primary">Clear Log</a></h1>
  <table id="wps-redirects-log" class="wp-list-table widefat fixed striped">
    <thead>
      <tr>
        <th>Source URL</th>
        <th width="180">Target URL</th>
        <th width="90">Redirect Code</th>
        <th>User Ref.</th>
        <th>User Agent</th>
        <th width="90">User IP</th>
        <th width="120">Timestamp</th>
      </tr>
    </thead>

    <tbody>
      <?php
      global $wpdb;
      $post_per_page = 10;
      $page = isset( $_GET['paged'] ) ? abs( (int) $_GET['paged'] ) : 1;
      $offset = ( $page * $post_per_page ) - $post_per_page;
      $total = $wpdb->get_var( "SELECT COUNT(1) FROM " . $wpdb->prefix . "rm_log ORDER by ID DESC" );
      $total_pages = ceil($total / $post_per_page);

      $redirects = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "rm_log ORDER by ID DESC LIMIT ${offset}, ${post_per_page}");
      if ($redirects) {
        foreach ($redirects as $redirect) {
          
          if (!empty($redirect->user_referral)) {
            $ref = $redirect->user_referral;
          } else {
            $ref = 'Uknown';
          }
          
          ?>
          <tr>
            <td><a href="<?php echo site_url($redirect->source); ?>"><?php echo $redirect->source; ?></a></td>
            <td><?php echo $redirect->target; ?></td>
            <td><?php echo $redirect->code; ?></td>
            <td><?php echo $ref; ?></td>
            <td><?php echo $redirect->user_agent; ?></td>
            <td><?php echo $redirect->user_ip; ?></td>
            <td><?php echo date('d.m.Y H:i:m', strtotime($redirect->timestamp)); ?></td>
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
        <th>User Ref.</th>
        <th>User Agent</th>
        <th>User IP</th>
        <th>Timestamp</th>
      </tr>
    </tfoot>
  </table>

  <?php
  echo '<div class="tablenav">';
  echo '<span style="padding-top: 5px;display: inline-block;">'.sprintf( _x( '%1$s of %2$s', 'paging' ), $page, $total_pages ).'</span>';
  echo '<span class="tablenav-pages">';
  echo paginate_links( array(
    'base'      => add_query_arg( 'paged', '%#%' ),
    'format'    => '',
    'type'      => 'plain',
    'prev_text' => __('&laquo;'),
    'next_text' => __('&raquo;'),
    'total'     => $total_pages,
    'current'   => $page
  ));
  echo '</span></div>';
  ?>
</div>