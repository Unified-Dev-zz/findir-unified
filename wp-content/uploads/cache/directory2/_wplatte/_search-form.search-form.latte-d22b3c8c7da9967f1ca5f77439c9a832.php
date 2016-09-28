<?php //netteCache[01]000598a:2:{s:4:"time";s:21:"0.53014800 1474646616";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:111:"/home/zaerodes/public_html/findir/wp-content/themes/directory2/ait-theme/elements/search-form/search-form.latte";i:2;i:1474646218;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/zaerodes/public_html/findir/wp-content/themes/directory2/ait-theme/elements/search-form/search-form.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, '7yc5wdrhdk')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$type = $el->option('type') != "" ? $el->option('type') : 1 ?>

<?php $selectedKey = isset($_REQUEST['s']) && $_REQUEST['s'] != "" ? $_REQUEST['s'] : '' ;$selectedCat = isset($_REQUEST['category']) && $_REQUEST['category'] != "" ? $_REQUEST['category'] : '' ;$selectedLoc = isset($_REQUEST['location']) && $_REQUEST['location'] != "" ? $_REQUEST['location'] : '' ;$selectedRad = isset($_REQUEST['rad']) && $_REQUEST['rad'] != "" ? $_REQUEST['rad'] : '' ?>

<?php ob_start() ;if ($type == 2) { ?>
	<span class="searchinput-wrap"><input type="text" name="s" id="searchinput-text" placeholder="<?php echo NTemplateHelpers::escapeHtml(__('Search keyword', 'wplatte'), ENT_COMPAT) ?>
" class="searchinput" value="<?php echo NTemplateHelpers::escapeHtml($selectedKey, ENT_COMPAT) ?>" /></span>
<?php } else { ?>
	<span class="searchinput-wrap"><input type="text" name="s" id="searchinput-text" placeholder="<?php echo NTemplateHelpers::escapeHtml(__('Search keyword', 'wplatte'), ENT_COMPAT) ?>
" class="searchinput" value="<?php echo NTemplateHelpers::escapeHtml($selectedKey, ENT_COMPAT) ?>" /></span>
<?php } $searchKeyword = ob_get_clean() ?>

<?php ob_start() ;$categories = get_categories(array('taxonomy' => 'ait-items', 'hide_empty' => 0, 'parent' => 0)) ;if (isset($categories) && count($categories) > 0) { ?>
		<div class="category-search-wrap" data-position="first">
<?php if ($type == 3) { ?>
				<span class="category-icon"><i class="fa fa-folder-open"></i></span>
<?php } ?>
			<span class="category-clear"><i class="fa fa-times"></i></span>

<?php if ($type == 3) { ?>
			<select name="category" class="category-search default-disabled" style="display: none;">
<?php } else { ?>
			<select data-placeholder="<?php echo NTemplateHelpers::escapeHtml(__('Category', 'wplatte'), ENT_COMPAT) ?>" name="category" class="category-search default-disabled" style="display: none;">
<?php } ?>
			<option></option>
			<?php echo recursiveCategory($categories, $selectedCat, 'ait-items', "") ?>

			</select>
		</div>
<?php } $searchCategory = ob_get_clean() ?>

<?php ob_start() ;$locations = get_categories(array('taxonomy' => 'ait-locations', 'hide_empty' => 0, 'parent' => 0)) ;if (isset($locations) && count($locations) > 0) { ?>
		<div class="location-search-wrap" data-position="last">
<?php if ($type == 3) { ?>
				<span class="location-icon"><i class="fa fa-map-marker"></i></span>
<?php } ?>
			<span class="location-clear"><i class="fa fa-times"></i></span>

<?php if ($type == 3) { ?>
			<select name="location" class="location-search default-disabled" style="display: none;">
<?php } else { ?>
			<select data-placeholder="<?php echo NTemplateHelpers::escapeHtml(__('Location', 'wplatte'), ENT_COMPAT) ?>" name="location" class="location-search default-disabled" style="display: none;">
<?php } ?>
			<option></option>
			<?php echo recursiveCategory($locations, $selectedLoc, 'ait-locations', "") ?>

			</select>
		</div>
<?php } $searchLocation = ob_get_clean() ?>

