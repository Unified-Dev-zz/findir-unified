<?php $menu = mbb_get_builder_menu(); ?>

<div class="builder-gui nav-menus-php" ng-app="Builder">

	<div id="nav-menus-frame" ng-controller="BuilderController" ng-init="init()">

		<div id="menu-settings-column" class="metabox-holder">
			<div id="side-sortables" class="accordion-container">
				<ul class="outer-border">
					<?php foreach ( $menu as $block => $fields ):
						$open = ( $block === 'Text' ) ? 'open' : '';
						?>
						<li class="control-section accordion-section <?php echo $open ?>">
							<h3 class="accordion-section-title hndle" tabindex="0"><?php echo $block ?></h3>
							<span class="screen-reader-text"><?php _e( 'Press return or enter to expand', 'meta-box-builder' ); ?></span>

							<div class="accordion-section-content">
								<div class="inside">
									<?php
									$i = 1;
									foreach ( $fields as $key => $value ): $i ++; ?>
										<button type="button" class="button-secondary" ng-click="addField('<?php echo $key ?>');"><?php echo $value ?></button>
										<?php
										if ( $i % 2 )
											echo '<p></p>';
									endforeach; ?>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div id="menu-management-liquid">
			<div id="menu-management">
				<div class="menu-edit">
					<div id="nav-menu-header">
						<div class="major-publishing-actions">
							<label class="menu-name-label howto open-label" for="menu-name"><?php _e( 'Meta Box Title', 'meta-box-builder' ); ?></label>
							<input name="post_title" ng-model="meta.title" id="menu-name" type="text" class="menu-name regular-text menu-item-textbox" placeholder="<?php _e( 'Enter name here', 'meta-box-builder' ); ?>">
							<div class="publishing-action">
								<input type="submit" id="bind_submit" name="save_metabox" class="button button-primary menu-save" value="<?php _e( 'Save Meta Box', 'meta-box-builder' ); ?>">
							</div><!-- END .publishing-action -->
						</div><!-- END .major-publishing-actions -->
					</div>

					<div id="post-body">
						<div id="post-body-content">

							<h3><?php _e( 'Meta Box Fields', 'meta-box-builder' ); ?></h3>
							<p ng-show="meta.fields.length == 0">
								<?php _e( 'Add meta box fields from the column on the left.', 'meta-box-builder' ); ?>
							</p>
							<p ng-show="meta.fields.length > 0">
								<?php _e( 'Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.', 'meta-box-builder' ); ?>
							</p>

							<tg-dynamic-directive ng-model="meta" tg-dynamic-directive-view="getView"></tg-dynamic-directive>

							<script type="text/ng-template" id="nestable_item.html">
								<section ng-if="ngModelItem.type">
									<dl class="menu-item-bar {{ngModelItem.type}}">
										<dt class="menu-item-handle">
											<span class="item-title">
												<span class="menu-item-title" ng-show="ngModelItem.type != 'tab'">{{ngModelItem.name}}</span>
												<span class="menu-item-title" ng-show="ngModelItem.type == 'tab'">
													<i class="wp-menu-image dashicons-before {{ngModelItem.icon}}"></i> {{ngModelItem.label}}
												</span>
											</span>
											<span class="item-controls">
												<span class="item-type">{{ngModelItem.type}}</span>
												<a class="item-edit" ng-click="toggleEdit(ngModelItem, $event)"><?php _e( 'Edit', 'meta-box-builder' ); ?></a>
											</span>
										</dt>
									</dl>

									<div class="menu-item-settings" ng-show="ngModelItem==active">
										<div class="field-edit-content" ng-include src="ngModelItem.type + '.edit.html'" role="tabpanel"></div>
										<div class="menu-item-actions description-wide submitbox">
											<a href="#" role="button" class="submitdelete item-delete deletion" ng-click="removeField($index)"><?php _e( 'Remove', 'meta-box-builder' ); ?></a>
											<span class="meta-sep hide-if-no-js"> | </span>
											<a href="#" role="button" class="submitcancel item-cancel" ng-click="unEdit($event)"><?php _e( 'Cancel', 'meta-box-builder' ); ?></a>
											<a ng-show="ngModelItem.type != 'tab' && ngModelItem.type != 'group'" href="#" role="button" class="submitduplicate item-cancel" ng-click="cloneField(ngModelItem)"><?php _e( 'Duplicate', 'meta-box-builder' ); ?></a>
										</div>
									</div>
								</section>

								<ul class="apps-container menu ui-sortable" ui-sortable="sortableOptions" ng-model="ngModelItem.fields">
									<li class="menu-item builder-field {{field.type}} {{field.id==active.id}}" ng-repeat="field in ngModelItem.fields track by field.id+$index">
										<tg-dynamic-directive ng-model="field" tg-dynamic-directive-view="getView">
										</tg-dynamic-directive>
									</li>
								</ul>
							</script>

							<div class="menu-settings">
								<h3><?php _e( 'Meta Box Settings', 'meta-box-builder' ); ?></h3>
								<dl class="priority">
									<dt class="howto"><?php _e( 'Priority', 'meta-box-builder' ); ?></dt>
									<dd>
										<ul class="builder-grid">
											<li class="builder-col">
												<label>
													<input type="radio" ng-model="meta.priority" name="priority" value="high"> <?php _e( 'High', 'meta-box-builder' ); ?>
												</label>
											</li>
											<li class="builder-col">
												<label>
													<input type="radio" ng-model="meta.priority" name="priority" value="low"> <?php _e( 'Low', 'meta-box-builder' ); ?>
												</label>
											</li>
										</ul>
									</dd>
								</dl>

								<dl class="context">
									<dt class="howto"><?php _e( 'Context', 'meta-box-builder' ); ?></dt>
									<dd>
										<ul class="builder-grid">
											<li class="builder-col">
												<label>
													<input type="radio" ng-model="meta.context" name="context" value="normal"> <?php _e( 'Normal', 'meta-box-builder' ); ?>
												</label>
											</li>
											<li class="builder-col">
												<label>
													<input type="radio" ng-model="meta.context" name="context" value="advanced"> <?php _e( 'Advanced', 'meta-box-builder' ); ?>
												</label>
											</li>
											<li class="builder-col">
												<label>
													<input type="radio" ng-model="meta.context" name="context" value="side"> <?php _e( 'Side', 'meta-box-builder' ); ?>
												</label>
											</li>
										</ul>
									</dd>
								</dl>

								<dl>
									<dt class="howto"><?php _e( 'Post types', 'meta-box-builder' ); ?></dt>
									<dd>
										<select id="select-post-types" multiple="multiple" ng-model="meta.pages" ng-options="post_type as post_type for post_type in post_types"></select>
									</dd>
								</dl>

								<dl>
									<dt class="howto">
										<label for="metabox-auto-save"><?php _e( 'Autosave', 'meta-box-builder' ); ?></label>
									</dt>
									<dd>
										<input id="metabox-auto-save" ng-true-value="'true'" ng-false-value="'false'" type="checkbox" ng-model="meta.autosave" />
									</dd>
								</dl>

								<dl ng-show="tabExists">
									<dt class="howto">
										<label for="meta-box-tabs-style"><?php _e( 'Tabs Style', 'meta-box-builder' ); ?></label>
									</dt>
									<dd>
										<select ng-model="meta.tab_style">
											<option value="default">default</option>
											<option value="box">box</option>
											<option value="left">left</option>
										</select>
									</dd>

									<dt class="howto">
										<label for="meta-box-tabs-wrapper"><?php _e( 'Tabs Wrapper', 'meta-box-builder' ); ?></label>
									</dt>
									<dd>
										<input id="meta-box-tabs-wrapper" type="checkbox" ng-model="meta.tab_wrapper" ng-true-value="'true'" ng-false-value="'false'" />
									</dd>
								</dl>

								<div class="meta-box-sortables">
									<div class="postbox closed">
										<div class="handlediv" title="Click to toggle"><br></div>
										<h3 class="hndle ui-sortable-handle">Custom Attributes</h3>
										<div class="inside">
											<section>
												<table class="table" style="max-width: 690px" ng-show="meta.attrs.length > 0">
													<thead>
													<tr>
														<td>Key</td>
														<td>Value</td>
														<td></td>
													</tr>
													</thead>
													<tbody>
													<tr ng-repeat="attr in meta.attrs track by $index">
														<td class="col-xs-5" width="45%">
															<input ng-keydown="navigate($event, active.id, $index, 'key')" ng-enter="addMetaBoxAttribute()" focus-on="metabox_key_{{$index}}" type="text" class="form-control col-sm-6 input-sm" ng-model="attr.key" placeholder="Enter key" />
														</td>

														<td class="col-xs-6" width="45%">
															<textarea style="width: 100%" type="text" class="form-control col-sm-6 input-sm" ng-model="attr.value" placeholder="Enter value"></textarea>
														</td>

														<td class="col-xs-1" width="5%">
															<button type="button" class="button" ng-click="removeMetaBoxAttribute($index);">
																<span class="dashicons dashicons-trash"></span></button>
														</td>
													</tr>
													</tbody>
												</table>
												<button type="button" class="button" ng-click="addMetaBoxAttribute();">Add Custom Attribute</button>
											</section>
										</div><!--.inside-->
									</div><!--.postbox-->
								</div><!--.meta-box-sortables-->


								<div class="meta-box-sortables">
									<div class="postbox closed">
										<div class="handlediv" title="Click to toggle"><br></div>
										<h3 class="hndle ui-sortable-handle">Conditional Logic</h3>
										<div class="inside">
											<section class="builder-conditional-logic" ng-show="meta.logic">
												<label>This conditional logic applies for current Meta Box, for fields conditional logic, please go to each field and set.</label><br>
												<select ng-model="meta.logic.visibility">
													<option value="visible">Visible</option>
													<option value="hidden">Hidden</option>
												</select>

												<code>when</code>

												<select ng-model="meta.logic.relation">
													<option value="and">All</option>
													<option value="or">Any</option>
													<select>

														<code>of these conditions match</code>

														<table class="table" style="max-width: 690px">
															<tr>
																<td>Field</td>
																<td>Is</td>
																<td>Value</td>
																<td></td>
															</tr>
															<tr ng-repeat="item in meta.logic.when track by $index">
																<td width="35%">
																	<input type="text" ng-model="meta.logic.when[$index][0]" list="available_fields" placeholder="Select or enter a field...">
																</td>
																<td width="15%">
																	<select ng-model="meta.logic.when[$index][1]">
																		<option value="=">=</option>
																		<option value=">">></option>
																		<option value="<">&lt;</option>
																		<option value=">=">>=</option>
																		<option value="<=">&lt;=</option>
																		<option value="!=">!=</option>
																		<option value="contains">contains</option>
																		<option value="not contains">not contains</option>
																		<option value="starts with">starts with</option>
																		<option value="not starts with">not starts with</option>
																		<option value="ends with">ends with</option>
																		<option value="not ends with">not ends with</option>
																		<option value="between">between</option>
																		<option value="not between">not between</option>
																		<option value="in">in</option>
																		<option value="not in">not in</option>
																		<option value="match">match</option>
																		<option value="not match">not match</option>
																	</select>
																</td>
																<td width="35%">
																	<input type="text" ng-model="meta.logic.when[$index][2]" placeholder="Enter a value...">
																</td>
																<td width="5%">
																	<button type="button" class="button" ng-click="removeConditionalLogic($index, 'meta');">
																		<span class="dashicons dashicons-trash"></span>
																	</button>
																</td>
															</tr>
														</table>
											</section>
											<button type="button" class="button" ng-click="addConditionalLogic('meta');">Add Conditional Logic</button>
										</div>
									</div><!--.postbox-->
								</div><!--.meta-box-sortables-->

								<?php Meta_Box_Show_Hide_Template::show(); ?>
								<?php Meta_Box_Include_Exclude_Template::show(); ?>

							</div><!--.menu-settings-->
						</div><!--#post-body-content-->
					</div><!--#post-body-->

					<div id="nav-menu-footer">
						<div class="major-publishing-actions">
              <span class="delete-action">
                <a class="submitdelete deletion menu-delete" href="<?php echo get_delete_post_link(); ?> "><?php _e( 'Delete Meta Box', 'meta-box-builder' ); ?></a>
              </span><!-- END .delete-action -->
							<div class="publishing-action">
								<input type="submit" id="bind_submit" name="save_metabox" class="button button-primary menu-save" value="<?php _e( 'Save Meta Box', 'meta-box-builder' ); ?>">
							</div><!-- END .publishing-action -->
						</div><!-- END .major-publishing-actions -->
					</div><!--#nav-menu-footer-->

				</div>
			</div>
		</div>

		<?php
		// Generate script content for each template
		foreach ( $menu as $block => $fields ):
			foreach ( $fields as $k => $v ) : ?>

				<script type="text/ng-template" id="<?php echo $k ?>.edit.html">
					<?php mbb_get_field_edit_content( $k ); ?>
				</script>

			<?php endforeach; endforeach; ?>

		<datalist id="available_fields">
			<option ng-repeat="field in available_fields track by $index" value="{{field}}">
		</datalist>
		<input type="hidden" name="excerpt" value="{{meta}}" />
	</div><!-- Builder Controller all code should here-->

</div><!--.builder-gui-->
