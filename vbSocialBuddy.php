<?php
/*
Plugin Name: BP Social Network
Plugin URI: http://vbsocial.com/buddypress-social-network/
Description: Designed for BuddyPress, Dropdowns for Friend Requests, Private Messaging, and Global Notifications similar to Facebook.
Version: 9.2
Author: vBSocial.com
Author URI: http://vbsocial.com
*/
define("BP_ACTIVITY_NOTIFIER_SLUG","ac_notification");
add_action('wp_head', 'vb_buddy_add_head_css');
add_action('wp_head', 'vb_buddy_add_head_script');
add_action('wp_footer', 'vb_buddy_add_footer_html');
add_action( 'admin_head', 'vb_buddy_admin_scripts' );
add_action( 'admin_menu', 'vb_buddy_admin_menus' );
add_action( 'bp_setup_globals', 'SetupGlobals' );
add_action("bp_activity_comment_posted","NotifierNotify",10,2);
add_action("bp_activity_screen_single_activity_permalink","RemoveNotification",10,2);
add_action("bp_activity_deleted_activities","ClearNotificationOnDelete");
add_action('bp_init',array($this,'DeleteFromGroupForums'),20);


include "fbconnect/nextend-facebook-connect.php";
include "fbconnect/nextend-facebook-settings.php"; 

include "inc/vb_buddy_ajax_functions.php";
include "inc/vb_functions.php";




add_shortcode('TotalAwards', 'GetTotalRewards');  
add_shortcode('AllNotifications', 'GetAllNotifications');  
add_shortcode('vb_buddy_award_list', 'vb_buddy_award_list_callback'); 



function OnLoadAwards()
{
GetReward(BP_Friends_Friendship::total_friend_count( $bp->loggedin_user->id ),"Friends");
GetReward(getTotalSentMessageThreads( bp_loggedin_user_id()),"Messages");
GetReward(getTotalComments( bp_loggedin_user_id(),'activity_comment'),"Comments");
GetReward(getTotalComments( bp_loggedin_user_id(),'activity_update'),"Posts"); 
}


 function vb_buddy_award_list_callback()
{
    include "inc/vb_buddy_award_list_page.php";
} 

function vb_buddy_admin_menus(){
    add_menu_page( 'vBSocial BuddyPress Network', 'BP Social Network', 'manage_options', 'vb_buddy_settings', 'vb_buddy_settings_callback',plugins_url('images/logo_small.png',__FILE__));
    add_submenu_page( 'vb_buddy_settings', 'Awards Settings', 'Awards Settings', 'manage_options', 'vb_buddy_awards_settings', 'vb_buddy_awards_settings_callback');
}

function vb_buddy_settings_callback()
{
    include "inc/admin/vb_buddy_settings.php";
}

function vb_buddy_awards_settings_callback()
{
    include "inc/admin/vb_buddy_awards_settings.php";
}

function vb_buddy_friend_list() {
include "inc/vb_buddy_display_friends.php";
}
function vb_buddy_messages_list() {
include "inc/vb_buddy_display_messages.php";
}

