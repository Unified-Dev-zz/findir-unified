<?php //netteCache[01]000569a:2:{s:4:"time";s:21:"0.13161800 1474649211";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:83:"/home/zaerodes/public_html/findir/wp-content/themes/directory2/parts/page-title.php";i:2;i:1474646218;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /home/zaerodes/public_html/findir/wp-content/themes/directory2/parts/page-title.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'e9cx02x9h4')
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
	<?php ob_start() ?><span class="edit-link"><?php echo __('Edit', 'wplatte') ?></span><?php $editLinkLabel = ob_get_clean() ?>


<?php $titleClass = '' ;$titleName = '' ;$editButton = '' ;$titleImage = '' ;$dateIcon = '' ;$dateLinks = '' ;$dateShort = '' ;$dateInterval = '' ;$titleAuthor = '' ;$titleCategory = '' ;$titleComments = '' ;$titleSubDesc = '' ;$titleDesc = $el->option('description') ;$pageShare = $el->option('pageShare') ;$showPager = '' ;$titleExcerpt = '' ;$categoryColor = '' ?>

<?php $subtitle = "" ;$subtext = "" ?>

<?php if (defined('AIT_EVENTS_PRO_ENABLED')) { $eventOptions = get_option('ait_events_pro_options', array()) ;} ?>

<?php $itemExpired = "" ?>


