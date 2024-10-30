
<ul id="notification-threads">
<li class="vb_buddy_header_row"><strong>Notifications</strong><span id="open_notification_settings"></span></li>

<?php
/* $Component="activity";
$Type = "activity_comment";
GetActivityNotifications($Component, $Type); */
$AwardNotification = getUnreadAwardCount(bp_loggedin_user_id());
$BPNotifications= getUnreadBPNotificationCount();
$NewNotifications = $BPNotifications + $AwardNotification;
$notifyLength = 5;
if(get_option('vb_buddy_notify_length') != '')
{
	$notifyLength =  get_option('vb_buddy_notify_length');
}
if($NewNotifications!=0)
{
 
	if ($BPNotifications != 0) 
	{
		getBPNotifications($BPNotifications);
	}
	if($AwardNotification!=0)
	{	
		
		echo getUnreadAward(get_current_user_id());
	}
	
		if($NewNotifications<$notifyLength)
		{
		 getReadBPNotifications($NewNotifications);
		}
}
else
{	
	if(getReadBPNotifications($NewNotifications)==0)
	{
		echo '<li class="livenotificationbit"> No New Notification Found </li>';
	}	
}

?>
<li class="vb_buddy_footer_row"><p><a href="<?php echo get_bloginfo('url')."/notification/";?>">Show All Notifications</a></p></li>
</ul>

