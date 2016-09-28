<?php //netteCache[01]000561a:2:{s:4:"time";s:21:"0.49642600 1474654408";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:75:"/home/zaerodes/public_html/findir/wp-content/themes/directory2/comments.php";i:2;i:1474646225;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/zaerodes/public_html/findir/wp-content/themes/directory2/comments.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'h21g79sees')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>
<div id="comments" class="comments-area">
<?php if ($post->hasComments) { ?>
	<h2 class="comments-title"><?php echo NTemplateHelpers::escapeHtml($template->printf(__('Comments (%s)', 'wplatte'), $post->commentsNumber), ENT_NOQUOTES) ?></h2>

	<ol class="commentlist">
<?php
				global $__wplattetemplate__;
				$__wplattetemplate__ = $template;
				if(!function_exists('__WpLatteListComments_h21g79sees1474654408')):
					function __WpLatteListComments_h21g79sees1474654408($__comment__, $args, $depth){
						global $__wplattetemplate__, $post;
						$template = $__wplattetemplate__; // bypassing $template object
						$GLOBALS['comment'] = $__comment__;
						$comment = WpLatte::createEntity('Comment', $__comment__, $post->post_author);
						$comment->loopData = array('args' => $args, 'depth' => $depth)	?>

<?php if (!$comment->isNormal) { ?>

		<li <?php echo $comment->htmlClass ?> <?php echo $comment->htmlId('li-') ?>>
			<?php ob_start() ?>(<?php echo NTemplateHelpers::escapeHtml(__('Edit', 'wplatte'), ENT_NOQUOTES) ?>
)<?php $editLinkLabel = ob_get_clean() ?>

			<p><?php echo NTemplateHelpers::escapeHtml(__('Pingback:', 'wplatte'), ENT_NOQUOTES) ?>
 <?php echo $comment->author->link ?> <span class="edit-link"><?php echo $comment->editLink($editLinkLabel) ?></span></p>

<?php } else { ?>

		<li <?php echo $comment->htmlClass ?> <?php echo $comment->htmlId('li-') ?>>
			<article <?php echo $comment->htmlId ?> class="comment-article">

				<header class="comment-meta">
					<div class="comment-author vcard">
						<div class="avatar-wrap">
							<?php echo $comment->author->avatar(58) ?>

						</div>
						<div>
							<cite class="fn"><?php echo $comment->author->link ?></cite>
							<a href="<?php echo NTemplateHelpers::escapeHtml($comment->url, ENT_COMPAT) ?>
"><time datetime="<?php echo NTemplateHelpers::escapeHtml($comment->time('c'), ENT_COMPAT) ?>
"><?php echo NTemplateHelpers::escapeHtml($template->printf(_x('%1$s at %2$s', '1: date, 2: time', 'wplatte'), $comment->date, $comment->time), ENT_NOQUOTES) ?></time></a>
						</div>
					</div><!-- .comment-meta -->

					<div class="comment-tools">
						<?php ob_start() ?><span class="reply"><?php echo __('Reply', 'wplatte') ?>
</span><?php $replyLinkLabel = ob_get_clean() ?>

						<?php echo $comment->replyLink($replyLinkLabel) ?>

						<?php ob_start() ?><span class="edit-link"><?php echo __('Edit', 'wplatte') ?>
</span><?php $editLinkLabel = ob_get_clean() ?>

	      				<?php echo $comment->editLink($editLinkLabel) ?>

					</div>

				</header>

				<div class="entry-content comment-content">
<?php if (!$comment->isApproved) { ?>
						<p class="comment-awaiting-moderation"><?php echo NTemplateHelpers::escapeHtml(__('Your comment is awaiting moderation.', 'wplatte'), ENT_NOQUOTES) ?></p>
<?php } else { ?>
						<?php echo $comment->text ?>

<?php } ?>
				</div><!-- .comment-content -->


			</article><!-- #comment-## -->

<?php } ?>

			<?php 	} /* __WpLatteListComments_h21g79sees1474654408 */
				endif;
				wp_list_comments(array('callback' => '__WpLatteListComments_h21g79sees1474654408', 'style' => 'ol'))	?>
	</ol><!-- .commentlist -->


<?php if ($post->willCommentsPaginate) { ?>
	<nav class="navigation comment-navigation" role="navigation">
		<h1 class="assistive-text section-heading"><?php echo NTemplateHelpers::escapeHtml(__('Comment navigation', 'wplatte'), ENT_NOQUOTES) ?></h1>
		<div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'wplatte')) ?></div>
		<div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'wplatte')) ?></div>
	</nav>
<?php } ?>

<?php if ($post->hasCommentsClosed) { ?>
		<p class="nocomments"><?php echo NTemplateHelpers::escapeHtml(__('Comments are closed.', 'wplatte'), ENT_NOQUOTES) ?></p>
<?php } } ?>

<?php comment_form() ?>

</div><!-- #comments .comments-area -->
