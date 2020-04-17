<?php if (WpThemeConfig\Configurator :: getInstance() -> get('theme.share_bigger_img')) {
?>
    <a class="btn btn-primary btn-action btn-bigger-cover" data-module="miPopup" data-selector="#bigger-cover" href="javascript:;" >
        <i class="icons icon-paper-plane"></i> <span>生成封面</span>
    </a>
    <div class="dialog dialog-poster" id="bigger-cover">
        <div class="dialog-content">
            <div class="poster-image">
                <?php
                    $bigger_cover = get_post_meta(get_the_ID(), 'bigger_cover', true);
                    if ($bigger_cover) {
                ?>
                    <img src="<?php echo $bigger_cover ?>" alt="<?php the_title();?> bigger封面">
                <?php } else {
                ?>
                    <img class="load_bigger_img" data-nonce="<?php echo wp_create_nonce('mi-create-bigger-image-' . get_the_ID());?>" data-id="<?php the_ID();?>" data-action="create-bigger-image" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php the_title();?> bigger封面">
                    <div class="image-loading"><i></i></div>
                <?php } 
                ?>
            </div>
            <div class="poster-actions">
                <button class="btn btn-black poster-close">关闭窗口</button>
                <a href="<?php echo get_post_meta(get_the_ID(), 'bigger_cover_share', true);?>" class="btn btn-danger bigger_share"><i class="fa fa-weibo"></i>分享到微博</a>
                <a href="<?php echo $bigger_cover;?>" download="<?php the_title();?>-Bigger-cover" class="btn btn-success bigger_down"><i class="fa fa-cloud-download"></i>下载封面</a>
            </div>
        </div>
        <div class="dialog-overlay"></div>
    </div>
<?php } 
?>