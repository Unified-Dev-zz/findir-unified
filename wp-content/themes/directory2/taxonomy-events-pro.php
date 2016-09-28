{block content}
	{? global $wp_query}

	{var $currentCategory = get_queried_object()}

	{includePart portal/parts/taxonomy-category-list, taxonomy => "ait-events-pro"}

	{if $currentCategory->description}
	<div class="entry-content">
		{!$currentCategory->description}
	</div>
	{/if}


	<div n:class="items-container, !$wp->willPaginate($wp_query) ? 'pagination-disabled'">
		<div class="content">

			{if $wp_query->have_posts()}

			{includePart portal/parts/search-filters, postType => 'ait-event-pro', taxonomy => "ait-events-pro", current => $wp_query->post_count, max => $wp_query->found_posts}

			{if defined("AIT_ADVANCED_FILTERS_ENABLED")}
				{includePart portal/parts/advanced-filters, query => $wp_query}
			{/if}

			<div class="ajax-container">
				<div class="content">

					{customLoop from $wp_query as $post}
						{var $categories = get_the_terms($post->id, 'ait-events-pro')}

						{var $isFeatured = false }

						{var $imgWidth = 768}
						{var $imgHeight = 195}

						<div n:class='event-container, $isFeatured ? "item-featured", defined("AIT_REVIEWS_ENABLED") ? reviews-enabled'>

							<a href="{$post->permalink}">
								{var $imgHeight = ($imgWidth / 4) * 3}
								<div class="item-thumbnail">
									{if $post->hasImage}
									<div class="item-thumbnail-wrap" style="background-image: url('{imageUrl $post->imageUrl, width => $imgWidth, height => $imgHeight, crop => 1}')"></div>
									{else}
									<div class="item-thumbnail-wrap" style="background-image: url('{imageUrl $noFeatured, width => $imgWidth, height => $imgHeight, crop => 1}')"></div>
									{/if}
									<div class="item-text-wrap">
										<div class="item-more">{__ 'More info'}</div>
									</div>
								</div>

								{var $nextDates = AitEventsPro::getEventClosestDate($post->id)}
								{var $date_timestamp = strtotime($nextDates['dateFrom'])}
								{var $day = date_i18n('d', $date_timestamp)}
								{var $month = date_i18n('M', $date_timestamp)}
								{var $year = date_i18n('Y', $date_timestamp)}
								{var $moreDates = count(AitEventsPro::getEventRecurringDates($post->id)) - 1}

								<div class="entry-date">
									<div class="day">{$day}</div>
									<span class="month">{$month}</span>
									<span class="year">{$year}</span>
								</div>

								{if $moreDates > 0}<div class="more">+ {$moreDates}</div>{/if}

							</a>
							<div class="item-text">
								<div class="item-title"><a href="{$post->permalink}"><h3>{!$post->title}</h3></a></div>
								<div class="item-excerpt"><p class="txtrows-3">{!$post->excerpt(8)|striptags}</p></div>

								<div class="item-taxonomy">
									<div class="item-categories">{includePart "portal/parts/event-taxonomy", itemID => $post->id, taxonomy => 'ait-events-pro', onlyParent => true, count => 3}</div>
								</div>
							</div>

							<div class="item-location">
								{foreach $post->categories('ait-locations') as $loc}
								<a href="{$loc->url()}" class="location">{!$loc->title}</a>
								{/foreach}
							</div>

						</div>


					{/customLoop}

					{includePart parts/pagination, location => pagination-below, max => $wp_query->max_num_pages}
				</div>
			</div>

			{else}
				{includePart parts/none, message => empty-site}
			{/if}
		</div>
	</div>
