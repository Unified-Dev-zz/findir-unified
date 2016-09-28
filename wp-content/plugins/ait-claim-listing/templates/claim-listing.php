<?php
$themeOptions = (object)aitOptions()->getOptionsByType('theme');
$themeConfig = aitConfig()->getFullConfig('theme');

$claimListingOptions = $themeOptions->claimListing;

$post = get_post();
$meta = get_post_meta($post->ID, '_ait-item_item-data', true);
$user = get_user_by('id', $post->post_author);
$currentUser = wp_get_current_user();

$cpts_supported = array('ait-item');

$paymentGates = $themeOptions->payments;
unset($paymentGates['currency']);
$paymentGatesConfig = $themeConfig['payments']['@options'][1];
$paymentGatesInstalled = array();
$paymentGatesEnabled = array();
foreach($paymentGates as $name => $value){
	if($paymentGatesConfig[$name]['controller'] == "none" || class_exists($paymentGatesConfig[$name]['controller'])){
		$paymentGatesInstalled[$name] = $value;
	}
}
foreach ($paymentGatesInstalled as $name => $value) {
	if((bool)$value == true){
		$paymentGatesEnabled[$name] = $value;
	}
}

$themePackages = new ThemePackages();

$claimData = get_post_meta($post->ID, 'ait-claim-listing', true);
?>

