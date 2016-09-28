<?php //netteCache[01]000593a:2:{s:4:"time";s:21:"0.91626400 1474654380";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:106:"/home/zaerodes/public_html/findir/wp-content/plugins/ait-item-reviews/templates/carousel-reviews-stars.php";i:2;i:1474646462;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/zaerodes/public_html/findir/wp-content/plugins/ait-item-reviews/templates/carousel-reviews-stars.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'id7686al7b')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if (isset($item)) { $rating_count = AitItemReviews::getRatingCount($item->id) ;$rating_mean = get_post_meta($item->id, 'rating_mean', true) ?>

<?php $showCount = isset($showCount) ? $showCount : false ?>
	<div class="review-stars-container">
		<div class="content">
<?php if ($rating_count > 0) { ?>
				<span class="review-stars" data-score="<?php echo NTemplateHelpers::escapeHtml($rating_mean, ENT_COMPAT) ?>"></span>
				<?php if ($showCount) { ?><span class="review-count">(<?php echo NTemplateHelpers::escapeHtml($rating_count, ENT_NOQUOTES) ?>
)</span><?php } ?>

<?php } else { ?>
				<a href="<?php echo NTemplateHelpers::escapeHtml($item->permalink, ENT_COMPAT) ?>
#review"><?php _e('Rate now','ait-item-reviews') ?></a>
<?php } ?>
		</div>
	</div>
<?php } 