<?php if ($wp->is404 or $wp->isSearch or $wp->isWoocommerce()) { ?>

	 <?php if ($wp->is404) { ?>				<?php $titleClass = "simple-title" ?> <?php } ?>

	 <?php if ($wp->isSearch) { ?>			<?php $titleClass = "simple-title" ?> <?php } ?>

	 <?php if ($wp->isWoocommerce()) { ?>	<?php $titleClass = "simple-title" ?> <?php } ?>


	 <?php if ($wp->is404) { ?>				<?php ob_start() ;echo NTemplateHelpers::escapeHtml(__("This is somewhat embarrassing, isn't it?", 'wplatte'), ENT_NOQUOTES) ;$titleName = ob_get_clean() ?>
			<?php } ?>

<?php if ($wp->isSearch) { if (isset($_REQUEST['a']) && $_REQUEST['a'] != "") { $sString = array() ?>
									<?php if (isset($_REQUEST['s']) && $_REQUEST['s'] != "") { array_push($sString, htmlspecialchars($_REQUEST['s']) ) ;} ?>

<?php if (isset($_REQUEST['category']) && $_REQUEST['category'] != "") { $dCategory = get_term($_REQUEST['category'], 'ait-items') ?>
										<?php if (isset($dCategory)) { array_push($sString, $dCategory->name) ;} ?>

<?php } if (isset($_REQUEST['location']) && $_REQUEST['location'] != "") { $dLocation = get_term($_REQUEST['location'], 'ait-locations') ?>
										<?php if (isset($dLocation)) { array_push($sString, $dLocation->name) ;} ?>

<?php } ?>

<?php ob_start() ?>
										<?php ob_start() ?><span class="title-data"><?php echo implode(", ", $sString) ?>
</span><?php $searchTitle = ob_get_clean() ?>

<?php if (count($sString) > 0) { ?>
										<?php echo $template->printf(__('Search Results for: %s', 'wplatte'), $searchTitle) ?>

<?php } else { ?>
										<?php echo $template->printf(__('Search Results: %s', 'wplatte'), $searchTitle) ?>

<?php } $titleName = ob_get_clean() ;} else { ob_start() ?>
										<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($wp->searchQuery, ENT_NOQUOTES) ?>
</span><?php $searchTitle = ob_get_clean() ?>

										<?php echo $template->printf(__('Search Results for: %s', 'wplatte'), $searchTitle) ?>

<?php $titleName = ob_get_clean() ;} } ?>

	 <?php if ($wp->isWoocommerce()) { ?>	<?php ob_start() ;woocommerce_page_title() ;$titleName = ob_get_clean() ?>
								<?php } ?>


<?php } elseif ($wp->isPage or $wp->isSingular('post') or $wp->isSingular('portfolio-item') or $wp->isSingular('event') or $wp->isSingular('job-offer') or $wp->isSingular('item') or $wp->isSingular('event-pro') or $wp->isAttachment) { foreach($iterator = new WpLatteLoopIterator() as $post): ?>

	 <?php if ($wp->isPage) { ?> 					<?php $titleClass = "standard-title" ?> 				<?php } ?>

	 <?php if ($wp->isSingular('post')) { ?> 			<?php $titleClass = "post-title" ?>
 					<?php } ?>

	 <?php if ($wp->isSingular('portfolio-item')) { ?> <?php $titleClass = "post-title portfolio-title" ?>
 	<?php } ?>

	 <?php if ($wp->isSingular('event')) { ?> 			<?php $titleClass = "post-title event-title" ?>
 		<?php } ?>

	 <?php if ($wp->isSingular('job-offer')) { ?> 		<?php $titleClass = "post-title job-offer-title" ?>
	<?php } ?>

	 <?php if ($wp->isAttachment) { ?>				<?php $titleClass = "post-title attach-title" ?>
		<?php } ?>


	 <?php if ($wp->isSingular('event')) { $meta = $post->meta('event-data') ?>
						   <?php } elseif ($wp->isSingular('job-offer')) { ?>	<?php $meta = $post->meta('offer-data') ?>

<?php } ?>

<?php $titleName = $post->title ;$titleImage = $post->imageUrl ?>
						   <?php if ($wp->isAttachment or $wp->isSingular('portfolio-item') or $wp->isSingular('job-offer') or $wp->isSingular('post') or $wp->isPage or $wp->isSingular('event') or $wp->isSingular('item') or $wp->isSingular('event-pro')) { ?>
 <?php $titleImage = '' ?> <?php } ?>

	 <?php ob_start() ;echo $post->editLink($editLinkLabel) ;$editButton = ob_get_clean() ?>


	 <?php if ($wp->isSingular('portfolio-item')) { ?> <?php $dateIcon = FALSE ?> 			<?php $dateLinks = 'no' ?>
 	<?php $dateShort = 'no' ?> <?php } ?>

	 <?php if ($wp->isSingular('event')) { ?> 			<?php $dateIcon = FALSE ?> 			<?php $dateLinks = 'no' ?>
 	<?php $dateShort = 'no' ?> <?php } ?>

	 <?php if ($wp->isSingular('job-offer')) { ?> 		<?php $dateIcon = FALSE ?> 			<?php $dateLinks = 'no' ?>
 	<?php $dateShort = 'no' ?> <?php } ?>

	 <?php if ($wp->isAttachment) { ?> 				<?php $dateIcon = $post->rawDate ?>  		<?php $dateLinks = 'no' ?>
		<?php $dateShort = 'no' ?> <?php } ?>

	 <?php if ($wp->isSingular('post')) { ?> 			<?php $dateIcon = $post->rawDate ?>
  		<?php $dateLinks = 'no' ?>		<?php $dateShort = 'yes' ?> <?php } ?>


	 <?php if ($wp->isSingular('event')) { ?>			<?php ob_start() ;echo NTemplateHelpers::escapeHtml(__('Duration:', 'wplatte'), ENT_NOQUOTES) ;$intLabel = ob_get_clean() ?>

<?php $intFrom = $meta->dateFrom ;$intTo = $meta->dateTo ?>
																<?php if ($intTo) { $dateInterval = 'yes' ;} ?>

<?php } ?>
	 <?php if ($wp->isSingular('job-offer')) { ?>		<?php ob_start() ;echo NTemplateHelpers::escapeHtml(__('Validity:', 'wplatte'), ENT_NOQUOTES) ;$intLabel = ob_get_clean() ?>

<?php $intFrom = $meta->validFrom ;$intTo = $meta->validTo ;$dateInterval = 'yes' ;} if ($wp->isSingular('job-offer')) { if (strtotime($meta->validTo) <= intval(date("U"))) { ?>
									<?php ob_start() ?><span class="expired"><?php echo NTemplateHelpers::escapeHtml(__('Expired: ', 'wplatte'), ENT_NOQUOTES) ?>
</span><?php $itemExpired = ob_get_clean() ?>

<?php } } ?>

	 <?php if ($wp->isAttachment) { ?> 				<?php $titleAuthor = 'yes' ?> <?php } ?>

	 <?php if ($wp->isSingular('post')) { ?> 			<?php $titleAuthor = 'yes' ?> <?php } ?>


	 <?php if ($post->categoryList) { ?>				<?php $titleCategory = 'no' ?> <?php } ?>



<?php if ($wp->isSingular('item')) { ?>

<?php $taxonomies = $post->taxonomies ;$terms = get_the_terms($post->id, 'ait-items') ;if ($terms) { $category = reset($terms) ;$icons = get_option($category->taxonomy . "_category_" . $category->term_id) ;if (isset($icons['icon']) && $icons['icon'] != "") { ob_start() ?>
											<?php echo NTemplateHelpers::escapeHtml($icons['icon'], ENT_NOQUOTES) ?>

<?php $categoryIcon = ob_get_clean() ;} else { if ($category->parent != 0) { global $wp_query ;$category = get_term($category->parent, $category->taxonomy) ;$icons = get_option($category->taxonomy . "_category_" . $category->term_id) ;if (isset($icons['icon']) && $icons['icon'] != "") { ob_start() ?>
													<?php echo NTemplateHelpers::escapeHtml($icons['icon'], ENT_NOQUOTES) ?>

<?php $categoryIcon = ob_get_clean() ;} else { ob_start() ;if ($category->taxonomy == "ait-items") { ?>
													<?php echo NTemplateHelpers::escapeHtml($options->theme->items->categoryDefaultIcon, ENT_NOQUOTES) ?>

<?php } else { ?>
													<?php echo NTemplateHelpers::escapeHtml($options->theme->items->locationDefaultIcon, ENT_NOQUOTES) ?>

<?php } $categoryIcon = ob_get_clean() ;} } else { ob_start() ;if ($category->taxonomy == "ait-items") { ?>
												<?php echo NTemplateHelpers::escapeHtml($options->theme->items->categoryDefaultIcon, ENT_NOQUOTES) ?>

<?php } else { ?>
												<?php echo NTemplateHelpers::escapeHtml($options->theme->items->locationDefaultIcon, ENT_NOQUOTES) ?>

<?php } $categoryIcon = ob_get_clean() ;} } } } if ($wp->isSingular('event-pro')) { ?>

<?php $eventProMeta = $post->meta('event-pro-data') ;ob_start() ;NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/single-event-date", ""), array('meta' => $eventProMeta, 'place' => 'header', 'eventId' => $post->id) + get_defined_vars(), $_l->templates['e9cx02x9h4'])->render() ;$eventDateIcon = ob_get_clean() ;} ?>

<?php if ($wp->isSingular('job-offer')) { if ($post->imageUrl) { $categoryIcon = $post->imageUrl ;} } ?>

<?php if ($wp->isSingular('item')) { $itemMeta = $post->meta('item-data') ;$subtitle = AitLangs::getCurrentLocaleText($itemMeta->subtitle) ;} ?>

<?php if ($wp->isSingular('event-pro')) { $titleExcerpt = $post->excerpt(16) ;} ?>

<?php endforeach ?>

<?php } elseif ($wp->isBlog and $blog) { ?>

<?php $titleClass = "blog-title" ;$titleName = $blog->title ;$titleImage = $blog->imageUrl ?>
	 <?php ob_start() ;echo $blog->editLink($editLinkLabel) ;$editButton = ob_get_clean() ?>


<?php } elseif ($wp->isCategory or $wp->isArchive or $wp->isTag or $wp->isAuthor or $wp->isTax('portfolios') or $wp->isTax('items') or $wp->isTax('events-pro') or $wp->isTax('locations')) { ?>



<?php $titleClass = "archive-title" ?>

	 <?php if ($wp->isCategory) { ob_start() ?>
																	<?php ob_start() ?><span class="title-data"><?php echo $category->title ?>
</span><?php $categoryTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Category Archives: %s', 'wplatte'), $categoryTitle) ?>

<?php $titleName = ob_get_clean() ?>

<?php } elseif ($wp->isTax('items') or $wp->isTax('locations') or $wp->isTax('ait-events-pro')) { $category = get_queried_object() ;ob_start() ?>
									<?php ob_start() ?><span class="title-data"><?php echo $category->name ?>
</span><?php $categoryTitle = ob_get_clean() ?>

									<?php echo $template->printf(__('%s', 'wplatte'), $categoryTitle) ?>

<?php $titleName = ob_get_clean() ?>

	 <?php } elseif ($wp->isTag) { ?>					<?php ob_start() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($tag->title, ENT_NOQUOTES) ?>
</span><?php $tagTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Tag Archives: %s', 'wplatte'), $tagTitle) ?>

<?php $titleName = ob_get_clean() ?>
	 <?php } elseif ($wp->isPostTypeArchive) { ?>		<?php ob_start() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($archive->title, ENT_NOQUOTES) ?>
</span><?php $archiveTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Archives: %s', 'wplatte'), $archiveTitle) ?>

<?php $titleName = ob_get_clean() ?>
	 <?php } elseif ($wp->isTax) { ?>					<?php ob_start() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($taxonomyTerm->title, ENT_NOQUOTES) ?>
</span><?php $taxonomyTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Category Archives: %s', 'wplatte'), $taxonomyTitle) ?>

<?php $titleName = ob_get_clean() ?>
	 <?php } elseif ($wp->isAuthor) { ?>				<?php ob_start() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($author, ENT_NOQUOTES) ?>
</span><?php $authorTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('All posts by %s', 'wplatte'), $authorTitle) ?>

<?php $titleName = ob_get_clean() ;} elseif ($wp->isArchive) { ?>
								<?php if ($archive->isDay) { ob_start() ?>
																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($archive->dateI18n, ENT_NOQUOTES) ?>
</span><?php $dayTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Daily Archives: %s', 'wplatte'), $dayTitle) ?>

<?php $titleName = ob_get_clean() ?>
								<?php } elseif ($archive->isMonth) { ?>		<?php ob_start() ?>

																	<?php ob_start() ;echo NTemplateHelpers::escapeHtml(_x('F Y', 'monthly archives date format', 'wplatte'), ENT_NOQUOTES) ;$monthFormat = ob_get_clean() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($archive->dateI18n($monthFormat), ENT_NOQUOTES) ?>
</span><?php $monthTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Monthly Archives: %s', 'wplatte'), $monthTitle) ?>

<?php $titleName = ob_get_clean() ?>
								<?php } elseif ($archive->isYear) { ?>		<?php ob_start() ?>

																	<?php ob_start() ;echo NTemplateHelpers::escapeHtml(_x('Y',  'yearly archives date format', 'wplatte'), ENT_NOQUOTES) ;$yearFormat = ob_get_clean() ?>

																	<?php ob_start() ?><span class="title-data"><?php echo NTemplateHelpers::escapeHtml($archive->dateI18n($yearFormat), ENT_NOQUOTES) ?>
</span><?php $yearTitle = ob_get_clean() ?>

																	<?php echo $template->printf(__('Yearly Archives: %s', 'wplatte'), $yearTitle) ?>

<?php $titleName = ob_get_clean() ?>
								<?php } else { ?>							<?php ob_start() ;echo __('Archives:', 'wplatte') ;$titleName = ob_get_clean() ?>

<?php } } ?>

<?php if (isset($category) && isset($category->taxonomy) && isset($category->term_id)) { ?>

<?php $icons = get_option($category->taxonomy . "_category_" . $category->term_id) ;if (isset($icons['icon']) && $icons['icon'] != "") { ob_start() ?>
										<?php echo NTemplateHelpers::escapeHtml($icons['icon'], ENT_NOQUOTES) ?>

<?php $categoryIcon = ob_get_clean() ;} else { if ($category->parent != 0) { global $wp_query ;$taxonomy = $wp_query->tax_query->queries[0]['taxonomy'] ;$category = get_term($category->parent, $taxonomy) ;$icons = get_option($category->taxonomy . "_category_" . $category->term_id) ;if (isset($icons['icon']) && $icons['icon'] != "") { ob_start() ?>
												<?php echo NTemplateHelpers::escapeHtml($icons['icon'], ENT_NOQUOTES) ?>

<?php $categoryIcon = ob_get_clean() ;} else { ob_start() ;if ($category->taxonomy == "ait-items") { ?>
													<?php echo NTemplateHelpers::escapeHtml($options->theme->items->categoryDefaultIcon, ENT_NOQUOTES) ?>

<?php } elseif ($category->taxonomy == "ait-events-pro") { ?>
													<?php echo NTemplateHelpers::escapeHtml($eventOptions['categoryDefaultIcon'], ENT_NOQUOTES) ?>

<?php } else { ?>
													<?php echo NTemplateHelpers::escapeHtml($options->theme->items->locationDefaultIcon, ENT_NOQUOTES) ?>

<?php } $categoryIcon = ob_get_clean() ;} } else { ob_start() ;if ($category->taxonomy == "ait-items") { ?>
												<?php echo NTemplateHelpers::escapeHtml($options->theme->items->categoryDefaultIcon, ENT_NOQUOTES) ?>

<?php } elseif ($category->taxonomy == "ait-events-pro") { ?>
												<?php echo NTemplateHelpers::escapeHtml($eventOptions['categoryDefaultIcon'], ENT_NOQUOTES) ?>

<?php } else { ?>
												<?php echo NTemplateHelpers::escapeHtml($options->theme->items->locationDefaultIcon, ENT_NOQUOTES) ?>

<?php } $categoryIcon = ob_get_clean() ;} } } ?>

<?php if ($wp->isTax('ait-events-pro')) { ?>

<?php $icons = get_option($category->taxonomy . "_category_" . $category->term_id) ;if (isset($icons['icon_color']) && $icons['icon_color'] != "") { $categoryColor = $icons['icon_color'] ;} else { if ($category->parent != 0) { global $wp_query ;$taxonomy = $wp_query->tax_query->queries[0]['taxonomy'] ;$category = get_term($category->parent, $taxonomy) ;$icons = get_option($category->taxonomy . "_category_" . $category->term_id) ;if (isset($icons['icon_color']) && $icons['icon_color'] != "") { $categoryColor = $icons['icon_color'] ;} } } } ?>

	 <?php if ($wp->isCategory) { ?>					<?php $titleSubDesc = $category->description ?>
 	<?php } ?>

	 <?php if ($wp->isTag) { ?>						<?php $titleSubDesc = $tag->description ?> 		<?php } ?>


<?php } ?>


