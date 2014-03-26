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


// Check if we are a user
OCP\User::checkLoggedIn();
OCP\App::checkAppEnabled('user_wordpress');
OCP\App::setActiveNavigationEntry( 'wordpress_sites' );
  
  

$uid=OC_User::getUser();
$wp_instance = new OC_wordpress();
$blogs = $wp_instance->getUserBlogs($uid);
$tmpl = new OCP\Template( 'user_wordpress', 'sites', 'user' );
foreach($wp_instance->params as $param=>$value){
  $tmpl->assign($param, $value);
}
$tmpl->assign('uid',$uid);
$tmpl->assign('blogs', $blogs );
$tmpl->printPage();
