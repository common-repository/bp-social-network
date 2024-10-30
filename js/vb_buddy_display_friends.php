<ul id="message-threads">
<li class="vb_buddy_header_row"><strong>Friend Requests</strong></li>
<?php
/* $UserID = get_current_user_id();
bp_get_friendship_requests( $UserID); */
if (bp_has_members('type=alphabetical&include=' . bp_friend_get_total_requests_count())) :
while (bp_members()) : bp_the_member();
?>
<div class="livenotificationbit">
<div class="userImage">
<?php bp_member_avatar(); ?>
</div>

<div class="friendRequestData">
<div class="requestInfo">
<a href="<?php bp_member_link(); ?>"><?php bp_member_name(); ?></a> has added you.
<br/>
<?php
$AddedTime = bp_member_last_active();

echo substr($AddedTime, 7)
?>

</div>
 

<div class="requestOptions">
<div class="accept">
<a href="<?php echo bp_friend_accept_request_link(); ?>"><?php _e('Accept', 'buddypress'); ?></a>
</div>
<div class="reject">
<a href="<?php echo bp_friend_reject_request_link(); ?>"><?php _e('Reject', 'buddypress'); ?></a>
</div>
</div>


</div>
<div class="requestDeleteLink">

<a href="<?php bp_friend_reject_request_link(); ?>"><div class="icon-remove-sign"></div></a>
</div>
</div>





<?php endwhile; ?>
<?php endif; ?>
<?php
$Current_User = wp_get_current_user();
$LoginUserValue = $Current_User->user_login;
$FriendRequestLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/friends/requests/";
?>
<li class="vb_buddy_footer_row"><p><a href="<?php echo $FriendRequestLink; ?>">Show All Friend Requests</a></p></li>
</ul>