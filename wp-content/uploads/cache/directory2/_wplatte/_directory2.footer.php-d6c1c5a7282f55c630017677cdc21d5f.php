<?php //netteCache[01]000546a:2:{s:4:"time";s:21:"0.63410600 1474980964";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:60:"/var/www/html/findir/wp-content/themes/directory2/footer.php";i:2;i:1474608420;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /var/www/html/findir/wp-content/themes/directory2/footer.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'kaszovhe53')
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


	<footer id="footer" class="footer" role="contentinfo">

<?php if ($options->layout->general->enableWidgetAreas) { ?>
		<div class="footer-widgets">
			<div class="footer-widgets-wrap grid-main">
				<div class="footer-widgets-container">


<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($wp->widgetAreas('footer')) as $widgetArea) { ?>
																		<div class="widget-area <?php echo NTemplateHelpers::escapeHtml($widgetArea, ENT_COMPAT) ?>
 widget-area-<?php echo NTemplateHelpers::escapeHtml($iterator->counter, ENT_COMPAT) ?>">
<?php dynamic_sidebar($widgetArea) ?>
						</div>
<?php $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>

				</div>
			</div>
		</div>
<?php } ?>

		<div class="site-footer">
			<div class="site-footer-wrap grid-main">
<?php WpLatteMacros::menu("footer", array('depth' => 1)) ?>
				<div class="footer-text"><?php echo $options->theme->footer->text ?></div>
			</div>
		</div>

	</footer><!-- /#footer -->
</div><!-- /#page -->

<?php wp_footer() ?>

<?php echo $options->theme->footer->customJsCode ?>


</body>
</html>
