<?php if(!isset($_GET['url'])): ?>
<div id="controls">
	<h1><a href="<?=OC::$CLASSPATH['OC_wordpress_site_list'] ?>"><?php echo $l->t('my sites') ?></a></h1>
</div>
<div id='sitelistpage'>
<table>
<<<<<<< HEAD
	<thead>
		<tr>
			<th id='headerName'><?php echo $l->t('Name') ?></th>
			<th id="headeradmin"><?php echo $l->t('Visit') ?></th>
			<th id="headeradmin"><?php echo $l->t('Creation') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if(sizeof($_['blogs'])>0): ?>
		<?php foreach($_['blogs'] as $blog) : ?>
		<tr data-file="link" data-type="site">
			<td class="filename svg">
				<a class="name" href="<?=OC::$CLASSPATH['OC_wordpress_site_list'] ?>?url=<?=$blog['domain'] ?>/wp-admin" title="<?=$blog['domain'] ?>"><?=$blog['domain'] ?></a>
				<a class="name" href="<?=$blog['domain'] ?>/wp-admin/" title="<?php echo $l->t('Open it in a new window') ?>" target="_blank">+</a>
			</td>
			<td>
				<a class="name" href="<?=OC::$CLASSPATH['OC_wordpress_site_list'] ?>?url=<?=$blog['domain'] ?>" title="admin"><?php echo $l->t('Visit') ?></a>
				<a class="name" href="<?=$blog['domain'] ?>" title="<?php echo $l->t('Open it in a new window') ?>" target="_blank">+</a>
			</td>
			<td>
				<?=relative_modified_date($blog['registered']) ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php else: ?>
		<tr><td colspan="3">
			<?php echo $l->t('You have no site registered, please check your') ?>
			<a class="name" href="<?=OC::$CLASSPATH['OC_wordpress_site_list'] ?>?url=<?php echo $_['wordpress_url']; ?>/wp-admin/my-sites.php" title="admin"><?php echo $l->t('Site list on WordPress') ?></a>
			<a class="name" href="<?php echo $_['wordpress_url']; ?>/wp-admin/my-sites.php" title="<?php echo $l->t('Open it in a new window') ?>" target="_blank">+</a>
		</td></tr>
		<?php endif; ?>
	</tbody>
</table>
=======
  <thead>
    <tr>
      <th id='headerName'><?php echo $l->t('Name') ?></th>
      <th id="headeradmin"><?php echo $l->t('Visit') ?></th>
      <th id="headeradmin"><?php echo $l->t('Creation') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php if(sizeof($_['blogs'])>0): ?>
    <?php foreach($_['blogs'] as $blog) : ?>
      <tr data-file="link" data-type="site">
        <td class="filename svg">
          <a class="name" href="<?=OC::$CLASSPATH['OC_wordpress_site_list']?>?url=<?=$blog['domain']?>/wp-admin" title="<?=$blog['domain']?>"><?=$blog['domain']?></a>
          <a class="name" href="<?=$blog['domain']?>/wp-admin/" title="<?php echo $l->t('Open it in a new window') ?>" target="_blank">+</a>
        </td>
       <td>
         <a class="name" href="<?=OC::$CLASSPATH['OC_wordpress_site_list']?>?url=<?=$blog['domain']?>" title="admin"><?php echo $l->t('Visit') ?></a>
         <a class="name" href="<?=$blog['domain']?>" title="<?php echo $l->t('Open it in a new window') ?>" target="_blank">+</a>
        </td>
       <td>
         <?=relative_modified_date($blog['registered'])?>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php else: ?>
    	<tr><td colspan="3">
    	<?php echo $l->t('You have no site registered, please check your') ?>
    	 <a class="name" href="<?=OC::$CLASSPATH['OC_wordpress_site_list']?>?url=<?php echo $_['wordpress_url']; ?>/wp-admin/my-sites.php" title="admin"><?php echo $l->t('Site list on WordPress') ?></a>
    	 <a class="name" href="<?php echo $_['wordpress_url']; ?>/wp-admin/my-sites.php" title="<?php echo $l->t('Open it in a new window') ?>" target="_blank">+</a>
    	 </td></tr>
    <?php endif; ?>
  </tbody>
</table>
  </div>
<?php else: 
	$url=$_GET['url']; 
	if(strpos($url,'://')<0) $url='http://'.$url;
	?>
  <div id='sitepage'>
  <iframe  id = "ifm"  src="<?=$url?>"></iframe>
>>>>>>> debug
</div>
<?php else:
	$url=$_GET['url'];
	if(!strpos($url,'://')) $url='http://'.$url;
?>
<div id='sitepage'>
<iframe id = "ifm" src="<?=$url ?>"></iframe>
</div>
<script type='text/javascript'>
	function pageY(elem) {
		return elem.offsetParent ? (elem.offsetTop + pageY(elem.offsetParent)) : elem.offsetTop;
	}

	var buffer = 10;
	//scroll bar buffer
	function resizeIframe() {
		var height = document.documentElement.clientHeight;
		height -= pageY(document.getElementById('ifm')) + buffer;
		height = (height < 0) ? 0 : height;
		document.getElementById('ifm').style.height = height + 'px';
		//setTimeout('resizeIframe()',1000);
	}


	document.getElementById('ifm').onload = resizeIframe;
	window.onresize = resizeIframe; 
</script>
<?php endif; ?>
