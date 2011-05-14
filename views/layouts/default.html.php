<?php
/**
 * Lithium Mongo: Interactive MongoDB browser built on the Lithium framework.
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use \lithium\net\http\Router;

$urls = array(
	'index' => Router::match(array('controller' => 'collections'), $this->request()),
	'edit' => Router::match(
		array('controller' => 'collections', 'action' => 'edit', 'id' => ':col', 'args' => ':args'),
		$this->request()
	),
);

?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title>MongoViewer &gt; <?= $this->title(); ?></title>
	<?=$this->html->style(array('base', 'detail', 'jquery.treeview')); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
	<?=$this->html->script(array('jquery', 'app')); ?>
	<script type="text/javascript">
		urls = <?php echo json_encode($urls); ?>;
	</script>
</head>
<body class="app">
	<div id="container">
		<div id="header">
			MongoDB viewer, powered by <?php echo $this->html->link('Lithium', 'http://lithify.me/'); ?>
		</div>
		<div id="layout">
			<?php echo $this->content(); ?>
		</div>
		<div id="footer">
			<div class="button-bar">
				<button id="AddCollection" title="Add collection"></button>
				<button id="RefreshCollections" title="Refresh collections"></button>
				<button id="SelectDatabase" title="Select database"></button>
			</div>
			<span class="status"></span>
		</div>
	</div>
</body>
</html>