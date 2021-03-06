<?php
if ( ! defined('DOCROOT'))
{
	exit('No direct script access allowed');
}
?>

<?php $data_array = json_decode($data); ?>

<h4><?= __('Board') ?>:</h4>
<table class="table table-hover">
	<thead>
		<tr>
			<th class="span6"><?= __('Poster') ?></th>
			<th class="span2"><?= __('Last Seen') ?></th>
			<th class="span2"><?= __('Latest Post') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data_array->board as $d) : ?>
		<tr>
			<td>
				<?php
				$params = [\Radix::getSelected()->shortname, 'search'];
				if ($d->name)
				{
					array_push($params, 'username/' . urlencode($d->name));
				}
				if ($d->trip)
				{
					array_push($params, 'tripcode/' . urlencode($d->trip));
				}
				$poster_link = \Uri::create($params);
				?>
				<a href="<?= $poster_link ?>">
					<span class="poster_name"><?php echo $d->name ?></span> <span class="poster_trip"><?php echo $d->trip ?></span>
				</a>
			</td>
			<td><?= date('D M d H:i:s Y', $d->timestamp) ?></td>
			<td>
				<a href="<?= \Uri::create([\Radix::getSelected()->shortname, 'post', $d->num . ($d->subnum ? '_' . $d->subnum : '')]) ?>">
					&gt;&gt;<?= $d->num . ($d->subnum ? ',' . $d->subnum : '') ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if (count($data_array->ghost)) : ?>
<h4><?= __('Ghost') ?>:</h4>
<table class="table table-hover">
	<thead>
		<tr>
			<th class="span6"><?= __('Poster') ?></th>
			<th class="span2"><?= __('Last Seen') ?></th>
			<th class="span2"><?= __('Latest Post') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data_array->ghost as $d) : ?>
		<tr>
			<td>
				<?php
				$params = [\Radix::getSelected()->shortname, 'search'];
				if ($d->name)
				{
					array_push($params, 'username/' . urlencode($d->name));
				}
				if ($d->trip)
				{
					array_push($params, 'tripcode/' . urlencode($d->trip));
				}
				$poster_link = \Uri::create($params);
				?>
				<a href="<?= $poster_link ?>">
					<span class="poster_name"><?php echo $d->name ?></span> <span class="poster_trip"><?php echo $d->trip ?></span>
				</a>
			</td>
			<td><?= date('D M d H:i:s Y', $d->timestamp) ?></td>
			<td>
				<a href="<?= \Uri::create([\Radix::getSelected()->shortname, 'post', $d->num . ($d->subnum ? '_' . $d->subnum : '')]) ?>">
					&gt;&gt;<?= $d->num . ($d->subnum ? ',' . $d->subnum : '') ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>