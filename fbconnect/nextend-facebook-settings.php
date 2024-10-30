<?php
$newfb_status = "normal";

if(isset($_POST['newfb_update_options'])) {
	if($_POST['newfb_update_options'] == 'Y') {
    foreach($_POST AS $k => $v){
      $_POST[$k] = stripslashes($v);
    }
		update_option("nextend_fb_connect", maybe_serialize($_POST));
		$newfb_status = 'update_success';
	}
}

if(!class_exists('NextendFBSettings')) {
class NextendFBSettings {
function NextendFB_Options_Page() {
  $domain = get_option('siteurl');
  $domain = str_replace(array('http://', 'https://'), array('',''), $domain);
  $domain = str_replace('www.', '', $domain);
  $a = explode("/",$domain);
  $domain = $a[0]; 
	?>

	<div class="wrap">
	<div id="newfb-options">
	<div id="newfb-title"><h2>Facebook Connect Settings</h2></div>
	<?php
	global $newfb_status;
	if($newfb_status == 'update_success')
		$message =__('Configuration updated', 'nextend-facebook-connect') . "<br />";
	else if($newfb_status == 'update_failed')
		$message =__('Error while saving options', 'nextend-facebook-connect') . "<br />";
	else
		$message = '';

	if($message != "") {
	?>
		<div class="updated"><strong><p><?php
		echo $message;
		?></p></strong></div><?php
	} ?>
  
  <?php
  if (!function_exists('curl_init')) {
  ?>
    <div class="error"><strong><p>Facebook needs the CURL PHP extension. Contact your server adminsitrator!</p></strong></div>
  <?php
  }else{
    $version = curl_version();
    $ssl_supported= ($version['features'] & CURL_VERSION_SSL);
    if(!$ssl_supported){
    ?>
      <div class="error"><strong><p>Protocol https not supported or disabled in libcurl. Contact your server adminsitrator!</p></strong></div>
    <?php
    }
  }
  if (!function_exists('json_decode')) {
    ?>
      <div class="error"><strong><p>Facebook needs the JSON PHP extension. Contact your server adminsitrator!</p></strong></div>
    <?php
  }
  ?>
  
	

	
	

	<!--left-->
	<div class="postbox-container" style="float:left;width: 100%;">
	<div class="metabox-holder">
	<div class="meta-box-sortabless">

	<!--setting-->
	<div id="newfb-setting" class="postbox">
	<h3 class="hndle"  style="background: -moz-linear-gradient(center top , #3D3D3D, #212121) repeat scroll 0 0 rgba(0, 0, 0, 0); background:-webkit-linear-gradient(top, #3D3D3D, #212121);  color: #FFFFFF;    cursor: pointer;    text-transform: uppercase;"><?php _e('Settings', 'nextend-facebook-connect'); ?></h3>
	<?php $nextend_fb_connect = maybe_unserialize(get_option('nextend_fb_connect')); ?>
    <div style="padding:10px;"> 
	<form method="post" action="<?php echo get_bloginfo("wpurl"); ?>/wp-admin/options-general.php?page=nextend-facebook-connect">
	<input type="hidden" name="newfb_update_options" value="Y">

	<table class="form-table">
		<tr>
		<th scope="row"><?php _e('Facebook App ID:', 'nextend-facebook-connect'); ?></th>
		<td>
		<input type="text" name="fb_appid" value="<?php echo $nextend_fb_connect['fb_appid']; ?>" style="width:89%"/>
		</td>
		</tr>  
      
		<tr>
		<th scope="row"><?php _e('Facebook App Secret:', 'nextend-facebook-connect'); ?></th>
		<td>
		<input type="text" name="fb_secret" value="<?php echo $nextend_fb_connect['fb_secret']; ?>" style="width:89%"/>
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('New user prefix:', 'nextend-facebook-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_fb_connect['fb_user_prefix'])) $nextend_fb_connect['fb_user_prefix'] = 'Facebook - '; ?>
		<input type="text" name="fb_user_prefix" value="<?php echo $nextend_fb_connect['fb_user_prefix']; ?>" style="width:89%"/>
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Fixed redirect url for login:', 'nextend-facebook-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_fb_connect['fb_redirect'])) $nextend_fb_connect['fb_redirect'] = 'auto'; ?>
		<input type="text" name="fb_redirect" value="<?php echo get_bloginfo('url');//$nextend_fb_connect['fb_redirect']; ?>" style="width:89%" />
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Fixed redirect url for register:', 'nextend-facebook-connect'); ?></th>
		<td>
    <?php if(!isset($nextend_fb_connect['fb_redirect_reg'])) $nextend_fb_connect['fb_redirect_reg'] = 'auto'; ?>
		<input type="text" name="fb_redirect_reg" value="<?php echo get_bloginfo('url');// $nextend_fb_connect['fb_redirect_reg']; ?>" style="width:89%"/>
		</td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Load button stylesheet:', 'nextend-facebook-connect'); ?></th>
		<td>
      <?php if(!isset($nextend_fb_connect['fb_load_style'])) $nextend_fb_connect['fb_load_style'] = 1; ?>
		<input name="fb_load_style" id="fb_load_style_yes" value="1" type="radio" <?php if(isset($nextend_fb_connect['fb_load_style']) && $nextend_fb_connect['fb_load_style']){?> checked <?php } ?>> Yes  &nbsp;&nbsp;&nbsp;&nbsp;
    <input name="fb_load_style" id="fb_load_style_no" value="0" type="radio" <?php if(isset($nextend_fb_connect['fb_load_style']) && $nextend_fb_connect['fb_load_style'] == 0){?> checked <?php } ?>> No		
		</td>
		</tr>
    
    <tr>
		<th scope="row"><?php _e('Login button:', 'nextend-facebook-connect'); ?></th>
		<td>
      <?php if(!isset($nextend_fb_connect['fb_login_button'])) $nextend_fb_connect['fb_login_button'] = '<div class="new-fb-btn new-fb-1 new-fb-default-anim"><div class="new-fb-1-1"><div class="new-fb-1-1-1">CONNECT WITH</div></div></div>'; ?>
		  <textarea cols="83" rows="3" name="fb_login_button"><?php echo $nextend_fb_connect['fb_login_button']; ?></textarea>
		</td>
		</tr>
    
  
    
   
   
	</table>

	<p class="submit">
	<input style="margin-left: 10%;" type="submit" name="Submit" value="<?php _e('Save Changes', 'nextend-facebook-connect'); ?>" />
	</p>
	</form>
	</div>
	</div>
	<!--setting end-->

	<!--others-->
	<!--others end-->

	</div></div></div>
	<!--left end-->

	</div>
	</div>
	<?php
}

function NextendFB_Menu() {
	add_options_page(__('VB - FB Connect'), __('VB - FB Connect'), 'manage_options', 'nextend-facebook-connect', array(__CLASS__,'NextendFB_Options_Page'));
}

}
}
?>
