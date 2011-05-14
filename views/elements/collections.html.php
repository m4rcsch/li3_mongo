<ul>
	<li class="title">Collections</li>
	<?php foreach ($collections as $collection) { ?>
		<li class="collection">
			<?=$this->html->link($collection, array(
				'controller' => 'collections', 'action' => 'view', 'id' => $collection
			)); ?>
		</li>
	<?php } ?>
</ul>
