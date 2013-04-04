<?php  
$uid=OC_User::getUser();
$wp_instance = new OC_wordpress();
$blogs = $wp_instance->getUserBlogs($uid);
echo json_encode ($blogs);
?>