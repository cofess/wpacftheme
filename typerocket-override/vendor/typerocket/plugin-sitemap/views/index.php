<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($pages as $page) : $seo = tr_posts_field('seo', $page->ID); if( $seo['meta']['index'] != 'noindex' ?? true) : ?>
        <url>
            <loc><?php echo get_permalink($page->ID); ?></loc>
            <lastmod><?php echo get_the_modified_date('Y-m-d', $page); ?></lastmod>
        </url>
    <?php endif; endforeach; ?>
</urlset>