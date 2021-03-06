<div class="col-md-12">
	<div class="title">
		<h2><?=__d('admin', 'Search advertisements')?></h2>
	</div>
	<?=$this->AdminForm->create(false, array('class' => 'form-horizontal'))?>
		<div class="form-group searchform col-sm-3">
			<label><?=__d('admin', 'Advertiser')?></label>
			<?=
				$this->AdminForm->input('Filter.LoginAd.advertiser_name', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'title' => __d('admin', 'Enter username to search'),
					'default' => isset($this->request->params['named']['LoginAd.advertiser_name']) ? $this->request->params['named']['LoginAd.advertiser_name'] : '',
				))
			?>
		</div>
		<div class="form-group searchform col-sm-3">
			<label><?=__d('admin', 'Advertisement Title')?></label>
			<?=
				$this->AdminForm->input('Filter.LoginAd.title', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'title' => __d('admin', 'Enter advertisement title to search'),
					'default' => isset($this->request->params['named']['LoginAd.title']) ? $this->request->params['named']['LoginAd.title'] : '',
				))
			?>
		</div>
		<div class="form-group searchform col-sm-3">
			<label><?=__d('admin', 'URL')?></label>
			<?=
				$this->AdminForm->input('Filter.LoginAd.url', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'title' => __d('admin', 'Enter URL to search'),
					'default' => isset($this->request->params['named']['LoginAd.url']) ? $this->request->params['named']['LoginAd.url'] : '',
				))
			?>
		</div>
		<div class="form-group searchform col-sm-3">
			<label><?=__d('admin', 'Status')?></label>
				<?=
					$this->AdminForm->input('Filter.LoginAd.status', array(
						'options' => $statuses,
						'empty' => __d('admin', 'All'),
					))
				?>
		</div>
		<div class="col-sm-12 text-center">
			<button class="btn btn-primary btn-sm"><?=__d('admin', 'Search')?></button>
		</div>
	<?=$this->AdminForm->end()?>
	<div class="clearfix"></div>
	<div class="title">
		<h2><?=__d('admin', 'Login ads advertisements')?></h2>
	</div>
	<?=
		$this->AdminForm->create(false, array(
			'url' => array('action' => 'massaction'),
		))
	?>
		<div class="table-horizontal">
			<table class="table table-striped table-hover">
				<tbody>
					<tr>
						<th><input type="checkbox" onclick="setAllCheckboxes('ActionCheckbox', this.checked);"></th>
						<th><?=$this->Paginator->sort('advertiser_name', __d('admin', 'Advertiser'))?></th>
						<th><?=$this->Paginator->sort('title')?></th>
						<th><?=$this->Paginator->sort('url')?></th>
						<th><?=$this->Paginator->sort('total_clicks')?></th>
						<th><?=$this->Paginator->sort('expiry')?></th>
						<th><?=$this->Paginator->sort('status')?></th>
						<th><?=__d('admin', 'Actions')?></th>
					</tr>
					<?php foreach($ads as $ad): ?>
						<tr>
							<td>
								<?=
									$this->AdminForm->checkbox('LoginAd.'.$ad['LoginAd']['id'], array(
										'class' => 'ActionCheckbox',
									))
								?>
							</td>
							<td>
								<?php if($ad['LoginAd']['advertiser_id']): ?>
									<?=$this->Html->link($ad['Advertiser']['username'], array('controller' => 'users', 'action' => 'edit', $ad['LoginAd']['advertiser_id']))?>
								<?php else: ?>
									<?=h($ad['LoginAd']['advertiser_name'])?>
								<?php endif; ?>
							</td>
							<td><?=h($ad['LoginAd']['title'])?></td>
							<td><?=$this->Html->link($ad['LoginAd']['url'])?></td>
							<td><?=h($ad['LoginAd']['total_clicks'])?></td>
							<td>
								<?php if($ad['LoginAd']['package_type'] == 'Days'): ?>
									<?=$this->Time->nice(strtotime("{$ad['LoginAd']['start']} + {$ad['LoginAd']['expiry']} day"))?>
								<?php elseif(empty($ad['LoginAd']['package_type'])): ?>
									<?=__d('admin', 'Not assigned')?>
								<?php else: ?>
									<?=__d('admin', '%d %s', $ad['LoginAd']['expiry'] - $ad['LoginAd'][lcfirst($ad['LoginAd']['package_type'])], lcfirst($ad['LoginAd']['package_type']))?>
								<?php endif; ?>
							</td>
							<td><?=__d('admin', $ad['LoginAd']['status'])?></td>
							<td>
								<?=
									$this->Html->link('<i class="fa fa-pencil fa-lg" data-toggle="tooltip" data-placement="top" title="'.__d('admin', 'Edit advertisement').'"></i>', array('action' => 'edit',  $ad['LoginAd']['id']), array('escape' => false))
								?>
								<?=
									$this->AdminForm->postLink(
										'<i class="fa fa-minus-square fa-lg" data-toggle="tooltip" data-placement="top" title="'.__d('admin', 'Inactivate advertisement').'"></i>',
										array('action' => 'inactivate', $ad['LoginAd']['id']), 
										array('escape' => false), 
										__d('admin', 'Are you sure you want to inactivate "%s"?', $ad['LoginAd']['title'])
									);
								?>
								<?=
									$this->AdminForm->postLink(
										'<i class="fa fa-check-square fa-lg" data-toggle="tooltip" data-placement="top" title="'.__d('admin', 'Activate advertisement').'"></i>',
										array('action' => 'activate', $ad['LoginAd']['id']), 
										array('escape' => false), 
										__d('admin', 'Are you sure you want to activate "%s"?', $ad['LoginAd']['title'])
									);
								?>
								<?=
									$this->AdminForm->postLink(
										'<i class="fa fa-trash fa-lg" data-toggle="tooltip" data-placement="top" title="'.__d('admin', 'Delete advertisement').'"></i>',
										array('action' => 'delete', $ad['LoginAd']['id']), 
										array('escape' => false), 
										__d('admin', 'Are you sure you want to delete "%s"?', $ad['LoginAd']['title'])
									);
								?>
							</td>
						</tr>
						<tr>
							<td colspan="10" class="text-center">
								<?=
									$this->Html->image($ad['LoginAd']['image_url'], array(
										'title' => $ad['LoginAd']['title'],
										'alt' => $ad['LoginAd']['title'],
										'width' => $bannerSize['width'],
										'height' => $bannerSize['height'],
										'target' => 'blank',
									))
								?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-5 text-left">
			<div class="input-group">
				<label for="selectMassAction" class="input-group-addon"><?=__d('admin', 'Mass Action')?></label>
				<?=
					$this->AdminForm->input('Action', array(
						'empty' => __d('admin', '--Choose--'),
						'required' => true,
						'id'=> 'selectMassAction',
						'options' => array(
							'activate' => __d('admin', 'Activate advertisements'),
							'inactivate' => __d('admin', 'Inactivate advertisements'),
							'delete' => __d('admin', 'Delete advertisements'),
						)
					))
				?>
				<div class="input-group-btn">
					<button class="btn btn-danger"><?=__d('admin', 'Perform Action')?></button>
				</div>
			</div>
		</div>
	<?=$this->AdminForm->end()?>
	<div class="col-sm-7 text-right">
		<?=
			$this->Paginator->counter(array(
				'format' => __d('admin', 'Page {:page} of {:pages}')
			))
		?>
	</div>
	<div class="col-sm-12 text-center paddingten">
		<nav>
			<ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->first('&laquo;', array('tag' => 'li', 'escape' => false));
					echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a'));
					echo $this->Paginator->last('&raquo;', array('tag' => 'li', 'escape' => false));
				?>
			</ul>
		</nav>
	</div>
	<div class="col-sm-12 text-center paddingten">
		<?=
			$this->Html->link(__d('admin', 'Add New Advertisement'), array('action' => 'add'), array(
				'class' => 'btn btn-primary',
			))
		?>
	</div>
</div>
