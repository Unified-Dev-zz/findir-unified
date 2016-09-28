<?php //netteCache[01]000558a:2:{s:4:"time";s:21:"0.09816400 1474980964";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:72:"/var/www/html/findir/wp-content/themes/directory2/parts/post-content.php";i:2;i:1474608418;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.0";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:4:"1.65";}}}?><?php

// source file: /var/www/html/findir/wp-content/themes/directory2/parts/post-content.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'qgc2zwonbq')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
$concreteTaxonomy = isset($taxonomy) && $taxonomy != "" ? $taxonomy : '' ;$maxCategories = $options->theme->items->maxDisplayedCategories ?>

<?php if (!$wp->isSingular) { ?>

<?php if ($wp->isSearch) { $isAdvanced = false ?>

<?php if (isset($_REQUEST['a']) && $_REQUEST['a'] != "") { $isAdvanced = true ;} ?>

<?php if ($isAdvanced) { $noFeatured = $options->theme->item->noFeatured ?>

<?php $categories = get_the_terms($post->id, 'ait-items') ;$categories_featured = array() ;$categories_nofeatured = array() ?>

<?php if (is_array($categories) && count($categories) > 0) { $iterations = 0; foreach ($categories as $category) { $cat_meta = get_option($category->taxonomy . "_category_" . $category->term_id) ;if (isset($cat_meta['category_featured'])) { array_push($categories_featured, $category) ;} else { array_push($categories_nofeatured, $category) ;} $iterations++; } $categories = array_merge($categories_featured, $categories_nofeatured) ;} ?>

<?php $meta = $post->meta('item-data') ?>

<?php $dbFeatured = get_post_meta($post->id, '_ait-item_item-featured', true) ;$isFeatured = $dbFeatured != "" ? filter_var($dbFeatured, FILTER_VALIDATE_BOOLEAN) : false ?>

				<div<?php if ($_l->tmp = array_filter(array('item-container', $isFeatured ? 'item-featured':null, defined("AIT_REVIEWS_ENABLED") ? 'reviews-enabled':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
						<div class="content">

							<div class="item-image">
								<a class="main-link" href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>">
									<span><?php echo NTemplateHelpers::escapeHtml(__('View Detail', 'wplatte'), ENT_NOQUOTES) ?></span>
<?php if ($post->image) { ?>
										<img src="<?php echo aitResizeImage($post->imageUrl, array('width' => 200, 'height' => 240, 'crop' => 1)) ?>" alt="Featured" />
<?php } else { ?>
										<img src="<?php echo aitResizeImage($noFeatured, array('width' => 200, 'height' => 240, 'crop' => 1)) ?>" alt="Featured" />
<?php } ?>
								</a>
<?php if (defined('AIT_REVIEWS_ENABLED')) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("portal/parts/carousel-reviews-stars", ""), array('item' => $post, 'showCount' => false) + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ;} ?>
							</div>
							<div class="item-data">
								<div class="item-header">
									<div class="item-title-wrap">
										<div class="item-title">
											<a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>">
												<h3><?php echo $post->title ?></h3>
											</a>
										</div>
										<span class="subtitle"><?php echo NTemplateHelpers::escapeHtml(AitLangs::getCurrentLocaleText($meta->subtitle), ENT_NOQUOTES) ?></span>
									</div>

<?php $target = $meta->socialIconsOpenInNewWindow ? 'target="_blank"' : "" ;if ($meta->displaySocialIcons) { ?>

											<div class="social-icons-container">
												<div class="content">
<?php if (count($meta->socialIcons) > 0) { ?>
														<ul><!--
<?php $iterations = 0; foreach ($meta->socialIcons as $icon) { ?>
														--><li>
																<a href="<?php echo $icon['link'] ?>" <?php echo $target ?>>
																	<i class="fa <?php echo NTemplateHelpers::escapeHtml($icon['icon'], ENT_COMPAT) ?>"></i>
																</a>
															</li><!--
<?php $iterations++; } ?>
														--></ul>
<?php } ?>
												</div>
											</div>

<?php } ?>

<?php if (is_array($categories) && count($categories) > 0) { ?>
										<div class="item-categories">
<?php $iterations = 0; foreach ($categories as $category) { $catLink = get_term_link($category) ?>
												<a href="<?php echo NTemplateHelpers::escapeHtml($catLink, ENT_COMPAT) ?>
"><span class="item-category"><?php echo $category->name ?></span></a>
<?php $iterations++; } ?>
										</div>
<?php } ?>
								</div>
								<div class="item-body">
									<div class="entry-content">
										<p class="txtrows-4"><?php if ($post->hasExcerpt) { echo $template->truncate($template->trim($template->striptags($post->excerpt)), 140) ;} else { echo $template->truncate($template->trim($template->striptags($post->content)), 250) ;} ?></p>
									</div>
								</div>
								<div class="item-footer">
<?php if ($meta->map['address']) { ?>
									<div class="item-address">
										<span class="label"><?php echo NTemplateHelpers::escapeHtml(__('Address:', 'wplatte'), ENT_NOQUOTES) ?></span>
										<span class="value"><?php echo NTemplateHelpers::escapeHtml($meta->map['address'], ENT_NOQUOTES) ?></span>
									</div>
<?php } ?>

<?php if ($meta->web) { ?>
									<div class="item-web">
										<span class="label"><?php echo NTemplateHelpers::escapeHtml(__('Web:', 'wplatte'), ENT_NOQUOTES) ?></span>
										<span class="value"><a href="<?php echo $meta->web ?>" target="_blank"><?php if ($meta->webLinkLabel) { echo NTemplateHelpers::escapeHtml($meta->webLinkLabel, ENT_NOQUOTES) ;} else { echo NTemplateHelpers::escapeHtml($meta->web, ENT_NOQUOTES) ;} ?></a></span>
									</div>
<?php } ?>

<?php if (!is_array($meta->features)) { $meta->features = array() ;} ?>

<?php if (defined('AIT_ADVANCED_FILTERS_ENABLED')) { $item_meta_filters = $post->meta('filters-options') ;if (is_array($item_meta_filters->filters) && count($item_meta_filters->filters) > 0) { $custom_features = array() ;$iterations = 0; foreach ($item_meta_filters->filters as $filter_id) { $filter_data = get_term($filter_id, 'ait-items_filters', "OBJECT") ;if ($filter_data) { $filter_meta = get_option( "ait-items_filters_category_".$filter_data->term_id ) ;$filter_icon = isset($filter_meta['icon']) ? $filter_meta['icon'] : "" ;array_push($meta->features, array(
														"icon" => $filter_icon,
														"text" => $filter_data->name,
														"desc" => $filter_data->description
													)) ;} $iterations++; } } } ?>


<?php if (is_array($meta->features) && count($meta->features) > 0) { ?>
									<div class="item-features">
										<div class="label"><?php echo NTemplateHelpers::escapeHtml(__('Features:', 'wplatte'), ENT_NOQUOTES) ?></div>
										<div class="value">
											<ul class="item-filters">
<?php $iterations = 0; foreach ($meta->features as $filter) { $imageClass = $filter['icon'] != '' ? 'has-image' : '' ;$textClass = $filter['text'] != '' ? 'has-text' : '' ?>

												<li class="item-filter <?php echo NTemplateHelpers::escapeHtml($imageClass, ENT_COMPAT) ?>
 <?php echo NTemplateHelpers::escapeHtml($textClass, ENT_COMPAT) ?>">
<?php if ($filter['icon'] != '') { ?>
													<i class="fa <?php echo NTemplateHelpers::escapeHtml($filter['icon'], ENT_COMPAT) ?>"></i>
<?php } ?>
													<span class="filter-hover">
														<?php echo $filter['text'] ?>

													</span>

												</li>
<?php $iterations++; } ?>
											</ul>
										</div>
									</div>
<?php } ?>


								</div>
							</div>
						</div>


				</div>

<?php } else { ?>
								<article <?php echo $post->htmlId ?> <?php echo $post->htmlClass('hentry') ?>>
					<header class="entry-header">

						<div class="entry-title">

							<div class="entry-title-wrap">
<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-date-format", ""), array('dateIcon' => $post->rawDate, 'dateLinks' => 'no', 'dateShort' => 'no') + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ?>
								<h2><a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>
"><?php echo $post->title ?></a></h2>
<?php if ($post->type == 'post') { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-author", ""), array() + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ;} ?>
							</div><!-- /.entry-title-wrap -->
						</div><!-- /.entry-title -->
					</header><!-- /.entry-header -->

					<div class="entry-content loop">
						<?php echo $post->excerpt ?>

						<a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>
" class="more"><?php echo __('read more', 'wplatte') ?></a>
					</div><!-- .entry-content -->

<!-- 					<footer class="entry-footer">
<?php if ($concreteTaxonomy) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-categories", ""), array('taxonomy' => $concreteTaxonomy) + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ;} else { if ($post->isInAnyCategory) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-categories", ""), array('taxonomy' => $concreteTaxonomy) + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ;} } ?>
					</footer> --><!-- /.entry-footer -->
				</article>
<?php } ?>

<?php } else { ?>

						<article <?php echo $post->htmlId ;if ($_l->tmp = array_filter(array('hentry' , $post->htmlClass('', false), !$post->hasImage ? 'has-no-thumbnail':null))) echo ' class="' . NTemplateHelpers::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT) . '"' ?>>
				<div class="entry-wrap">
					<header class="entry-header <?php if (!$post->hasImage) { ?>nothumbnail<?php } ?>">

						<div class="entry-thumbnail-desc">

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-date-format", ""), array('dateIcon' => $post->rawDate, 'dateLinks' => 'no', 'dateShort' => 'yes') + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ?>

							<div class="entry-title">
								<div class="entry-title-wrap">
									<h2><a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>
"><?php echo $post->title ?></a></h2>
								</div><!-- /.entry-title-wrap -->
							</div><!-- /.entry-title -->

<?php if ($post->hasImage) { ?>
								<div class="more-wrap">
									<a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>
" class="more"><?php echo __('read more', 'wplatte') ?></a>
								</div>
<?php } ?>

						</div>

<?php if ($post->hasImage) { ?>
							<div class="entry-thumbnail">
								<div class="entry-thumbnail-wrap entry-content" style="background-image: url('<?php echo aitResizeImage($post->imageUrl, array('width' => 1000, 'height' => 350, 'crop' => 1)) ?>')"></div>
							</div>
<?php } ?>

						<div class="entry-meta">
<?php if ($post->isSticky and !$wp->isPaged and $wp->isHome) { ?>
								<span class="featured-post"><?php echo NTemplateHelpers::escapeHtml(__('Featured post', 'wplatte'), ENT_NOQUOTES) ?></span>
<?php } ?>

							<?php ob_start() ?><span class="edit-link"><?php echo __('Edit', 'wplatte') ?>
</span><?php $editLinkLabel = ob_get_clean() ?>

	      					<?php echo $post->editLink($editLinkLabel) ?>

						</div>

					</header><!-- /.entry-header -->

					<footer class="entry-footer">
						<div class="entry-data">

<?php if ($post->type == 'post') { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-author", ""), array() + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ;} ?>

<?php if ($post->isInAnyCategory) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-categories", ""), array() + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ;} ?>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/comments-link", ""), array() + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ?>

						</div>
					</footer><!-- .entry-footer -->
				</div>

				<div class="entry-content loop">
<?php if ($post->hasContent) { ?>
						<?php echo $post->excerpt ?>

<?php } else { ?>
						<?php echo $post->content ?>

<?php } ?>

<?php if (!$post->hasImage) { ?>
						<div class="more-wrap no-thumbnail">
							<a href="<?php echo NTemplateHelpers::escapeHtml($post->permalink, ENT_COMPAT) ?>
" class="more"><?php echo __('read more', 'wplatte') ?></a>
						</div>
<?php } ?>

				</div><!-- .entry-content -->

			</article>
<?php } ?>

