<?php //netteCache[01]000570a:2:{s:4:"time";s:21:"0.74075900 1474646616";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:84:"/home/zaerodes/public_html/findir/wp-content/themes/directory2/parts/search-form.php";i:2;i:1474646218;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/zaerodes/public_html/findir/wp-content/themes/directory2/parts/search-form.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'oumbqwz7ry')
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
<form role="search" method="get" class="search-form" action="<?php echo NTemplateHelpers::escapeHtml($homeUrl, ENT_COMPAT) ?>">
	<div>
		<label>
			<span class="screen-reader-text"><?php echo NTemplateHelpers::escapeHtml(_x('Search for:', 'label', 'wplatte'), ENT_NOQUOTES) ?></span>
			<input type="text" class="search-field" placeholder="<?php echo _x('Search &hellip;', 'placeholder', 'wplatte') ?>
" value="<?php echo NTemplateHelpers::escapeHtml($wp->searchQuery, ENT_COMPAT) ?>
" name="s" title="<?php echo NTemplateHelpers::escapeHtml(_x('Search for:', 'label', 'wplatte'), ENT_COMPAT) ?>" />
		</label>
		<input type="submit" class="search-submit" value="<?php echo NTemplateHelpers::escapeHtml(_x('Search', 'submit button', 'wplatte'), ENT_COMPAT) ?>" />
	</div>
</form>
