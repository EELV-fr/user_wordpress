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

class OC_user_wordpress extends OC_User_Backend {
  protected $wordpress_db_host;
  protected $wordpress_db_name;
  protected $wordpress_db_user;
  protected $wordpress_db_password;
  protected $wordpress_db_prefix;
  protected $wordpress_hash_salt;
  protected $db;
  protected $db_conn;
  protected $wp_all_users;

  function __construct() {
    $this->connectdb();
  }
  /**
   * @brief Set email address
   * @param $uid The username
   */
  public function connectdb() {
   $this->db_conn = false;
    $this->wordpress_db_host = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_host','');
    $this->wordpress_db_name = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_name','');
    $this->wordpress_db_user = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_user','');
    $this->wordpress_db_password = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_password','');
    $this->wordpress_db_prefix = OC_Appconfig::getValue('user_wordpress', 'wordpress_db_prefix','');
    $this->wordpress_hash_salt = OC_Appconfig::getValue('user_wordpress', 'wordpress_hash_salt','');
    $this->wordpress_have_to_be_logged = OC_Appconfig::getValue('user_wordpress', 'wordpress_have_to_be_logged','');
    $this->wordpress_global_group = OC_Appconfig::getValue('user_wordpress', 'wordpress_global_group','');

    if(empty($this->wordpress_db_host)) $this->wordpress_db_host=OC_Config::getValue( "dbhost", "" );
    if(empty($this->wordpress_db_name)) $this->wordpress_db_name=OC_Config::getValue( "dbname", "owncloud" );
    if(empty($this->wordpress_db_user)) $this->wordpress_db_user=OC_Config::getValue( "dbuser", "" );
    if(empty($this->wordpress_db_password)) $this->wordpress_db_password=OC_Config::getValue( "dbpassword", "" );
    if(empty($this->wordpress_have_to_be_logged)){
		 $this->wordpress_have_to_be_logged='0';
		 OC_Appconfig::setValue('user_wordpress', 'wordpress_have_to_be_logged', '0');
	}
    $this->wp_all_users=array();
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
    //$this->wordpress_db_prefix = $this->db->real_escape_string($this->wordpress_db_prefix);
  }
  
  private function setEmail($uid) {
    if (!$this->db_conn) {
      $this->connectdb();
    }
    if (!$this->db_conn) {
      return false;
    }

    $q = 'SELECT user_email FROM '. $this->wordpress_db_prefix .'users WHERE user_login = "'. str_replace('"','""',$uid) .'" AND user_status = 0';
    $result = mysql_query($q);
    if ($result && mysql_num_rows($result)>0) {
      $email = mysql_fetch_assoc($result);
      $email = $email['user_email'];
      OC_Preferences::setValue($uid, 'settings', 'email', $email);
    }
  }
  
  
  /* Check if the password is correct */
  public function checkPassword($uid, $password){
    if (!$this->db_conn) {
      $this->connectdb();
    }
    if (!$this->db_conn) {
      return false;
    }
    $query = 'SELECT user_login,user_pass FROM '. $this->wordpress_db_prefix .'users WHERE user_login = "' . str_replace('"','""',$uid) . '"';
    $query .= ' AND user_status = 0';
    $result = mysql_query($query);
    if ($result && mysql_num_rows($result)>0) {
      $row = mysql_fetch_assoc($result);
      $hash = $row['user_pass'];

    require_once('apps/user_wordpress/class-phpass.php');
    $wp_hasher = new PasswordHash(8, TRUE);
    $check = $wp_hasher->CheckPassword($password, $hash);
    
      if ($check==true) {
		  if($this->wordpress_global_group!=''){
			 if(!OC_Group::groupExists($this->wordpress_global_group)){
				  OC_Group::createGroup($this->wordpress_global_group);
			  }					
			  
			  if( OC_Group::inGroup( $uid, $this->wordpress_global_group )){
				  // Do nothing					
			  }
			  else{
				  OC_Group::addToGroup( $uid, $this->wordpress_global_group );
			  }
		 }
        $this->setEmail($uid);
        return $row['user_login'];
      }
    }
    return false;
  }
  
  public function log_with_hash($uid,$hash){
    if (!$this->db_conn) {
      $this->connectdb();
    }
    if (!$this->db_conn) {
      return false;
    }
    $query = 'SELECT user_pass FROM '. $this->wordpress_db_prefix .'users WHERE user_login = "' . str_replace('"','""',$uid) . '"AND user_status = 0';
    $result = mysql_query($query);
    if ($result && mysql_num_rows($result)>0) {
		$ro=mysql_fetch_array($result);
		if($hash==sha1($ro[0])){
		  //sSome line from lib/user.php
		  $enabled = OC_User::isEnabled($uid);
		  if($uid && $enabled) {
			  //session_regenerate_id(true);
			  OC_User::setUserId($uid);
			  //OC_Hook::emit( "OC_User", "post_login", array( "uid" => $uid, 'password'=>$password ));
			  return true;
		  }
	  }
    }
    return false;
  }
  
  public function getAllWpUsers(){
	if (!$this->db_conn) {
      $this->connectdb();
    }
    $users = array();
    if (!$this->db_conn) {
      return;
    }
	$CONFIG_DATADIRECTORY = OC_Config::getValue( "datadirectory", OC::$SERVERROOT."/data" );
	$q = 'SELECT user_login FROM '. $this->wordpress_db_prefix .'users WHERE user_status = 0 ORDER BY `user_login` '; 
    $result = mysql_query($q);
    if ($result && mysql_num_rows($result)>0) {
		$i=0;
      while ($row = mysql_fetch_assoc($result)){
        if(!empty($row['user_login']) ) {
			if($this->wordpress_have_to_be_logged=='0'){ 
				$this->wp_all_users[] = $row['user_login'];
			}
			elseif(is_dir($CONFIG_DATADIRECTORY.'/'.$row['user_login'])){
				$this->wp_all_users[] = $row['user_login'];
			}
			else{
				// who goe's to hunt loose his place	
			}
		}
	  }
	  $this->wp_all_users=array_unique($this->wp_all_users);	  
      sort($this->wp_all_users);
	}
  }

  /*  a list of all users from wordpress DB */
  public function getUsers($search = '', $limit = NULL, $offset = NULL) {	  
	$users=array();
	$start=0;
	$fin=sizeof($this->wp_all_users);
		
	if($fin==0){
		$this->getAllWpUsers();
		$fin=sizeof($this->wp_all_users);
	}
	if($fin==0){
		return $users;
	}
	$nb_users=$fin;
	if($search==''){
		if($offset!=NULL) $start=$offset;
		if($limit!=NULL) $fin=$start+$limit; 
	}
	
	if($fin>$nb_users) $fin=$nb_users;
	  //echo $limit.'/'.$offset.'*';
	for($i=$start ; $i<$fin ; $i++){
		if($search=='' || strpos($this->wp_all_users[$i],$search)>-1){
			$users[] = $this->wp_all_users[$i];
		}
    }
    return $users;
  }
  
  
  
  /* check if a user exists */
  public function userExists($uid) {
    if (!$this->db_conn) {
      $this->connectdb();
    }
    if (!$this->db_conn) {
      return false;
    }
    $q = 'SELECT user_login FROM '. $this->wordpress_db_prefix .'users WHERE user_login = "'. str_replace('"','""',$uid) .'"  AND user_status = 0';
    $result = mysql_query($q);
    if ($result && mysql_num_rows($result)>0) {
      return true;
    }
    return false;
  }
}