function vb_buddy_admin_scripts()
{
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_style('jQuery_UI', plugins_url('css/vb_buddy_admin.css', __FILE__));
    wp_enqueue_style('vb_buddy_admin', plugins_url('css/jquery-ui.css', __FILE__));
    ?>
        <script>
            jQuery(function(){
                var index = 'key';
                //  Define friendly data store name
                var dataStore = window.sessionStorage;
                //  Start magic!
                try {
                    // getter: Fetch previous value
                    var oldIndex = dataStore.getItem(index);
                } catch(e) {
                    // getter: Always default to first tab in error state
                    var oldIndex = 0;
                }
               jQuery('#tabs').tabs({
                    // The zero-based index of the panel that is active (open)
                    active : oldIndex,
                    // Triggered after a tab has been activated
                    activate : function( event, ui ){
                        //  Get future value
                        var newIndex = ui.newTab.parent().children().index(ui.newTab);
                        //  Set future value
                        dataStore.setItem( index, newIndex ) 
                    }
                }); 
            });
        </script>
    <?php
}
function vb_buddy_add_head_css() {
wp_enqueue_style('vb_buddy_main_css', plugins_url('css/vb_buddy_main_css.css', __FILE__));
wp_enqueue_style('vb_buddy_font_css', plugins_url('css/font-awesome.min.css', __FILE__));
wp_enqueue_style('jQuery_UI', plugins_url('css/jquery-ui.css', __FILE__));
}
function vb_buddy_add_head_script() {
?>
<script>
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>
<?php
wp_enqueue_script('vb_buddy_main_script', plugins_url('js/vb_buddy_script.js', __FILE__));
wp_enqueue_script('vb_buddy_main_script', plugins_url('js/jquery.easing.compatibility.js', __FILE__));
wp_enqueue_script('jquery-ui-dialog');
wp_enqueue_script('jquery-ui-tabs'); 
}
function vb_buddy_notification_list() {
include "inc/vb_buddy_display_notifications.php";
}
function vb_buddy_add_footer_html() {
    
    $isModeration = get_option('vb_buddy_isModeration');
    $isFriends = get_option('vb_buddy_isFriends');
    $isMessages = get_option('vb_buddy_isMessages');
    $isGeneral = get_option('vb_buddy_isGeneral');
?>
<div class="vb_buddy_floating_strip">
<a href="<?php echo get_bloginfo('url'); ?>"><img class="vb_buddy_logo" src="<?php echo plugins_url('images/logo.png', __FILE__) ?>" /></a>
<?php if (is_user_logged_in()) { ?>
<ul class="vb_buddy_action_icons">
<?php if($isModeration == 'on') { ?>
<li id="vb_opener_moderation"><i class="icon-flag"></i></li>
<?php } ?>
<?php if($isFriends == 'on') { ?>
<li id="vb_opener_friends"><i class="icon-coffee"></i>
<?php if (bp_friend_get_total_requests_count() != 0) { ?>
<span class="jewelCount">
<span class="notificationValue" id="livenotifications_num_pm">
<?php echo bp_friend_get_total_requests_count(); ?></span>
</span>
<?php } ?>
</li>
<?php } ?>
<?php if($isMessages == 'on') { ?>
<li id="vb_opener_messages"><i class="icon-comments"></i>
<?php if (messages_get_unread_count() != 0) { ?>
<span class="jewelCount">
<span class="notificationValue" id="livenotifications_num_pm"><?php echo messages_get_unread_count(); ?></span>
</span>
<?php } ?>
</li>
<?php } ?>
<?php if($isGeneral == 'on') { ?>
<li id="vb_opener_notification"><i class="icon-bell"></i>
<?php 
OnLoadAwards();
$Current_User = wp_get_current_user();
$Current_User->ID;
$AwardNotification = getUnreadAwardCount($Current_User->ID);
$BPNotifications= getUnreadBPNotificationCount();
$NewNotifications = $BPNotifications + $AwardNotification;


if ($NewNotifications > 0) 
{

?>
<span class="jewelCount">
<span class="notificationValue" id="livenotifications_num_notifications"><?php echo $NewNotifications; ?></span>
</span>
<?php 

} ?>
</li>
<?php } ?>
</ul>
<div class="vb_open vb_open_messages">
<?php vb_buddy_messages_list(); ?>
</div>
<div class="vb_open vb_open_friends">
<?php vb_buddy_friend_list(); ?>
</div>
<div class="vb_open vb_open_notifications">
<?php vb_buddy_notification_list(); ?>
</div>
<?php } ?>
<ul class="vb_buddy_welcome_icons">
<?php 
$isPoints = get_option('vb_buddy_is_points');
if($isPoints == 'on')
{
if(is_user_logged_in())
{
    
    $awardPageUrl = get_option('vb_buddy_awards_url');
    ?>
	<li class="vb_buddy_total_points"><a href="<?php echo $awardPageUrl; ?>" style="color:#FFF;"><?php echo GetTotalPoints($Current_User->ID)?> Points</a></li>
<?php } }?>
<li id="vb_opener_login" class="vb_buddy_user_image">
<?php
if (is_user_logged_in()) {
$current_user = wp_get_current_user();
echo bp_core_fetch_avatar(array(
'item_id' => get_current_user_id(),
'type' => 'full',
'width' => auto,
'height' => 20
));
?>
<span style="text-align:center"><?php echo $current_user->display_name; ?></span>
<?php } else { ?>
<i class="icon-user"></i>
<span style="text-align:center">Log in</span>
<?php } ?>
</li>
<li id="vb_buddy_like_box_opener"><i class="icon-thumbs-up"></i></li>
<li><a href="https://www.facebook.com/pages/vBSocialcom/176817612373656" target="_blank"><i class="icon-facebook"></i></a></li>
<li><a href="<?php bloginfo('rss_url'); ?>"><i class="icon-rss"></i></a></li>
<li class="vb_buddy_search_box">
    <?php get_search_form(); ?>
</li>
<?php $ddlScrollArrow = get_option('vb_buddy_scroll_arrow'); ?>
<li class="vb_buddy_scroll_up"><i class="icon-<?php if($ddlScrollArrow != ''){echo $ddlScrollArrow;} else {echo 'double-angle-up';}?>"></i></li>
</ul>
<div class="vb_open vb_buddy_like_box_open">
<div class="vb_inner_open">
    <?php
        $facebookLikeStyle = get_option('vb_buddy_facebook_like_style');
        $twitterLikeStyle = get_option('vb_buddy_twitter_like_style');
        $googleLikeStyle = get_option('vb_buddy_google_like_style');
        
        $facebookLike = get_option('vb_buddy_facebook_like');
        $twitterLike = get_option('vb_buddy_twitter_like');
        $googleLike = get_option('vb_buddy_google_like');
        
    ?>
    <ul class="vb_social_container">
        <?php if($facebookLike == 'on') { ?>
        <li><iframe src="//www.facebook.com/plugins/like.php?href=<?php echo get_bloginfo('url');?>&amp;width&amp;layout=<?php echo $facebookLikeStyle ; ?>&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=65&amp;appId=188673897822536" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:65px;" allowTransparency="true"></iframe></li>
        <?php } if($twitterLike) {?>
        <li><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo get_bloginfo('url');?>" data-counturl="<?php echo get_bloginfo('url');?>" data-lang="en" data-count="<?php echo $twitterLikeStyle ; ?>">Tweet</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></li>
        <?php } if($googleLike) {?>
        <li><!-- Place this tag where you want the +1 button to render. -->
    <div class="g-plusone" data-size="<?php echo $googleLikeStyle; ?>"></div>

    <!-- Place this tag after the last +1 button tag. -->
    <script type="text/javascript">
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/platform.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script></li>
        <?php } ?>
    </ul>
    
    
    
    
    
</div>
</div>
<?php if (is_user_logged_in()) { ?>
<div class="vb_open vb_open_loggedIn">
<div class="vb_loggedIn_divprofile">
<div style="float:left">
<a title="View your profile" class="avatarimg" href="">
<?php
echo bp_core_fetch_avatar(array('item_id' => get_current_user_id(),
'type' => 'full',
'width' => 80,
'height' => 80
));
?>
</a>
</div>
<?php
$Current_User = wp_get_current_user();
$LoginUserValue = $Current_User->user_login;
$ProfileLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/profile/";
$ChangeAvatar = $ProfileLink . "change-avatar/";
$NotificationsLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/notifications/";
$FriendRequestLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/friends/requests/";
$GeneralSettingsLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/settings/notifications/";
$EmailPasswordLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/settings/";
$PostsLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/members/" . $LoginUserValue . "/";
$ThreadsLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/messages/";
?>
<div style="float:left">
<h3><a href=""><?php echo $Current_User->display_name; ?></a></h3>
<span style="font-size: 11px;" class="shade">Member</span>
<ul>
<li class="bottomlink"><a href="<?php echo $ProfileLink; ?>">Your Profile Page</a></li>
</ul>
</div>
</div>
<div class="vb_loggedIn_divprofilenav">
<?php
$linkPersonal = get_option('vb_buddy_linkPersonal');
$linkPost = get_option('vb_buddy_linkPost');
$linkAvatar = get_option('vb_buddy_linkAvatar');
$linkMessage = get_option('vb_buddy_linkMessage');
$linkPassword = get_option('vb_buddy_linkPassword');
$linkNotify = get_option('vb_buddy_linkNotify');
$linkGeneral = get_option('vb_buddy_linkGeneral');
$linkFriends = get_option('vb_buddy_linkFriends');
?>
<ul class="column1 blockLinksList">
<?php if($linkPersonal == 'on') { ?>
<li><a href="<?php echo $ProfileLink; ?>">Personal Details</a></li>
<?php }  if($linkAvatar == 'on') { ?>
<li><a href="<?php echo $ChangeAvatar; ?>">Edit Avatar</a></li>
<?php }  if($linkPassword == 'on') { ?>
<li><a href="<?php echo $EmailPasswordLink; ?>" >Email &amp; Password</a></li>
<?php }  if($linkGeneral == 'on') { ?>
<li><a href="<?php echo $GeneralSettingsLink; ?>" >General Settings</a></li>
<?php } ?>
</ul>
<ul class="column2 blockLinksList">
<?php if($linkPost == 'on') { ?>
<li><a href="<?php echo $PostsLink; ?>" >Your Latest Posts</a></li>
<?php }  if($linkMessage == 'on') { ?>
<li><a href="<?php echo $ThreadsLink; ?>" >Your Latest Threads</a></li>
<?php }  if($linkNotify == 'on') { ?>
<li><a href="<?php echo $NotificationsLink; ?>" >Your Notifications</a></li>
<?php }  if($linkFriends == 'on') { ?>
<li><a href="<?php echo $FriendRequestLink; ?>" >People You Ignore</a></li>
<?php } ?>
</ul>
</div>
<div style="border-bottom:2px solid #d1d8e7;" class="vb_loggedIn_divprofilenav">
<ul class="column2 blockLinksList">
<li><a onclick="" href="<?php echo wp_logout_url(get_bloginfo('url')); ?> ">Log Out</a></li>
</ul>
<a class="foo" href="#">

</a>
</div>
</div>
<?php } else { ?>
<div class="vb_open vb_open_login">
<div class="vb_login_div">
<?php 

$args = array(
'echo' => true,
'redirect' => "",
'form_id' => 'loginform',
'label_username' => __('Username'),
'label_password' => __('Password'),
'label_remember' => __('Remember Me'),
'label_log_in' => __('Log In'),
'id_username' => 'user_login',
'id_password' => 'user_pass',
'id_remember' => 'rememberme',
'id_submit' => 'wp-submit',
'remember' => true,
'value_username' => NULL,
'value_remember' => false
);?>
<?php wp_login_form($args); ?>
<?php
$nextend_fb_connect = maybe_unserialize(get_option('nextend_fb_connect')); 
echo new_fb_sign_button();
?>
</div>
</div>
<?php } ?>
</div>
<?php } ?>