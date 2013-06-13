<?php
/**
* ownCloud - Cloudpress
*
* @author Bastien Ho (EELV - Urbancube)
* @copyleft 2012 bastienho@urbancube.fr
* @projeturl http://ecolosites.eelv.fr
*
* Free Software under creative commons licence
* http://creativecommons.org/licenses/by-nc/3.0/
* Attribution-NonCommercial 3.0 Unported (CC BY-NC 3.0)
* 
* You are free:
* to Share — to copy, distribute and transmit the work
* to Remix — to adapt the work
*
* Under the following conditions:
* Attribution — You must attribute the work in the manner specified by the author or licensor (but not in any way that
* suggests  that they endorse you or your use of the work).
* Noncommercial — You may not use this work for commercial purposes.
*
*/

// fill template
$tmpl = new OC_Template('user_wordpress', 'persopress');
$uid=OC_User::getUser();
$wp_instance = new OC_wordpress();
foreach($wp_instance->params as $param=>$value){
  $tmpl->assign($param, $value);
}
$blogs = $wp_instance->getUserBlogs($uid);
$tmpl->assign('uid',$uid);
$tmpl->assign('blogs',$blogs);
return $tmpl->fetchPage();
