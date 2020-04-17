<?php

/**
 *	Adds hidden content to admin_footer, then shows with jQuery, and inserts after welcome panel
 *
 *	@author Ren Ventura <EngageWP.com>
 *	@see http://www.engagewp.com/how-to-create-full-width-dashboard-widget-wordpress
 */
return function($value) {
	add_action( 'admin_footer', 'rv_custom_dashboard_widget' );
	function rv_custom_dashboard_widget() {
		if( !is_admin() ) {
			return;
		}
		$screen = get_current_screen();
		if( $screen->base != 'dashboard' ) {
			return;	
		}
		$quick_liks = ([
	        'qq'       => '285088180',
	        'email'    => 'cofess@foxmail.com'
	    ]);
	    $settings = array(
	        array(
	            'icon'  => 'fa fa-qq fa-2x',
	            'title' => __( 'QQ', 'BT_TEXTDOMAIN' ),
	            'type'  => 'qq',
	            'value' => '285088180'
	        ),
	        array(
	            'icon'  => 'fa fa-envelope fa-2x',
	            'title' => __( 'Email', 'BT_TEXTDOMAIN' ),
	            'type'  => 'email',
	            'value' => 'cofess@foxmail.com',
	        ),
	        array(
	            'icon'  => 'fa fa-wechat fa-2x',
	            'title' => __( '微信', 'BT_TEXTDOMAIN' ),
	            'type'  => 'wechat',
	            'value' => 'xiaoxu_2014'
	        ),
	        array(
	            'icon'  => 'fa fa-link fa-2x',
	            'title' => __( 'Blog', 'BT_TEXTDOMAIN' ),
	            'type'  => 'link',
	            'value' => 'https://blog.cofess.com'
	        ),
	        array(
	            'icon'  => 'fa fa-globe fa-2x',
	            'title' => __( '网站', 'BT_TEXTDOMAIN' ),
	            'type'  => 'link',
	            'value' => 'http://www.cofess.com'
	        ),
	    );
		$services = array(
	        array(
	            'icon'  => 'dashicons dashicons-admin-customizer',
	            'title' => __( '网站建设', 'BT_TEXTDOMAIN' ),
	            'desc'  => __( '根据客户需求，量身定制网站，拥有完美的视觉与用户体验', 'BT_TEXTDOMAIN' )
	        ),
	        array(
	            'icon'  => 'dashicons dashicons-cart',
	            'title' => __( '外贸商城', 'BT_TEXTDOMAIN' ),
	            'desc'  => __( '提供专业的电子商务解决方案，助力品牌商家驰聘电子商务', 'BT_TEXTDOMAIN' )
	        ),
	        array(
	            'icon'  => 'dashicons dashicons-wordpress',
	            'title' => __( 'WordPress主题定制', 'BT_TEXTDOMAIN' ),
	            'desc'  => __( '拥有多年WordPress网站定制开发经验，WordPress深度爱好者', 'BT_TEXTDOMAIN' )
	        ),
	        array(
	            'icon'  => 'dashicons dashicons-admin-appearance',
	            'title' => __( '电商设计', 'BT_TEXTDOMAIN' ),
	            'desc'  => __( '阿里巴巴旺铺全方位的包装，让您在激烈的竞争中脱颖而出', 'BT_TEXTDOMAIN' )
	        ),
	    );
		?>

		<div id="full-width-panel" class="welcome-panel" style="display: none;">
			<div class="welcome-panel-content" style="max-width: inherit;margin-bottom: 20px;">
				<div class="part-xs-1 part-sm-1 part-md-1 part-lg-2 part-xl-2">
				<div class="item">
					<h2><?php echo __( '技术支持', 'BT_TEXTDOMAIN' );?></h2>
					<ul class="part-xs-1 part-sm-2 part-md-3 part-lg-2 part-xl-3">
						<?php foreach ($settings as $key => $val) {?>
						<li class="item icon-box">
							<div class="media media-middle item-content"> 
								<div class="media-left"> 
									<i class='<?php echo $val['icon'];?>'></i>
								</div> 
								<div class="media-body"> 
									<strong><?php echo $val['title'];?></strong>
									<?php if($val['type']=='email') {?>
									<a href="mailto:<?php echo $val['value'];?>"><?php echo $val['value'];?></a>
									<?php } elseif($val['type']=='qq') { ?>
									<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $val['value'];?>&site=qq&menu=yes" target="_blank"><?php echo $val['value'];?></a>
									<?php } elseif($val['type']=='link') { ?>
									<a href="<?php echo $val['value'];?>" target="_blank"><?php echo trim(strrchr($val['value'], '://'),'://');?></a>
									<?php } else { ?>
									<span><?php echo $val['value'];?></span>
									<?php } ?>
								</div> 
							</div>
						</li>
						<li class="item icon-box" style="display: none;">
							<div class="item-content text-center">
								<i class='<?php echo $val['icon'];?>'></i>
								<strong><?php echo $val['title'];?></strong>
								<?php if($val['type']=='email') {?>
								<a href="mailto:<?php echo $val['value'];?>"><?php echo $val['value'];?></a>
								<?php } elseif($val['type']=='qq') { ?>
								<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $val['value'];?>&site=qq&menu=yes" target="_blank"><?php echo $val['value'];?></a>
								<?php } elseif($val['type']=='link') { ?>
								<a href="<?php echo $val['value'];?>" target="_blank"><?php echo trim(strrchr($val['value'], '://'),'://');?></a>
								<?php } else { ?>
								<span><?php echo $val['value'];?></span>
								<?php } ?>
							</div>
						</li>
						<?php }?>
					</ul>
					<?php 
				        echo '<div style="margin-top:-8px;">';
				        echo '<a style="display:inline-block;line-height:inherit;height:23px;float:left;" target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=GSshLCkhISghKVloaDd6dnQ" style="text-decoration:none;"><img style="height:23px;width:auto;" src="http://rescdn.qqmail.com/zh_CN/htmledition/images/function/qm_open/ico_mailme_12.png"/></a>';
				        if($quick_liks['qq']){
				            echo '<a style="display:inline-block;line-height:inherit;height:23px;float:left;margin-left:10px;" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$quick_liks['qq'].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$quick_liks['qq'].':51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>';
				        }
				        echo '<div style="clear:both"></div></div>';
					?>
				</div>
				<div class="item">
					<h2 style="margin-bottom: 20px;"><?php echo __( '提交工单', 'BT_TEXTDOMAIN' );?></h2>
					<form class="form form-feedback" enctype="multipart/form-data" method="post" action="https://www.astatoner.com/">
						<div class="form-group">
					      <div class="form-item form-name with-icon">
					          <input type="text" class="form-control" placeholder="昵称*" required="required">
					          <i class="fa fa-user"></i>
					      </div>
					      <div class="form-item form-email with-icon">
					          <input type="email" class="form-control" placeholder="Email*" required="required">
					          <i class="fa fa-envelope"></i>
					      </div>
					      <div class="form-item form-phone with-icon">
					          <input type="text" class="form-control" placeholder="电话">
					          <i class="fa fa-phone"></i>
					      </div>
					    </div>
					    <div class="form-group">
					      <div class="form-item form-content with-icon">
					         <textarea type="text" id="content" name="content" class="form-control" rows="5" placeholder="问题描述*" required="required" style="height: 144px;min-height: 144px"></textarea>
					      </div>
					    </div>
				      <div class="form-group form-full">
				      	<input type="submit" name="submit_form" value="Submit" class="button button-primary">
				      </div>
				    </form>
				</div>
				</div>
			</div>
			<div class="welcome-panel-content" style="max-width: inherit;">
				<h2><?php echo __( '服务范围', 'BT_TEXTDOMAIN' );?></h2>
				<ul class="list-services part-xs-1 part-sm-1 part-md-2 part-lg-4 part-xl-4">
					<?php foreach ($services as $key => $val) {?>
					<li class="item">
						<div class="media media-middle item-content"> 
							<div class="media-left"> 
								<i class='<?php echo $val['icon'];?>'></i>
							</div> 
							<div class="media-body"> 
								<strong><?php echo $val['title'];?></strong>
								<p style="margin: 0"><?php echo $val['desc'];?></p> 
							</div> 
						</div>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
		<script>
			jQuery(document).ready(function($) {
				$('#welcome-panel').after($('#full-width-panel').show());
			});
		</script>
	<?php }
};