<?php ob_start() ;$radiusSet = $selectedRad != "" ? 'radius-set' : '' ?>
	<div class="radius <?php echo NTemplateHelpers::escapeHtml($radiusSet, ENT_COMPAT) ?>">
		<?php if ($type != 2 && $type != 3) { ?><div class="radius-toggle radius-input-visible"><?php echo NTemplateHelpers::escapeHtml(__('Radius:', 'wplatte'), ENT_NOQUOTES) ?>
 <?php echo NTemplateHelpers::escapeHtml(__('Off', 'wplatte'), ENT_NOQUOTES) ?></div><?php } else { ?>
<div class="radius-toggle radius-input-visible">x <?php echo NTemplateHelpers::escapeHtml($el->option('radiusUnits'), ENT_NOQUOTES) ?>
</div><?php } ?>

		<input type="hidden" name="lat" value="" id="latitude-search" class="latitude-search" disabled />
		<input type="hidden" name="lon" value="" id="longitude-search" class="longitude-search" disabled />
		<input type="hidden" name="runits" value="<?php echo NTemplateHelpers::escapeHtml($el->option('radiusUnits'), ENT_COMPAT) ?>" disabled />

		<div class="radius-display radius-input-hidden">
			<span class="radius-clear"><i class="fa fa-times"></i></span>
			<?php if ($type != 2 && $type != 3) { ?><span class="radius-text"><?php echo NTemplateHelpers::escapeHtml(__('Radius:', 'wplatte'), ENT_NOQUOTES) ?>
</span><?php } ?>

<?php if ($type == 2 || $type == 3) { ?>
			<span class="radius-value"></span>
			<span class="radius-units"><?php echo NTemplateHelpers::escapeHtml($el->option('radiusUnits'), ENT_NOQUOTES) ?></span>
<?php } ?>
		</div>

		<div class="radius-popup-container radius-input-hidden">
			<span class="radius-popup-close"><i class="fa fa-times"></i></span>
<?php if ($type != 2 && $type != 3) { ?>
			<span class="radius-value"></span>
			<span class="radius-units"><?php echo NTemplateHelpers::escapeHtml($el->option('radiusUnits'), ENT_NOQUOTES) ?></span>
<?php } ?>
			<input type="range" name="rad" placeholder="100" class="radius-search" value="<?php if ($selectedRad) { echo NTemplateHelpers::escapeHtml($selectedRad, ENT_COMPAT) ;} else { ?>
0.1<?php } ?>" min="0.1" step="0.1" max="100" disabled />
			<span class="radius-popup-help"><?php echo NTemplateHelpers::escapeHtml($el->option('radiusHelp'), ENT_NOQUOTES) ?></span>
		</div>


	</div>
<?php $searchRadius = ob_get_clean() ?>
<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-main" class="<?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>-main">

