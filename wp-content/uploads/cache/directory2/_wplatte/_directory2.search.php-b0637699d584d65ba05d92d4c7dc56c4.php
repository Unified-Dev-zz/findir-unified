<?php //netteCache[01]000559a:2:{s:4:"time";s:21:"0.79888600 1474649209";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:73:"/home/zaerodes/public_html/findir/wp-content/themes/directory2/search.php";i:2;i:1474646218;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/zaerodes/public_html/findir/wp-content/themes/directory2/search.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '7e8t52i3wy')
;
// prolog NUIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb0f73d83922_content')) { function _lb0f73d83922_content($_l, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;global $wp_query ;$query = $wp_query ?>


<?php if ($query->have_posts()) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/search-filters", ""), array('current' => $query->post_count, 'max' => $query->found_posts) + get_defined_vars(), $_l->templates['7e8t52i3wy'])->render() ?>

<?php if (defined("AIT_ADVANCED_FILTERS_ENABLED")) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/advanced-filters", ""), array('query' => $query) + get_defined_vars(), $_l->templates['7e8t52i3wy'])->render() ;} ?>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/pagination", ""), array('location' => 'pagination-above', 'max' => $query->max_num_pages) + get_defined_vars(), $_l->templates['7e8t52i3wy'])->render() ?>

	<div class="items-container">
<?php foreach ($iterator = new WpLatteLoopIterator($query) as $post): NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/post-content", ""), array() + get_defined_vars(), $_l->templates['7e8t52i3wy'])->render() ;endforeach; wp_reset_postdata() ?>
	</div>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/pagination", ""), array('location' => 'pagination-below', 'max' => $query->max_num_pages) + get_defined_vars(), $_l->templates['7e8t52i3wy'])->render() ?>

<?php } else { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/none", ""), array('message' => 'nothing-found') + get_defined_vars(), $_l->templates['7e8t52i3wy'])->render() ;} ?>

<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof NPresenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 