<?php //netteCache[01]000576a:2:{s:4:"time";s:21:"0.67191300 1474646616";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:90:"/home/zaerodes/public_html/findir/wp-content/themes/directory2/parts/entry-date-format.php";i:2;i:1474646218;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/zaerodes/public_html/findir/wp-content/themes/directory2/parts/entry-date-format.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'mc68o62juu')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($dateIcon) { ?>

<?php $dayFormat = '' ;$dayFormatSuffix = '' ;$monthFormat = '' ;$yearFormat = '' ?>


	<span class="entry-date updated <?php if ($dateShort == 'yes') { ?>short-date<?php } ?>">

		<?php ob_start() ;echo NTemplateHelpers::escapeHtml(_x('d', 'day date format', 'wplatte'), ENT_NOQUOTES) ;$dayFormat = ob_get_clean() ?>

				<?php if ($dateShort == 'yes') { ?>	<?php ob_start() ;echo NTemplateHelpers::escapeHtml(_x('M', 'month date short format', 'wplatte'), ENT_NOQUOTES) ;$monthFormat = ob_get_clean() ?>

		<?php } else { ?>						<?php ob_start() ;echo NTemplateHelpers::escapeHtml(_x('F', 'month date long format', 'wplatte'), ENT_NOQUOTES) ;$monthFormat = ob_get_clean() ?>
 <?php } ?>


		<?php ob_start() ;echo NTemplateHelpers::escapeHtml(_x('Y',  'year date format', 'wplatte'), ENT_NOQUOTES) ;$yearFormat = ob_get_clean() ?>


<?php if ($dateLinks == 'yes') { ?>

			<time class="date" datetime="<?php echo NTemplateHelpers::escapeHtml($template->date($dateIcon, 'c'), ENT_COMPAT) ?>">
				<a class="link-day" href="<?php echo NTemplateHelpers::escapeHtml($post->dayArchiveUrl, ENT_COMPAT) ?>
" title="<?php echo NTemplateHelpers::escapeHtml(__('Link to daily archives: %s', 'wplatte'), ENT_COMPAT) ;echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon), ENT_COMPAT) ?>">
					<?php echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $dayFormat), ENT_NOQUOTES) ;if (!empty($dayFormatSuffix)) { ?>
<small><?php echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $dayFormatSuffix), ENT_NOQUOTES) ?>
</small><?php } ?>

				</a>
				<a class="link-month" href="<?php echo NTemplateHelpers::escapeHtml($post->monthArchiveUrl, ENT_COMPAT) ?>
" title="<?php echo NTemplateHelpers::escapeHtml($template->printf(__('Link to monthly archives: %s', 'wplatte'), ''), ENT_COMPAT) ;echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $monthFormat), ENT_COMPAT) ?>">
					<?php echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $monthFormat), ENT_NOQUOTES) ?>

				</a>
				<a class="link-year" href="<?php echo NTemplateHelpers::escapeHtml($post->yearArchiveUrl, ENT_COMPAT) ?>
" title="<?php echo NTemplateHelpers::escapeHtml($template->printf(__('Link to yearly archives: %s', 'wplatte'), ''), ENT_COMPAT) ;echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $yearFormat), ENT_COMPAT) ?>">
					<?php echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $yearFormat), ENT_NOQUOTES) ?>

				</a>
			</time>

<?php } else { ?>

			<time class="date" datetime="<?php echo NTemplateHelpers::escapeHtml($template->date($dateIcon, 'c'), ENT_COMPAT) ?>">
				<span class="link-day">
					<?php echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $dayFormat), ENT_NOQUOTES) ;if (!empty($dayFormatSuffix)) { ?>
<small><?php echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $dayFormatSuffix), ENT_NOQUOTES) ?>
</small><?php } ?>

				</span>
				<span class="link-month">
					<?php echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $monthFormat), ENT_NOQUOTES) ?>

				</span>
				<span class="link-year">
					<?php echo NTemplateHelpers::escapeHtml($template->dateI18n($dateIcon, $yearFormat), ENT_NOQUOTES) ?>

				</span>
			</time>

<?php } ?>

	</span>

<?php } 