<?php if ($el->option('type') == 3) { if (($el->hasOption('title') and $el->option->title)) { ?>

		<div<?php if ($_l->tmp = array_filter(array('elm-mainheader', $el->hasOption('headAlign') ? $el->option->headAlign:null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
<?php if ($el->option->title) { ?>
				<h2 class="elm-maintitle"><?php echo $el->option->title ?></h2>
<?php } ?>
		</div>

<?php } } ?>

<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="<?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>">

	<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>-container"<?php if ($_l->tmp = array_filter(array('search-form-container', "search-type-{$type}"))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
		<form action="<?php echo $homeUrl ?>" method="get" class="main-search-form">

			<div class="elm-wrapper">
				<div class="inputs-container">
					<div class="search-shadow"></div>
					<div class="search-content">
<?php if ($type == 2) { ?>

<?php $sentence = '<span class="label">'.$el->option('sentence').'</span>' ;$sentence = '<span class="label">'.$el->option('sentence').'</span>' ;$sentence = str_replace('{', '</span>{', $sentence) ;$sentence = str_replace('}', '}<span class="label">', $sentence) ?>

<?php if (strpos($sentence, '{search-keyword}') !== false) { $sentence = str_replace('{search-keyword}', $searchKeyword, $sentence) ;} else { ?>
					 			<input type="hidden" name="s" value="" />
<?php } ?>

<?php $sentence = str_replace('{search-category}', $searchCategory, $sentence) ;$sentence = str_replace('{search-location}', $searchLocation, $sentence) ?>

<?php $sentence = str_replace('{search-radius}', $searchRadius, $sentence) ?>

					 		<?php echo $sentence ?>


<?php } elseif ($type == 3) { ?>

					 		<div class="search-inputs-wrap">
<?php if ($el->option('enableKeywordSearch')) { ?>
					 				<?php echo $searchKeyword ?>

<?php } else { ?>
									<input type="hidden" name="s" value="" />
<?php } ?>

					 			<!--<div class="searchsubmit-wrapper">-->
					 				<div class="submit-main-button">
										<div class="searchsubmit2"><?php echo NTemplateHelpers::escapeHtml(__('Search', 'wplatte'), ENT_NOQUOTES) ?></div>
										<input type="submit" value="<?php echo NTemplateHelpers::escapeHtml(__('Search', 'wplatte'), ENT_COMPAT) ?>" class="searchsubmit" />
									</div>
								<!--</div>-->
					 		</div>

<?php if ($el->option('type') == 3) { if (($el->hasOption('description') and $el->option->description)) { if ($el->option->description) { ?>
										<p class="elm-maindesc"><?php echo $el->option->description ?></p>
<?php } } } ?>

					 		<div class="search-inputs-buttons-wrap">

<?php if ($el->option('enableCategorySearch')) { ?>
					 				<?php echo $searchCategory ?>

<?php } ?>

<?php if ($el->option('enableLocationSearch')) { ?>
									<?php echo $searchLocation ?>

<?php } ?>

<?php if ($el->option('enableRadiusSearch')) { ?>
									<?php echo $searchRadius ?>

<?php } ?>

					 		</div>

<?php } else { ?>
					 		<div class="search-inputs-wrap">
<?php if ($el->option('enableKeywordSearch')) { ?>
									<?php echo $searchKeyword ?>

<?php } else { ?>
									<input type="hidden" name="s" value="" />
<?php } ?>

<?php if ($el->option('enableCategorySearch')) { ?>
									<?php echo $searchCategory ?>

<?php } ?>

<?php if ($el->option('enableLocationSearch')) { ?>
									<?php echo $searchLocation ?>

<?php } ?>
							</div>

<?php if ($el->option('enableRadiusSearch')) { ?>
								<?php echo $searchRadius ?>

<?php } ?>

<?php } ?>

						<input type="hidden" name="a" value="true" /> <!-- Advanced search -->
						<!-- <input type="hidden" name="lang" value="<?php echo NTemplateHelpers::escapeHtmlComment(AitLangs::getCurrentLanguageCode()) ?>"> --> <!-- Advanced search -->

<?php if ($selectedKey) { ?>
						<div class="searchinput search-input-width-hack" style="position: fixed; z-index: 99999; visibility: hidden" data-defaulttext="<?php echo NTemplateHelpers::escapeHtml(__('Search keyword', 'wplatte'), ENT_COMPAT) ?>
"><?php echo NTemplateHelpers::escapeHtml($selectedKey, ENT_NOQUOTES) ?></div>
<?php } else { ?>
						<div class="searchinput search-input-width-hack" style="position: fixed; z-index: 99999; visibility: hidden" data-defaulttext="<?php echo NTemplateHelpers::escapeHtml(__('Search keyword', 'wplatte'), ENT_COMPAT) ?>
"><?php echo NTemplateHelpers::escapeHtml(__('Search keyword', 'wplatte'), ENT_NOQUOTES) ?></div>
<?php } ?>
					</div>
<?php if ($type != 3) { ?>
					<div class="searchsubmit-wrapper">
						<div class="submit-main-button">
							<div class="searchsubmit2"><?php echo NTemplateHelpers::escapeHtml(__('Search', 'wplatte'), ENT_NOQUOTES) ?></div>
							<input type="submit" value="<?php echo NTemplateHelpers::escapeHtml(__('Search', 'wplatte'), ENT_COMPAT) ?>" class="searchsubmit" />
						</div>
					</div>
<?php } ?>

				</div>
			</div>

		</form>
	</div>

</div>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("ait-theme/elements/search-form/javascript", ""), array() + get_defined_vars(), $_l->templates['7yc5wdrhdk'])->render() ?>

</div>