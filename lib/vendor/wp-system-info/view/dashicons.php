<?php

	?>
<div class="wrap">
	<!-- <h1>Dashicons</h1> -->

	<style type="text/css">
	h2 {
		padding-bottom: 10px;
		clear: both;
		border-bottom: 1px solid #ccc;
	}

	.wp-core-dashicons .icons__item {
		float: left;
		margin: 0px 15px 15px 0;
		width: 260px;
	}

	.wp-core-dashicons .icons__item i {
	    font-size: 20px;
	    display: inline-block;
	    width: 32px;
	    /*height: 32px;*/
	    text-align: center;
	    vertical-align: middle;
	}
	</style>
	<?php
	$dashicon_css_file	= fopen(ABSPATH.'/'.WPINC.'/css/dashicons.css','r') or die("Unable to open file!");

	$i	= 0;

	$dashicons_html = '';

	while(!feof($dashicon_css_file)) {
		$line	= fgets($dashicon_css_file);
		$i++;
		
		if($i < 32) continue;

		if($line){
			if (preg_match_all('/.dashicons-(.*?):before/i', $line, $matches)) {
				$dashicons_html .= '<div class="icons__item" data-name="dashicons-'.$matches[1][0].'"><i class="dashicons-before dashicons-'.$matches[1][0].'"></i>dashicons-'.$matches[1][0].'</div>'."\n";
			}elseif(preg_match_all('/\/\* (.*?) \*\//i', $line, $matches)){
				if($dashicons_html){
					echo '<div class="wp-core-dashicons">'.$dashicons_html.'</div>'.'<div class="clear"></div>';
				}
				echo '<h2>'.$matches[1][0].'</h2>'."\n";
				$dashicons_html = '';
			}
		}

		// echo  $line. "<br>";
	}

	if($dashicons_html){
		echo '<div class="wp-core-dashicons">'.$dashicons_html.'</div>'.'<div class="clear"></div>';
	}

	fclose($dashicon_css_file);
	?>
</div>