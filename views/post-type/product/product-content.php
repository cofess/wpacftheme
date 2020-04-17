<?php if(get_the_content()) :?>
<section>
    <div class="container">
        <h3 class="title with-line fs-2">Product description</h3>
        <div class="entity-content">
            <?php the_content(); ?>
        </div>
    </div>
</section>
<?php endif;?>