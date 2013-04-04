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

class OC_wordpress {
  

  function OC_wordpress() {
    $this->connectdb();
  }
  
  public function connectdb() {
    $this->db_conn = false;
    $this->wordpress_db_host = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_host','');
    $this->wordpress_db_name = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_name','');
    $this->wordpress_db_user = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_user','');
    $this->wordpress_db_password = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_password','');
    $this->wordpress_db_prefix = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_prefix','');
    $this->wordpress_hash_salt = OC_Appconfig::getValue('user_wordpress', 'wordpress_hash_salt','');
    $this->wordpress_global_group = OC_Appconfig::getValue('user_wordpress', 'wordpress_global_group','');

    if(empty($this->wordpress_db_host)) $this->wordpress_db_host=OC_Config::getValue( "dbhost", "" );
    if(empty($this->wordpress_db_name)) $this->wordpress_db_name=OC_Config::getValue( "dbname", "owncloud" );
    if(empty($this->wordpress_db_user)) $this->wordpress_db_user=OC_Config::getValue( "dbuser", "" );
    if(empty($this->wordpress_db_password)) $this->wordpress_db_password=OC_Config::getValue( "dbpassword", "" );
    
    $errorlevel = error_reporting();
    error_reporting($errorlevel & ~E_WARNING);
    $this->db = mysql_connect($this->wordpress_db_host, $this->wordpress_db_user, $this->wordpress_db_password);
    if(!$this->db){
      OC_Log::write('OC_user_wordpress',
          'OC_user_wordpress, Failed to connect to wordpress host database: ' . mysql_error($this->db),
          OC_Log::ERROR);
      return false;
    }
    mysql_select_db($this->wordpress_db_name,$this->db);
    if(!$this->db){
      OC_Log::write('OC_user_wordpress',
          'OC_user_wordpress, Failed to connect to wordpress database: ' . mysql_error($this->db),
          OC_Log::ERROR);
      return false;
    }
   $this->db_conn = true;
  }
  
   
  
  /* retreives wordpress user ID from login name */
  public function getUserId($uid) {
    if (!$this->db_conn) {
      $this->connectdb();
    }
    if (!$this->db_conn) {
      return false;
    }
    $q = 'SELECT ID FROM '. $this->wordpress_db_prefix .'users WHERE user_status = 0 AND user_login=\''.$uid.'\'';
    $result = mysql_query($q);
    if ($result && mysql_num_rows($result)>0) {
      $row = mysql_fetch_array($result);
      return $row[0];     
    }
    return false;
  }
  
  
  
  /* retrieves user sites list */
  public function getUserblogs($uid) {
    if (!$this->db_conn) {
      $this->connectdb();
    }
    $blogs = array();
    if (!$this->db_conn) {
      return $blogs;
    }
   if(false !== $user_ID = $this->getUserId($uid)){
	   
      
     $q = 'SELECT meta_key FROM '. $this->wordpress_db_prefix .'usermeta WHERE user_id = \''.$user_ID.'\' AND `meta_key`LIKE\'%capabilities\' AND (`meta_value`LIKE\'%keymaster%\' OR `meta_value`LIKE\'%administrator%\' OR `meta_value`LIKE\'%editor%\' OR `meta_value`LIKE\'%author%\')';
     $result = mysql_query($q);
     if ($result && mysql_num_rows($result)>0) {
       while ($row = mysql_fetch_assoc($result)){
         if(!empty($row['meta_key'])) {
           $blog_id = str_replace(array($this->wordpress_db_prefix,'capabilities','_'),'',$row['meta_key']);
		   if($blog_id==''){
			   $blog_id=1;
		   }
           if(is_numeric($blog_id)){
           $res = mysql_query('SELECT * FROM '. $this->wordpress_db_prefix .'blogs WHERE blog_id = \''.$blog_id.'\' AND `deleted`=0 AND `spam`=0');
           if ($res && mysql_num_rows($res)>0) {
             $blog = mysql_fetch_assoc($res);
             $blogs[] = $blog;
			 $group=$blog['domain'];
			 if(!is_numeric($group)){
				if(!OC_Group::groupExists($group)){
					OC_Group::createGroup($group);
				}					
				
				if( OC_Group::inGroup( $uid, $group )){
					// Do nothing					
				}
				else{
					OC_Group::addToGroup( $uid, $group );
				} 
			 }
           }
           }
         }
       }       
     }
    }
    return $blogs;
  }

}
