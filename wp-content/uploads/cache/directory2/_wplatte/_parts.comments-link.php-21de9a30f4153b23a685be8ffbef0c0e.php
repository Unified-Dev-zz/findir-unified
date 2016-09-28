<?php //netteCache[01]000572a:2:{s:4:"time";s:21:"0.69156400 1474646616";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:86:"/home/zaerodes/public_html/findir/wp-content/themes/directory2/parts/comments-link.php";i:2;i:1474646218;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/zaerodes/public_html/findir/wp-content/themes/directory2/parts/comments-link.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'enlezfbzo8')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($post->hasCommentsOpen) { ?>
	<div class="comments-link">
		<a href="<?php echo NTemplateHelpers::escapeHtml($post->commentsUrl, ENT_COMPAT) ?>
" title="<?php echo NTemplateHelpers::escapeHtml($template->printf(__('Comments on %s', 'wplatte'), $post->title), ENT_COMPAT) ?>">
<?php if ($post->commentsNumber > 1) { ?>
				<span class="comments-count" title="<?php echo NTemplateHelpers::escapeHtml($template->printf(_n('%s Comment', '%s Comments', 'wplatte'), $post->commentsNumber), ENT_COMPAT) ?>">
					<span class="comments-number"><?php echo NTemplateHelpers::escapeHtml($post->commentsNumber, ENT_NOQUOTES) ?>
</span> <?php echo NTemplateHelpers::escapeHtml(__('Comments', 'wplatte'), ENT_NOQUOTES) ?>

				</span>
<?php } elseif ($post->commentsNumber == 0) { ?>
				<span class="comments-count" title="<?php echo NTemplateHelpers::escapeHtml(__('Leave a comment', 'wplatte'), ENT_COMPAT) ?>">
					<span class="comments-number">0</span> <?php echo NTemplateHelpers::escapeHtml(__('Comments', 'wplatte'), ENT_NOQUOTES) ?>

				</span>
<?php } else { ?>
				<span class="comments-count" title="<?php echo NTemplateHelpers::escapeHtml(__('1 Comment', 'wplatte'), ENT_COMPAT) ?>">
					<span class="comments-number">1</span> <?php echo NTemplateHelpers::escapeHtml(__('Comment', 'wplatte'), ENT_NOQUOTES) ?>

				</span>
<?php } ?>
		</a>
	</div><!-- .comments-link -->
<?php } 