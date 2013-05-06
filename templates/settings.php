<form id="wordpress" action="#wordpress" method="post">
	<input type="hidden" name="wordpress_settings_post" value="1"/>
    <fieldset class="personalblock">
        <strong>Wordpress</strong><br/>
        
        <?php echo $l->t('Database') ?>
        <blockquote>
	        <em><?php echo $l->t('(leave empty if same as Owncloud)') ?></em>
	        <p>
	            <label for="wordpress_db_host"><?php echo $l->t('DB Host');?></label>
	            <input type="text" id="wordpress_db_host" name="wordpress_db_host" value="<?php echo $_['wordpress_db_host']; ?>" />
	
	            <label for="wordpress_db_name"><?php echo $l->t('DB Name');?></label>
	            <input type="text" id="wordpress_db_name" name="wordpress_db_name" value="<?php echo $_['wordpress_db_name']; ?>" />
	          
	            <label for="wordpress_db_user"><?php echo $l->t('DB User');?></label>
	            <input type="text" id="wordpress_db_user" name="wordpress_db_user"  autocomplete="off" value="<?php echo $_['wordpress_db_user']; ?>" />
	
	            <label for="wordpress_db_password"><?php echo $l->t('DB Password');?></label>
	            <input type="password" id="wordpress_db_password" name="wordpress_db_password" autocomplete="off" value="<?php echo $_['wordpress_db_password']; ?>" />            
	        </p>
			<p><?php echo $l->t('Required fields for wordpress');?></p>
	      <label for="wordpress_db_prefix"><?php echo $l->t('DB Prefix');?></label>
	            <input type="text" id="wordpress_db_prefix" name="wordpress_db_prefix" value="<?php echo $_['wordpress_db_prefix']; ?>" />
	        
	            <!--label for="wordpress_db_user"><?php echo $l->t('Hash Salt');?></label-->
	            <input type="hidden" id="wordpress_hash_salt" name="wordpress_hash_salt" value="<?php echo $_['wordpress_hash_salt']; ?>" />
	        </p>
        </blockquote>
        <hr/>
        <p><?php echo $l->t('Custom settings');?></p>
        <blockquote>
        	<p>
	      		<label for="wordpress_have_to_be_logged"><?php echo $l->t('Users have to be logged-in on the cloud to be visible');?>
	            <input type="radio" id="wordpress_have_to_be_logged" name="wordpress_have_to_be_logged" value="1" <?php if($_['wordpress_have_to_be_logged']=='1'){ echo'checked'; } ?> />
	            </label>
	                
	                <label for="wordpress_have_to_be_logged"><?php echo $l->t('All users are visible');?>
	            <input type="radio" id="wordpress_have_to_be_logged" name="wordpress_have_to_be_logged" value="0" <?php if($_['wordpress_have_to_be_logged']=='0'){ echo'checked'; } ?> />
	            </label>
	        </p>
	        <p>       
	      		<label for="wordpress_add_button"><?php echo $l->t('Add a "sites" button to main menu');?>
	            <input type="checkbox" id="wordpress_add_button" name="wordpress_add_button" value="1" <?php if($_['wordpress_add_button']=='1') echo 'checked'; ?> />
	            </label>
	        </p>
	     </blockquote> 
	     <blockquote> 
	     	<hr/> 
	        <p><?php echo $l->t('Groups');?></p>
	        <p>
	      		<label for="wordpress_global_group"><?php echo $l->t('Create a group for all WordPress users');?>
	            <input type="text" id="wordpress_global_group" name="wordpress_global_group" value="<?php echo $_['wordpress_global_group']; ?>" /></label>
	         </p>
	         <p>       
	      		<label for="wordpress_global_group"><?php echo $l->t('Restrict users to their WordPress groups');?>
	            <input type="checkbox" id="wordpress_restrict_group" name="wordpress_restrict_group" value="1" <?php if($_['wordpress_restrict_group']=='1') echo 'checked'; ?> />
	            </label>
	                <em><?php echo $l->t('(excepting global group)');?></em>
	        </p>
		</blockquote>
        <input type="submit" value="<?php echo $l->t('Save');?>" />
    </fieldset>
</form>
<?php ?>
