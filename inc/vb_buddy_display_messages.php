<?php
$notifyLength = 5;
if(get_option('vb_buddy_notify_length') != '')
{
	$notifyLength =  get_option('vb_buddy_notify_length');
}
do_action( 'bp_before_member_messages_loop' );

if (bp_has_message_threads()) : ?>

<ul id="message-threads">
<li class="vb_buddy_header_row"><strong>Messages</strong><span id="open_message_dialog">Send a New Message</span></li>

<?php 
$Count=0;
while (bp_message_threads()) : bp_message_thread(); ?>
<?php 
if (bp_message_thread_has_unread()) 
{ ?>
	<li onclick="self.location.href='<?php bp_message_thread_view_link(); ?>';" class="livenotificationbit">
	<?php bp_message_thread_avatar(); ?>
	<div class="right_side">
	<div class="request_status">
	<p class="ln_sender_name">
	<?php bp_message_thread_from(); ?>
	</p><p class="ln_content"><?php bp_message_thread_excerpt(); ?><br></p>
	<p class="ln_time"><?php 
	$exactTime = str_replace('at',',',bp_get_message_thread_last_post_date());
	echo apply_filters( 'bp_get_the_thread_message_time_since', sprintf( __( 'Sent %s', 'buddypress' ), bp_core_time_since( strtotime( $exactTime ) ) ) ); ?></p>
	<div class="vb_buddy_small_buttons">
	<a class="hideNotification" href="<?php bp_message_thread_delete_link(); ?>">
	<div class="icon-remove-sign"></div>
	</a>
	<a href="<?php bp_message_thread_view_link(); ?>">
	<div class="icon-reply"></div>
	</a>
	</div>
	</div>
	</div>
	</li>
	<?php 
	$Count++; 
		if($Count==$notifyLength)
		{
			break;
		}
}
endwhile; ?>


<?php 
if($Count!=$notifyLength)
{
	while (bp_message_threads()) : bp_message_thread(); ?>
	<?php if (!bp_message_thread_has_unread()) 
	{ ?>

	<li onclick="self.location.href='<?php bp_message_thread_view_link(); ?>';" class="livenotificationbit read">
	<?php bp_message_thread_avatar(); ?>
	<div class="right_side">
	<div class="request_status">
	<p class="ln_sender_name">
	<?php bp_message_thread_from(); ?>
	</p><p class="ln_content"><?php bp_message_thread_excerpt(); ?><br></p>
	<p class="ln_time"><?php 
	$exactTime = str_replace('at',',',bp_get_message_thread_last_post_date());
	echo apply_filters( 'bp_get_the_thread_message_time_since', sprintf( __( 'Sent %s', 'buddypress' ), bp_core_time_since( strtotime( $exactTime ) ) ) ); ?></p>
	<div class="vb_buddy_small_buttons">
	<a class="hideNotification" href="<?php bp_message_thread_delete_link(); ?>">
	<div class="icon-remove-sign"></div>
	</a>
	<a href="<?php bp_message_thread_view_link(); ?>">
	<div class="icon-reply"></div>
	</a>
	</div>
	</div>
	</div>
	</li>
	<?php 
	$Count++; 
		if($Count==$notifyLength)
		{
			break;
		}
	}
	endwhile; 
}
?>



<?php
$Current_User = wp_get_current_user();
$LoginUserValue = $Current_User->user_login;
$ThreadsLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/messages/";
?>
<li class="vb_buddy_footer_row"><p><a href="<?php echo $ThreadsLink; ?>">Show All Private Messages</a></p></li>
</ul>

<?php else: ?>

<ul id="message-threads">
<li class="vb_buddy_header_row" id="open_message_dialog"><strong>Messages</strong><span>Send a New Message</span></li>
<li class="livenotificationbit"> No New Message Found </li>
<?php
$Current_User = wp_get_current_user();
$LoginUserValue = $Current_User->user_login;
$ThreadsLink = get_bloginfo('url') . "/members/" . $LoginUserValue . "/messages/";
?>
<li class="vb_buddy_footer_row"><p><a href="<?php echo $ThreadsLink; ?>">Show All Private Messages</a></p></li>
</ul>


<?php endif; ?>

<div class="send_message_dialog">
<form name="SendMessageForm">
<div class="vb_buddy_send_form_row">
<span>To:</span>  <input type="text" name="vb_buddy_receiver_name" id="vb_buddy_receiver_name" autocomplete="off">
</div>
<div class="vb_buddy_send_form_row">
<span>Subject:</span>   <input type="text" name="vb_buddy_message_subject_input" id="vb_buddy_message_subject_input" />
</div>
<div class="vb_buddy_send_form_row">
<textarea id="vb_buddy_message_area" name="vb_buddy_message_area" placeholder="Write a message" rows="5"></textarea>
</div>
<label class="vb_buddy_message_notify"></label>
<input class="button" type="button" id="btnSendMessage" value="Send" />


<div id="UserFetchBox" class="UserFetchBox" align="left"></div>


</form>
</div>