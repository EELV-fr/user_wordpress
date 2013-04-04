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
$params = array(
    'wordpress_db_host',
    'wordpress_db_user',
    'wordpress_db_password',
    'wordpress_db_name',
    'wordpress_db_prefix',
  'wordpress_hash_salt',
  'wordpress_have_to_be_logged',
  'wordpress_global_group'
);

if ($_POST) {
  foreach($params as $param){
    if(isset($_POST[$param])){
      OC_Appconfig::setValue('user_wordpress', $param, $_POST[$param]);
    }
  }
}

// fill template
$tmpl = new OC_Template('user_wordpress', 'settings');
foreach($params as $param){
  $value = OC_Appconfig::getValue('user_wordpress', $param,'');
  $tmpl->assign($param, $value);
}

return $tmpl->fetchPage();
