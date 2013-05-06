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

class OC_group_wordpress extends OC_Group_Backend {
	static $wordpress_db_host;
	static $wordpress_db_name;
	static $wordpress_db_user;
	static $wordpress_db_password;
	static $wordpress_db_prefix;
	static $wordpress_hash_salt;
	static $db;
	static $db_conn;
	static $wp_all_users;
	static $wp_instance;
	static $current_user_blogs;


  function __construct() {
	self::$wp_instance = new OC_wordpress();
    self::$db_conn=self::$wp_instance->connectdb();
	$uid=OC_User::getUser();
	if($uid){		
		self::$current_user_blogs = self::$wp_instance->getUserblogsIds($uid);
	}
  }

  public function connectdb() {
  	self::$db_conn = self::$wp_instance->connectdb();
  }


	public function inGroup($uid, $gid) {
		return in_array($gid, self::getUserGroups($uid));
	}
  
  public function getUserGroups($uid) {
  	if (!self::$db_conn)
	  return array();

	  return self::$wp_instance->getUserblogs($uid,true);
  }
  
  	public function getGroups($search = '', $limit = -1, $offset = 0) {
  		if (!self::$db_conn)
	  		return array();
		return self::$wp_instance->getAllBlogs(isset($_GET['search'])?$_GET['search']:'', $limit, $offset);
	}
	public function groupExists($gid) {
		return in_array($gid, self::getGroups($gid, 1));
	}
	public function usersInGroup($gid, $search = '', $limit = -1, $offset = 0) {
		return array();
	}
}

/*
 $cp_groups=new OC_group_wordpress();
    
	foreach($blogids as $blog_id){
     if(is_numeric($blog_id)){
           $res = mysql_query('SELECT * FROM '. self::wordpress_db_prefix .'blogs WHERE blog_id = \''.$blog_id.'\' AND `deleted`=0 AND `spam`=0');
           if ($res && mysql_num_rows($res)>0) {
             $blog = mysql_fetch_assoc($res);
             $blogs[] = $blog;
			 $group=$blog['domain'];
			 if(!is_numeric($group)){
				if(!$cp_groups->groupExists($group)){
					$cp_groups->createGroup($group);
				}					
				
				if( $cp_groups->inGroup( $uid, $group )){
					// Do nothing					
				}
				else{
					$cp_groups->addToGroup( $uid, $group );
				} 
			 }
           }
      }
    }*/