<?php
if(($claimListingOptions['enable'] == "on" || $claimListingOptions['enable'] == "1") && in_array($post->post_type, $cpts_supported)){
	// the section is enabled within the theme options of the theme

	// enqueue registered script
	wp_enqueue_script( 'ait-claim-listing-frontend' );

	if(!is_array($claimData) || is_array($claimData) && $claimData['status'] === 'unclaimed'){
		// when there are no claim data -> show the form because we dont know the claim status
		// when there is claim data -> show the form only if the status is unclaimed

		if(is_user_logged_in()){				
			if(isCityguideUser($currentUser->roles) /*|| in_array('administrator', $currentUser->roles)*/){ // admin is just for debugging
				$package = $themePackages->getPackageBySlug(AitClaimListing::getUserPackageSlug($currentUser));
				
				if(AitClaimListing::canUserClaim($currentUser, $package)){
					?>
					<div id="claim-listing" class="claim-listing-container">
		
					<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']) != ""){	?>
						<h2><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']); ?></h2>
					<?php } ?>
					
					<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']) != ""){	?>
						<p><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']); ?></p>
					<?php } ?>
						
						<div class="content">

							<a href="#claim-listing-form" id="claim-listing-button" class="resources-button ait-sc-button route-button"><?php _e('Claim Listing', 'ait-claim-listing'); ?></a>
							<div class="claim-listing-fancybox" style="display: none">
								<div id="claim-listing-form" class="claim-listing-form">
									<form method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" class="wp-user-form user-claim-form" onsubmit="javascript: submitAjaxClaimListing(event);">
										<input type="hidden" name="form_post" value="<?php echo $post->ID ?>" />
										<input type="hidden" name="form_user" value="<?php echo $currentUser->ID ?>" />

										<p class="claim-form-user"><?php _e('Claim as: ', 'ait-claim-listing') ?><span><?php echo $currentUser->display_name ?> (<?php echo $currentUser->data->user_email ?>)</span></p>
										<p class="claim-form-text"><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['loggedInFormText']); ?></p>

										<div class="input-wrap input-submit">
											<input type="submit" name="form_submit" value="<?php echo AitLangs::getCurrentLocaleText($claimListingOptions['formLabelSubmit']); ?>">
										</div>
									</form>	
									<div class="claim-notices-container" style="display: none">
										<div class="notice-loader" style="display: none">
											<i class="fa fa-spinner fa-pulse"></i>
										</div>
										<div class="claim-notice form-error-general" style="display: none">
											<?php _e('Server encountered an error, please try again later','ait-claim-listing')?>
										</div>
										<div class="claim-notice form-success-claim" style="display: none">
											<?php _e('Item claimed, wait for admin to permit the claim for the current item','ait-claim-listing')?>
										</div>							
									</div>							
								</div>
							</div>

						</div>
					</div>

					<script id="claim-listing-script">
					jQuery(window).load(function(){
						<?php
							$generalOptions = $themeOptions->general;
							if($generalOptions['progressivePageLoading']){ ?>
							
							if(!isResponsive(1024)){
								jQuery("#claim-listing").waypoint(function(){
									jQuery("#claim-listing").addClass('load-finished');
								}, { triggerOnce: true, offset: "95%" });
							} else {
								jQuery("#claim-listing").addClass('load-finished');
							}

						<?php } else { ?>
							jQuery("#claim-listing").addClass('load-finished');
						<?php } ?>
					});
					</script>
					<?php
				} else {
					if($claimListingOptions['frontendNotification4Enable'] == "on" || $claimListingOptions['frontendNotification4Enable'] == "1"){
					?>
					<div id="claim-listing" class="claim-listing-container">
		
					<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']) != ""){	?>
						<h2><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']); ?></h2>
					<?php } ?>
					
					<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']) != ""){	?>
						<p><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']); ?></p>
					<?php } ?>
						
						<div class="content">	

							<div class="ait-sc-notification attention">
								<div class="notify-wrap">
									<h5><?php _e('Maximum package items exceeded, cannot claim item', 'ait-claim-listing'); ?></h5>
								</div>
							</div>

						</div>
					</div>

					<script id="claim-listing-script">
					jQuery(window).load(function(){
						<?php
							$generalOptions = $themeOptions->general;
							if($generalOptions['progressivePageLoading']){ ?>
							
							if(!isResponsive(1024)){
								jQuery("#claim-listing").waypoint(function(){
									jQuery("#claim-listing").addClass('load-finished');
								}, { triggerOnce: true, offset: "95%" });
							} else {
								jQuery("#claim-listing").addClass('load-finished');
							}

						<?php } else { ?>
							jQuery("#claim-listing").addClass('load-finished');
						<?php } ?>
					});
					</script>
					<?php
					}
				}					
			}else{
				if($claimListingOptions['frontendNotification3Enable'] == "on" || $claimListingOptions['frontendNotification3Enable'] == "1"){
				?>
				<div id="claim-listing" class="claim-listing-container">
		
				<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']) != ""){	?>
					<h2><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']); ?></h2>
				<?php } ?>
				
				<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']) != ""){	?>
					<p><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']); ?></p>
				<?php } ?>
					
					<div class="content">

						<div class="ait-sc-notification attention">
							<div class="notify-wrap">
								<h5><?php _e('Claim listing disabled for current role', 'ait-claim-listing'); ?></h5>
							</div>
						</div>

					</div>
				</div>

				<script id="claim-listing-script">
				jQuery(window).load(function(){
					<?php
						$generalOptions = $themeOptions->general;
						if($generalOptions['progressivePageLoading']){ ?>
						
						if(!isResponsive(1024)){
							jQuery("#claim-listing").waypoint(function(){
								jQuery("#claim-listing").addClass('load-finished');
							}, { triggerOnce: true, offset: "95%" });
						} else {
							jQuery("#claim-listing").addClass('load-finished');
						}

					<?php } else { ?>
						jQuery("#claim-listing").addClass('load-finished');
					<?php } ?>
				});
				</script>
				<?php
				}
			} 
		} else {
			// check if default package item count is not 0
			$defaultPackage = $themePackages->getPackageBySlug($claimListingOptions['defaultPackage']);
			$defaultPackageOptions = $defaultPackage->getOptions();
			if(intval($defaultPackageOptions['maxItems']) == 0){
				// cannot claim item because package cannot have items
				?>
				<div id="claim-listing" class="claim-listing-container">
		
				<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']) != ""){	?>
					<h2><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']); ?></h2>
				<?php } ?>
				
				<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']) != ""){	?>
					<p><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']); ?></p>
				<?php } ?>
					
					<div class="content">

						<div class="ait-sc-notification attention">
							<div class="notify-wrap">
								<h5><?php _e("Default package doesn't allow items to be claimed", 'ait-claim-listing'); ?></h5>
							</div>
						</div>

					</div>
				</div>

				<script id="claim-listing-script">
				jQuery(window).load(function(){
					<?php
						$generalOptions = $themeOptions->general;
						if($generalOptions['progressivePageLoading']){ ?>
						
						if(!isResponsive(1024)){
							jQuery("#claim-listing").waypoint(function(){
								jQuery("#claim-listing").addClass('load-finished');
							}, { triggerOnce: true, offset: "95%" });
						} else {
							jQuery("#claim-listing").addClass('load-finished');
						}

					<?php } else { ?>
						jQuery("#claim-listing").addClass('load-finished');
					<?php } ?>
				});
				</script>
				<?php
			} else {
				?>
				<div id="claim-listing" class="claim-listing-container">
			
				<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']) != ""){	?>
					<h2><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']); ?></h2>
				<?php } ?>
				
				<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']) != ""){	?>
					<p><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']); ?></p>
				<?php } ?>
					
					<div class="content">

						<a href="#claim-listing-form" id="claim-listing-button" class="resources-button ait-sc-button route-button"><?php _e('Claim Listing', 'ait-claim-listing'); ?></a>
						<div class="claim-listing-fancybox" style="display: none">
							<div id="claim-listing-form" class="claim-listing-form">
								<form method="post" action="<?php echo home_url('/').'?ait-action=register'; ?>" class="wp-user-form user-claim-form" onsubmit="javascript: submitClaimListing(event);">
									<?php $rand = rand(); ?>
									<h3><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']); ?></h3>
									<input type="hidden" name="claim_listing" value="true">
									<input type="hidden" name="rand" value="<?php echo $rand; ?>">
									<input type="hidden" name="user_role" value="<?php echo $claimListingOptions['defaultPackage']; ?>" />
									<input type="hidden" name="form_post" value="<?php echo $post->ID ?>" />

									<div class="input-wrap input-email">
										<input type="text" name="user_email" id="claim-email" required class="input-field" placeholder="<?php echo AitLangs::getCurrentLocaleText($claimListingOptions['formLabelEmail']); ?>" />
									</div>
									<div class="input-wrap input-username">
										<input type="text" name="user_login" id="claim-username" required class="input-field" placeholder="<?php echo AitLangs::getCurrentLocaleText($claimListingOptions['formLabelUsername']); ?>" />
									</div>

									<!-- PAYMENT GATES -->
									<?php if(count($paymentGatesEnabled) > 0){
										// $slug = !empty($claimListingOptions['defaultPackage']) ? $claimListingOptions['defaultPackage'] : 'cityguide_free';
										$defaultPackage = $themePackages->getPackageBySlug($claimListingOptions['defaultPackage']);
										$defaultPackageOptions = $defaultPackage->getOptions();
										if ($defaultPackageOptions['price'] != 0){ ?>
										<div class="input-wrap input-payment">
											<label for="form_payment"><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['formLabelPayment']); ?></label>
											<select id="claim-payment" name="user_payment" required>
											<?php foreach($paymentGatesEnabled as $name => $value) { ?>
												<option value="<?php echo $name; ?>"><?php echo $paymentGatesConfig[$name]['label'] ?></option>
											<?php } ?>
											</select>
										</div>
										<?php
										}
									}
									?>
									<!-- PAYMENT GATES -->

									<!-- CAPTCHA -->
									<div class="input-wrap input-captcha">
										<label for="form_captcha"><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['formLabelCaptcha']); ?></label>
										<?php
										if(!class_exists("ReallySimpleCaptcha")){
											@include plugin_dir_path( __FILE__ ).'../captcha/really-simple-captcha.php';
										}
										$captcha = new ReallySimpleCaptcha();

										$imgUrl = "";
										if(class_exists("AitTheme")){
											$captcha->tmp_dir = aitPaths()->dir->cache . '/captcha';
											$cacheUrl = aitPaths()->url->cache . '/captcha';
										} else {
											$captcha->tmp_dir = plugin_dir_path( __FILE__ ) . '../captcha/cache';
											$captcha->fonts = array(
												plugin_dir_path( __FILE__ ) . '../design/font/gentium/GenBkBasR.ttf',
												plugin_dir_path( __FILE__ ) . '../design/font/gentium/GenBkBasI.ttf',
												plugin_dir_path( __FILE__ ) . '../design/font/gentium/GenBkBasBI.ttf',
												plugin_dir_path( __FILE__ ) . '../design/font/gentium/GenBkBasB.ttf'
											);
											$cacheUrl = plugin_dir_url( __FILE__ ) . '../captcha/cache';
										}
										$img = $captcha->generate_image('ait-claim-listing-captcha-'.$rand, $captcha->generate_random_word());
										$imgUrl = $cacheUrl."/".$img;
										?>

										<img src="<?php echo $imgUrl; ?>" alt="captcha">
										<input type="text" name="form_captcha" required>
									</div>
									<!-- CAPTCHA -->

									<!-- TERMS & CONDITIONS -->
									<?php if($claimListingOptions['termsAndConditionsEnable']){ ?>
										<div class="input-wrap input-terms">
											<label for="form_terms"><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['termsAndConditionsLabel']); ?></label>
											<input type="checkbox" name="form_terms" value="true" required>	
										</div>
									<?php }	?>
									<!-- TERMS & CONDITIONS -->

									<div class="input-wrap input-submit">
										<input type="submit" name="form_submit" value="<?php echo AitLangs::getCurrentLocaleText($claimListingOptions['formLabelSubmit']); ?>">
									</div>

									<div class="claim-notices-container">
										<div class="claim-notice form-error-general" style="display: none">
											<?php _e('Server encountered an error, please try again later','ait-claim-listing')?>
										</div>
										<div class="claim-notice form-error-captcha" style="display: none">
											<?php _e('Captcha failed to verify','ait-claim-listing')?>
										</div>							
									</div>
								</form>						
							</div>
						</div>

					</div>
				</div>

				<script id="claim-listing-script">
				jQuery(window).load(function(){
					<?php
						$generalOptions = $themeOptions->general;
						if($generalOptions['progressivePageLoading']){ ?>
						
						if(!isResponsive(1024)){
							jQuery("#claim-listing").waypoint(function(){
								jQuery("#claim-listing").addClass('load-finished');
							}, { triggerOnce: true, offset: "95%" });
						} else {
							jQuery("#claim-listing").addClass('load-finished');
						}

					<?php } else { ?>
						jQuery("#claim-listing").addClass('load-finished');
					<?php } ?>
				});
				</script>
			<?php
			}
		}
	} elseif (is_array($claimData) && $claimData['status'] === 'pending') {
		if($claimListingOptions['frontendNotification2Enable'] == "on" || $claimListingOptions['frontendNotification2Enable'] == "1"){
		?>
		<div id="claim-listing" class="claim-listing-container">
		
		<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']) != ""){	?>
			<h2><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']); ?></h2>
		<?php } ?>
		
		<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']) != ""){	?>
			<p><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']); ?></p>
		<?php } ?>
			
			<div class="content">
				
				<div class="ait-sc-notification attention">
					<div class="notify-wrap">
						<h5><?php _e('Item pending moderation from admin', 'ait-claim-listing'); ?></h5>
					</div>
				</div>

			</div>
		</div>

		<script id="claim-listing-script">
		jQuery(window).load(function(){
			<?php
				$generalOptions = $themeOptions->general;
				if($generalOptions['progressivePageLoading']){ ?>
				
				if(!isResponsive(1024)){
					jQuery("#claim-listing").waypoint(function(){
						jQuery("#claim-listing").addClass('load-finished');
					}, { triggerOnce: true, offset: "95%" });
				} else {
					jQuery("#claim-listing").addClass('load-finished');
				}

			<?php } else { ?>
				jQuery("#claim-listing").addClass('load-finished');
			<?php } ?>
		});
		</script>
		<?php
		}
	} else {
		if($claimListingOptions['frontendNotification1Enable'] == "on" || $claimListingOptions['frontendNotification1Enable'] == "1"){
		?>
		<div id="claim-listing" class="claim-listing-container">
		
		<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']) != ""){	?>
			<h2><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionTitle']); ?></h2>
		<?php } ?>
		
		<?php if(AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']) != ""){	?>
			<p><?php echo AitLangs::getCurrentLocaleText($claimListingOptions['sectionDescription']); ?></p>
		<?php } ?>
			
			<div class="content">

				<div class="ait-sc-notification attention">
					<div class="notify-wrap">
						<h5><?php _e('Item already claimed', 'ait-claim-listing'); ?></h5>
					</div>
				</div>

			</div>
		</div>

		<script id="claim-listing-script">
		jQuery(window).load(function(){
			<?php
				$generalOptions = $themeOptions->general;
				if($generalOptions['progressivePageLoading']){ ?>
				
				if(!isResponsive(1024)){
					jQuery("#claim-listing").waypoint(function(){
						jQuery("#claim-listing").addClass('load-finished');
					}, { triggerOnce: true, offset: "95%" });
				} else {
					jQuery("#claim-listing").addClass('load-finished');
				}

			<?php } else { ?>
				jQuery("#claim-listing").addClass('load-finished');
			<?php } ?>
		});
		</script>
		<?php
		}
	}
}
?>