<?php if ($subtitle == '' and $titleSubDesc == '' and $titleDesc == '' and $titleExcerpt == '') { $subtext = 'disabled' ;} ?>


<div<?php if ($_l->tmp = array_filter(array('page-title', $pageShare ? 'share-enabled':null, $subtext == 'disabled' ? 'subtitle-missing' :null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>

	<div class="grid-main">
	<div class="grid-table">
	<div class="grid-row">
<?php if (defined('AIT_REVIEWS_ENABLED') && isset($post)) { ?>
		<header class="entry-header <?php echo NTemplateHelpers::escapeHtml(AitItemReviews::itemHasReviews($post->id), ENT_COMPAT) ?>">
<?php } else { ?>
		<header class="entry-header">
<?php } ?>
			<div class="entry-header-left">

			<div class="entry-title <?php echo NTemplateHelpers::escapeHtml($titleClass, ENT_COMPAT) ?>">

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-date-format", ""), array('dateIcon' => $dateIcon, 'dateLinks' => $dateLinks, 'dateShort' => $dateShort) + get_defined_vars(), $_l->templates['e9cx02x9h4'])->render() ;if (isset($eventDateIcon)) { ?>
						<?php echo $eventDateIcon ?>

<?php } ?>
				<div class="entry-title-wrap">

<?php if (isset($categoryIcon)) { ?>
						<div class="cat-icon"><span <?php if (!empty($categoryColor)) { ?>style="background: <?php echo $categoryColor ?>
;"<?php } ?>><img src="<?php echo NTemplateHelpers::escapeHtml($categoryIcon, ENT_COMPAT) ?>
" alt="<?php echo 'titleName' ?>" /></span></div>

<?php } ?>

					<h1><?php echo $itemExpired ;echo $titleName ?></h1>
					<?php if ($subtitle) { ?><span class="subtitle"><?php echo NTemplateHelpers::escapeHtml($subtitle, ENT_NOQUOTES) ?>
</span><?php } ?>


<?php if ($dateInterval == 'yes' or $titleAuthor == 'yes' or $titleCategory == 'yes' or $titleComments == 'yes' or $titleSubDesc) { ?>
						<div class="entry-data">

<?php if ($dateInterval == 'yes') { ?>
								<div class="date-interval">
									<span class="date-interval-title"><strong><?php echo NTemplateHelpers::escapeHtml($intLabel, ENT_NOQUOTES) ?></strong></span>
									<time class="event-from" datetime="<?php echo NTemplateHelpers::escapeHtml($template->date($intFrom, 'c'), ENT_COMPAT) ?>
"><?php echo NTemplateHelpers::escapeHtml($template->dateI18n($intFrom, 'd F Y'), ENT_NOQUOTES) ?></time>
									<span class="date-sep">-</span>
									<time class="event-to" datetime="<?php echo NTemplateHelpers::escapeHtml($template->date($intTo, 'c'), ENT_COMPAT) ?>
"><?php echo NTemplateHelpers::escapeHtml($template->dateI18n($intTo, 'd F Y'), ENT_NOQUOTES) ?></time>
								</div>
<?php } ?>


							<?php if ($titleAuthor == 'yes') { ?> 		<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-author", ""), array() + get_defined_vars(), $_l->templates['e9cx02x9h4'])->render() ?>
		<?php } ?>

							<?php if ($titleCategory == 'yes') { ?>	<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-categories", ""), array() + get_defined_vars(), $_l->templates['e9cx02x9h4'])->render() ?>
	<?php } ?>

							<?php if ($titleComments == 'yes') { ?>	<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/comments-link", ""), array() + get_defined_vars(), $_l->templates['e9cx02x9h4'])->render() ?>
		<?php } ?>

							<?php if ($titleSubDesc) { ?>				<?php echo $titleSubDesc ?>						<?php } ?>

						</div>
<?php } ?>

<?php if ($titleDesc) { ?>
						<div class="page-description"><?php echo $titleDesc ?></div>
<?php } ?>

<?php if ($titleExcerpt) { ?>
						<div class="page-description"><?php echo $titleExcerpt ?></div>
<?php } ?>

<?php if ($editButton) { ?>
						<div class="entry-meta">
							<?php echo $editButton ?>

						</div>
<?php } ?>

				</div>
			</div>

<?php if ($titleImage) { ?>
				<div class="entry-thumbnail">
					<div class="entry-thumbnail-wrap">
						<a href="<?php echo NTemplateHelpers::escapeHtml($titleImage, ENT_COMPAT) ?>" class="thumb-link">
							<span class="entry-thumbnail-icon">
								<img src="<?php echo aitResizeImage($titleImage, array('width' => 1000, 'height' => 500, 'crop' => 1)) ?>
" alt="<?php echo NTemplateHelpers::escapeHtml($titleName, ENT_COMPAT) ?>" />
							</span>
						</a>
					</div>
				</div>
<?php } ?>


<?php if ($showPager == 'yes') { ?>
			<nav class="nav-single" role="navigation">
<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/pagination", ""), array('arrow' => 'left') + get_defined_vars(), $_l->templates['e9cx02x9h4'])->render() ;NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/pagination", ""), array('arrow' => 'right') + get_defined_vars(), $_l->templates['e9cx02x9h4'])->render() ?>
			</nav>
<?php } ?>

			</div>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/breadcrumbs", ""), array() + get_defined_vars(), $_l->templates['e9cx02x9h4'])->render() ?>

		</header><!-- /.entry-header -->

		<!-- page title social icons -->
<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/page-share", ""), array('showShare' => $pageShare) + get_defined_vars(), $_l->templates['e9cx02x9h4'])->render() ?>
		<!-- page title social icons -->

	</div>
	<div class="right-bck"></div>
	</div>
	</div>
</div>