<?php } else { ?>

				<article <?php echo $post->htmlId ?> class="content-block hentry">

			<div class="entry-title hidden-tag">
				<h2><?php echo $post->title ?></h2>
			</div>

			<div class="entry-thumbnail">
<?php if ($post->hasImage) { ?>
						<div class="entry-thumbnail-wrap">
<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/comments-link", ""), array() + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ?>
						 <a href="<?php echo NTemplateHelpers::escapeHtml($post->imageUrl, ENT_COMPAT) ?>" class="thumb-link">
						  <span class="entry-thumbnail-icon">
							<img src="<?php echo aitResizeImage($post->imageUrl, array('width' => 1000, 'height' => 400, 'crop' => 1)) ?>
" alt="<?php echo $post->title ?>" />
						  </span>
						 </a>
						</div>
<?php } ?>
				</div>

			<div class="entry-content">
				<?php echo $post->content ?>

				<?php echo $post->linkPages ?>

			</div><!-- .entry-content -->

			<footer class="entry-footer single">

<?php if ($post->categoryList) { NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/entry-categories", ""), array('taxonomy' => 'category') + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ;} ?>

<?php if ($post->tagList) { ?>
					<span class="tags">
						<span class="tags-links"><?php echo $post->tagList ?></span>
					</span>
<?php } ?>


			</footer><!-- .entry-footer -->

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("parts/author-bio", ""), array() + get_defined_vars(), $_l->templates['qgc2zwonbq'])->render() ?>


		</article>

<?php } 