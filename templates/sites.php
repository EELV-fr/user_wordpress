<?php if(!isset($_GET['url'])): ?>
<div id="controls">
  <h1><a href="<?=OC::$CLASSPATH['OC_wordpress_site_list']?>"><?php echo $l->t('my sites') ?></a></h1>
</div>
<div id='sitelistpage'>
<table>
  <thead>
    <tr>
      <th id='headerName'><?php echo $l->t('Name') ?></th>
      <th id="headeradmin"><?php echo $l->t('Visit') ?></th>
      <th id="headeradmin"><?php echo $l->t('Creation') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($_['blogs'] as $blog) : ?>
      <tr data-file="link" data-type="site">
        <td class="filename svg">
          <a class="name" href="<?=OC::$CLASSPATH['OC_wordpress_site_list']?>&url=<?=$blog['domain']?>/wp-admin" title="<?=$blog['domain']?>"><?=$blog['domain']?></a>
        </td>
       <td>
         <a class="name" href="<?=OC::$CLASSPATH['OC_wordpress_site_list']?>&url=<?=$blog['domain']?>" title="admin"><?php echo $l->t('Visit') ?></a>
        </td>
       <td>
         <?=relative_modified_date($blog['registered'])?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
  </div>
<?php else: $url=$_GET['url']; ?>
  <div id='sitepage'>
  <iframe  id = "ifm"  src="http://<?=$url?>"></iframe>
</div>
  <script type='text/javascript'>
function pageY(elem) {
    return elem.offsetParent ? (elem.offsetTop + pageY(elem.offsetParent)) : elem.offsetTop;
}
var buffer = 10; //scroll bar buffer
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
