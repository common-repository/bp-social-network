<?php

add_action('wp_ajax_nopriv_vb_buddy_load_users', 'vb_buddy_load_users_callback');
add_action('wp_ajax_vb_buddy_load_users', 'vb_buddy_load_users_callback');

add_action('wp_ajax_nopriv_vb_buddy_send_message', 'vb_buddy_send_message_callback');
add_action('wp_ajax_vb_buddy_send_message', 'vb_buddy_send_message_callback');

add_action('wp_ajax_nopriv_vb_buddy_read_notify', 'vb_buddy_read_notify_callback');
add_action('wp_ajax_vb_buddy_read_notify', 'vb_buddy_read_notify_callback');


function vb_buddy_read_notify_callback()
{
    extract($_POST);
    $_POST['ardId'];
    
    echo ChangeAwardState($_POST['ardId']);
    
    die(0);
    
}

function vb_buddy_send_message_callback() {

extract($_POST);

$userData = get_userdatabylogin($to);

$args = array('recipients' => $userData->ID, 'sender_id' => get_current_user_id(), 'subject' => $subject, 'content' => $message);
messages_new_message($args);

echo "Message Sent";
die(0);
}

function vb_buddy_load_users_callback() {

extract($_POST);

$SearchValue = $recname;
$args = array(
'blog_id' => $GLOBALS['blog_id'],
'role' => '',
'meta_key' => '',
'meta_value' => '',
'meta_compare' => '',
'meta_query' => array(
'relation' => 'OR',
array(
'key'     => 'first_name',
'value'   => $SearchValue,
'compare' => 'LIKE'
),
array(
'key'     => 'last_name',
'value'   => $SearchValue,
'compare' => 'LIKE'
)
),
'include' => array(),
'exclude' => array(),
'orderby' => 'login',
'order' => 'DESC',
'offset' => '',
'search' => '',
'number' => '',
'count_total' => false,
'fields' => 'all',
'who' => ''
);
$user_query = new WP_User_Query($args);
if (!empty($user_query->results)) {

foreach ($user_query->results as $user) {
$FetchBox .= '<div class="FetchedUserDiv">';
$FetchBox .= '<div class="UserAvatar">';
$FetchBox .= bp_core_fetch_avatar(array('item_id' => $user->ID));
$FetchBox .= '</div>';

$FetchBox .= '<div class="UserInfo">';
$FetchBox .= '<h1 id="'.$user->user_login.'">' . $user->first_name .' '. $user->last_name .'</h1>';
$FetchBox .= '</div>';

$FetchBox .= '</div>';
}
} else {
$FetchBox .= 'No Users found.';
}

echo $FetchBox;
die(0);
}
?>