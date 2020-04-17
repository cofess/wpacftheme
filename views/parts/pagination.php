<?php
  $pagination = new \Palmtree\WordPress\Pagination\Pagination();
  if( isset($maxPage) && $maxPage > 1 ){
    $pagination->setMaxPage($maxPage);
  }
  $pagination
    ->addArg('prev_text', 'Prev')
    ->addArg('next_text', 'Next')
    ->addArg('container', false)
    ->addArg('pagination_class', 'pagination pagination-basic');

    // Get Bootstrap formatted pagination
    // echo $pagination->getHtml();

    $maxNumPages = $pagination->getMaxNumPages();

    // Or get an array of unstyled links
    // $links = $pagination->getLinks();
?>
<?php if ( $maxNumPages > 1 ) : ?>
<nav class="navbar navbar-pagination">
  <?php echo str_replace( "<ul class='page-numbers'>", '<ul class="pagination">', $pagination->output());?>
  <form class="form-inline form-pagination navbar-right hidden-xs">
    <div class="form-group form-group-simple">
      <label for="pageNumber" class="regular">Total <?php echo $maxNumPages;?> pages, Jump to</label>
      <div class="input-group">
        <input type="number" class="form-control" placeholder="page" size="6" name="paged" style="width:60px" required>
        <div class="input-group-addon">
          <button type="submit" class="btn search-btn">Go</button>
        </div>
      </div>
    </div>
  </form>
</nav>
<?php endif;?>
