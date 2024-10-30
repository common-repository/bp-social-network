<?php
error_reporting(0);
$Count = 0;
global $bp;
$AwardNotification = getUnreadAwardCount(bp_loggedin_user_id());
$BPNotifications= getUnreadBPNotificationCount();
$NewNotifications = $BPNotifications + $AwardNotification;

function GetReward($Count, $Type)
{ $FriendsPoints = get_option('vb_buddy_friends_points'); $FriendsText = get_option('vb_buddy_friends_text');  $MessagesPoints = get_option('vb_buddy_messages_points'); $MessagesText = get_option('vb_buddy_messages_text');  $PostsPoints = get_option('vb_buddy_posts_points'); $PostsText = get_option('vb_buddy_posts_text');  $CommentsPoints = get_option('vb_buddy_comments_points');   $CommentsText = get_option('vb_buddy_comments_text');  
 $UserID = get_current_user_id();
 $AwardCategory = $Type; 
 if($Type=="Comments")
 {
  $CommentsArray = array("1st Comment", "5 Comments", "10 Comments", "20 Comments", "30 Comments", "50 Comments", "100 Comments");
  for( $index=0; $index< count($CommentsArray); $index++)
  { 
   $Value = intval($CommentsArray[$index]);
   if($Count==$Value)
   {
	$AwardType = $CommentsArray[$index];	$AwardText = $CommentsText.$AwardType." Award";    $Points = $CommentsPoints;
	if(CheckAward($UserID, $AwardCategory, $AwardType))
	{
		InsertAward($UserID, $AwardCategory, $AwardType, $AwardText, $Points);
	}
	break;
   }
  }
 }
 
 else if($Type=="Friends")
 {
  $FriendsArray = array("1st Friend", "5 Friends", "10 Friends", "20 Friends", "30 Friends", "50 Friends", "100 Friends");
  for( $index=0; $index< count($FriendsArray); $index++)
  { 
   $Value = intval($FriendsArray[$index]);
   if($Count==$Value)
   {
	$AwardType = $FriendsArray[$index];	$AwardText = $FriendsText.$AwardType." Award";    $Points = $FriendsPoints;
	if(CheckAward($UserID, $AwardCategory, $AwardType))
	{		InsertAward($UserID, $AwardCategory, $AwardType, $AwardText, $Points);
	}
	break;
   }
  }
 } 
 else if($Type=="Messages")
 {
  $MessagesArray = array("1st Message", "5 Messages", "20 Messages", "40 Messages", "70 Messages", "100 Messages");   
  for( $index=0; $index< count($MessagesArray); $index++)
  { 
   $Value = intval($MessagesArray[$index]);
   if($Count==$Value)
   {	
	$AwardType = $MessagesArray[$index];	$AwardText = $MessagesText.$AwardType." Award";    $Points = $MessagesPoints;	if(CheckAward($UserID, $AwardCategory, $AwardType))
	{		InsertAward($UserID, $AwardCategory, $AwardType, $AwardText, $Points);
	}
	break;
   }
  }
 }
 
 else if($Type=="Posts")
 {  $PostsArray = array("1st Post", "10 Posts", "15 Posts", "30 Posts", "60 Posts", "80 Posts", "100 Posts");
  for( $index=0; $index< count($PostsArray); $index++)
  { 
   $Value = intval($PostsArray[$index]);
   if($Count==$Value)
   {
	$AwardType = $PostsArray[$index]; 	$AwardText = $PostsText.$AwardType." Award";    $Points = $PostsPoints;	
	if(CheckAward($UserID, $AwardCategory, $AwardType))
	{		InsertAward($UserID, $AwardCategory, $AwardType, $AwardText, $Points);
	}
	break;
   }
  }
 }
}

function getTotalSentMessageThreads($UserID) 
{
	global $wpdb, $bp;
	$prefix=$wpdb->prefix;		
	return (int) $wpdb->get_var( $wpdb->prepare( 
	"SELECT count(sender_id) 
	 FROM ".$prefix."bp_messages_messages 
	 WHERE sender_id ='$UserID'",$UserID ) );
}

function getTotalComments($UserID,$Type) 
{   
	global $wpdb, $bp;
	$prefix=$wpdb->prefix;		
	return (int) $wpdb->get_var( $wpdb->prepare( 
	"SELECT count(user_id) 
	 FROM ".$prefix."bp_activity 
	 WHERE type = '".$Type."' AND user_id ='$UserID'",$UserID ) );
}

function InsertAward($UserID, $AwardCategory, $AwardType, $AwardText, $Points)
{
 global $wpdb; 
 $prefix=$wpdb->prefix;		
 $TableName= $prefix."awardnotification";
 $wpdb->insert($TableName , array(
 'userid' => $UserID,
 'awardcategory' => $AwardCategory,
 'award_type' => $AwardType,
 'award_text' => $AwardText,
 'points' => $Points,
 'is_read' => 0));
}


function CheckAward($UserID, $AwardCategory, $AwardType)
{
 global $wpdb; 
 $prefix=$wpdb->prefix;		
 $TableName= $prefix."awardnotification";
 $AwardStatus = $wpdb->get_var("SELECT COUNT(*) FROM $TableName WHERE userid = '$UserID' AND awardcategory = '$AwardCategory' AND award_type = '$AwardType'");
 return ($AwardStatus == 0 ? true : false);
}

function GetTotalPoints($UserID)
{
 global $wpdb; 
 $prefix=$wpdb->prefix;		
 $TableName= $prefix."awardnotification";
 $TotalPoints = 0;
 $AwardPoints = $wpdb->get_results("SELECT points FROM $TableName WHERE userid = '$UserID'");
 if(!empty($AwardPoints))
 {
	foreach ( $AwardPoints as $Record )
	{
		$TotalPoints+= $Record->points;
	}
 }
 return $TotalPoints;
}

function getUnreadAwardCount($UserID)
{ 
 global $wpdb;  
 $prefix=$wpdb->prefix;		
 $TableName= $prefix."awardnotification";
 $UnreadAwardsCount = $wpdb->get_var("SELECT COUNT(*) FROM $TableName WHERE userid = '$UserID' AND is_read = '0'");
 return $UnreadAwardsCount;
}

function getUnreadAward($UserID)
{
 $UnreadAwardNotifications = null;
 global $wpdb;  
 $prefix=$wpdb->prefix;		
 $TableName= $prefix."awardnotification";
 $UnreadAwards = $wpdb->get_results("SELECT * FROM $TableName WHERE userid = '$UserID' AND is_read = '0' ORDER BY time DESC");
 if(!empty($UnreadAwards))
 {
	foreach ( $UnreadAwards as $Record )
	{
	 $ID = $Record->id;
	 $Folder = $Record->awardcategory;
	 $ImageFile = $Record->award_type.".jpg";
	 $Points = $Record->points;
	 $AwardText = $Record->award_text;
	 $FullPath = plugins_url('../images/'.$Folder.'/'.$ImageFile,__FILE__);
	 $awardPageUrl = get_option('vb_buddy_awards_url');
	 $UnreadAwardNotifications .= '<li class="livenotificationbit vb_notification" id="UnreadAward'.$ID.'">';
	 $UnreadAwardNotifications .= '<a href="'.$awardPageUrl.'">';
	 $UnreadAwardNotifications .= '<img src="'.$FullPath.'"/>';
	 $UnreadAwardNotifications .= '<p style="color: green; text-align: center; font-weight: bolder; font-size: large;"> +'.$Points.'</p>';
	 $UnreadAwardNotifications .= '<p id="UnreadAward" style="padding: 10px; text-align: center;">'.$AwardText;	 
	 $UnreadAwardNotifications .= '</p></a></li>';
	}
 }
 return $UnreadAwardNotifications; 
}
 
function getBPNotifications($BPNotifications)
{
	$Count=0;
	/* $NewPost = "activity_update";
	$NewComment = "activity_comment"; */
	if (bp_has_notifications()) :
	while (bp_the_notifications()) : bp_the_notification(); 	
		if(bp_get_the_notification_component_name()=="friends" && bp_get_the_notification_component_action()=="friendship_request")
		{
			
		}
		else if(bp_get_the_notification_component_name()=="messages")
		{
		 
		}
		else
		{
			echo '<li class="livenotificationbit vb_notification">';
			bp_the_notification_description();		    echo'<span class="ReadLink">'.bp_get_the_notification_mark_read_link().'</span>';
			echo '</li>';
		}
		$Count++;
	if ($BPNotifications == $Count) 
	{
	 break;
	}
	endwhile; 
		endif;
	
	
}

 
function getReadBPNotifications($BPNotifications)
{
	if (bp_has_notifications()) :
	while (bp_the_notifications()) : bp_the_notification(); 	
		if(bp_get_the_notification_component_name()=="friends" && bp_get_the_notification_component_action()=="friendship_request")
		{
			
		}
		else if(bp_get_the_notification_component_name()=="messages")
		{
		 
		}
		else
		{					echo '<li class="livenotificationbit vb_notification read">';						if(bp_get_the_notification_component_action()=="friendship_accepted")			{					$Notice = bp_get_the_notification_description();	 				$FriendRequest = explode(">",$Notice);				$Name =  explode("accepted your",$FriendRequest[1]);			 				echo $Name[0]." Accepted Your ".$FriendRequest[0]."><strong>Friend Request</strong></a>";							}			else if(bp_get_the_notification_component_action()=="new_at_mention")			{				 $Notice = bp_get_the_notification_description();				 $You = explode(">",$Notice);				 $Name =  explode("mentioned",$You[1]);			 				 echo $Name[0]." mentioned ".$You[0]."><strong>You</strong></a>";			}			else			{
				echo $Notice; 			}			echo '</li>';
			$BPNotifications++;
		}
	if ($BPNotifications == 5) 
	{
	 break;
	}
	endwhile; 
		endif;
	return $BPNotifications;
}


function GetActivityNotifications($Component, $Type)
{
echo "<br>";
 global $wpdb; 
 $prefix=$wpdb->prefix;		
 $TableName= $prefix."bp_activity";
 $UserID = get_current_user_id();
 $ActivityPosts = $wpdb->get_results("SELECT * FROM $TableName WHERE user_id = '$UserID' AND component='$Component' AND type='$Type'");
 if(!empty($ActivityPosts))
 { 
	foreach ( $ActivityPosts as $Record )
	{
	 $ActivityID = $Record->id;
	 echo '<li class="livenotificationbit vb_notification">';
		echo "Post: ".$Record->content;
	 echo '</li>';
	 $Type="activity_comment";
	 $ActivityComments = $wpdb->get_results("SELECT * FROM $TableName WHERE  item_id ='$ActivityID'  AND user_id <> '$UserID' AND type='$Type'");
	 if(!empty($ActivityComments))
	 { 
		foreach ( $ActivityComments as $Record2 )
		{
			$CommenterID = $Record2->user_id;
			$user_info = get_userdata($CommenterID);
			$CommenterName = $user_info->user_login;
			
			echo '<li class="livenotificationbit vb_notification" style="padding-left: 100px;">';
			echo $CommenterName.":".$Record2->content;
			echo '</li>';
		}
	 }
	}
 }
 
 
 
 
}

function getUnreadBPNotificationCount()
{
	$ComponentName="messages";
	$ComponentAction="friendship_request";
	$Count=0;
	global $bp;
	global $wpdb; 
	$prefix=$wpdb->prefix;		
	$TableName= $prefix."bp_notifications";
	$UserID = get_current_user_id();
	// $BPNotificationsCount= $wpdb->get_var("SELECT COUNT(*) FROM $TableName WHERE user_id = '$UserID' AND component_name<>'$ComponentName' AND is_new='1'"); 
	$BPNotificationsCount= $wpdb->get_results("SELECT component_name,component_action FROM $TableName WHERE user_id = '$UserID' AND is_new='1'");
	if(!empty($BPNotificationsCount))
   {
		foreach ( $BPNotificationsCount as $Record )
		{
		 if($Record->component_name=="messages")
		 {
		 
		 }
		 else if($Record->component_name=="friends" && $Record->component_action=="friendship_request")
		 {
		 		
		 }
		 else
		 {
		  $Count++;
		 }
		}
   }
	return $Count;
}


 function ChangeAwardState($ID)
 { 
 global $wpdb;  
 $prefix=$wpdb->prefix;		 
 $TableName= $prefix."awardnotification"; 
 $ChangeAwardStatus = $wpdb->update( $TableName, array( 'is_read' => 1), array('id'=>$ID));  
 return $ChangeAwardStatus;
 } 

function GetTotalRewards($AwardCategory) 
{
 	 $UserID = get_current_user_id();
	 $Awards = null;
	 global $wpdb;  
	 $prefix=$wpdb->prefix;		
	 $TableName= $prefix."awardnotification";
	 $FetchAwards = $wpdb->get_results("SELECT * FROM $TableName WHERE userid = '$UserID' AND awardcategory='$AwardCategory'");
	 if(!empty($FetchAwards))
	 {
		foreach ( $FetchAwards as $Record )
		{
		 $AwardType = $Record->award_type;		 $Points = $Record->points;		 $AwardText = $Record->award_text;		 $AwardTime = date("Y-m-d",strtotime($Record->time));		 		 		 $ID = $Record->id;
		 $Folder = $Record->awardcategory;
		 $ImageFile = $AwardType.".jpg";		 	
		 $AwardText = $AwardType." Award";
		 $FullPath = plugins_url('../images/'.$Folder.'/'.$ImageFile,__FILE__);
		
		
			 $Awards .= '<li>';
			 $Awards .= '<img src="'.$FullPath.'"/>';
			 
			 $Awards .= '+'.$Points.'<br/>';
			 $Awards .= $AwardText;	 
			 $Awards .="  ".$AwardTime;
			 $Awards .= '</li>';
		 
		}
	 }
	 else
	 {
	 
	  $Awards = "No Award Won So Far";
	 }
    return $Awards;  
}

function GetAllNotifications()
{	
	if (bp_has_notifications()) :
	while (bp_the_notifications()) : bp_the_notification(); 	
	if(bp_get_the_notification_component_name()=="friends" && bp_get_the_notification_component_action()=="friendship_request")
	{
 		
	}
	else if(bp_get_the_notification_component_name()=="messages")
	{
	 
	}
	else
	{
		echo '<li class="livenotificationbit vb_notification">';
		bp_the_notification_description();
		echo '</li>';
		$Count++;
	}
	
	
	endwhile; 
	endif;
}


/***********************ACTIVITY NOTIFICATION************************/



function SetupGlobals() 
{
    global $bp, $current_blog;
    $bp->ac_notifier=new stdClass();
    $bp->ac_notifier->id = 'ac_notifier';
    $bp->ac_notifier->slug = BP_ACTIVITY_NOTIFIER_SLUG;
    $bp->ac_notifier->notification_callback = 'ac_notifier_format_notifications';
    
    $bp->active_components[$bp->ac_notifier->id] = $bp->ac_notifier->id;

    do_action( 'SetupGlobals' );
}



function NotifierNotify($comment_id, $params)
{
   global $bp;
   extract( $params );

   $users=ac_notifier_find_involved_persons($activity_id);
   $activity=new BP_Activity_Activity($activity_id);
  
   if($activity->hide_sitewide)
           return;
   
   if(!in_array($activity->user_id, $users)&&($bp->loggedin_user->id!=$activity->user_id))//if someone else is commenting
       array_push ($users, $activity->user_id);
   
    foreach((array)$users as $user_id){
               
               bp_core_add_notification( $activity_id, $user_id, $bp->ac_notifier->id, 'new_activity_comment_'.$activity_id );//a hack to not allow grouping by component,action, rather group by component and individual action item
           }
}


 

function ac_notifier_format_notifications( $action, $activity_id, $secondary_item_id, $total_items,$format='string' ) 
{
   
    global $bp;
    $glue='';
    $user_names=array();
      $activity = new BP_Activity_Activity( $activity_id );
    $link=ac_notifier_activity_get_permalink( $activity_id );
  
     
    if($activity->user_id==$bp->loggedin_user->id){
                $text=__("your");
                $also="";
        }
    else{
         $text=sprintf(__("%s's"),  bp_core_get_user_displayname ($activity->user_id));//somone's
         $also=" also";
          
        }
    $ac_action='new_activity_comment_'.$activity_id;

    if($action==$ac_action){
	
        $users=ac_notifier_find_involved_persons($activity_id);
        $total_user= $count=count($users);
        if($count>2){
              $users=array_slice($users, $count-2);
              $count=$count-2;
              $glue=", ";
             }
        else if($total_user==2)
             $glue=" and ";

       foreach((array)$users as $user_id)
             $user_names[]=bp_core_get_user_displayname ($user_id);
                
      if(!empty($user_names))
            $commenting_users=join ($glue, $user_names);
                   
                
     if($total_user>2)
        $text=$commenting_users." and ".$count." others".$also." commented on ".$text. " post";//can we change post to some meaningfull thing depending on the activity item ?
     else
        $text=$commenting_users.$also ." commented on ".$text. " post";
    
     if($format=='string')
       return apply_filters( 'bp_activity_multiple_new_comment_notification', '<a href="' . $link. '">' . $text . '</a>');
    else{
        return array('link'=>$link,
              'text'=>$text);
        }
   
    }
return false;
}


function RemoveNotification($activity,$has_access){
    global $bp;
    if($has_access)
        bp_core_delete_notifications_by_item_id(  $bp->loggedin_user->id, $activity->id, $bp->ac_notifier->id,  'new_activity_comment_'.$activity->id);
    
}


function RemoveNotificationBlog(){
    if(!(is_user_logged_in()&&  is_singular()))
        return;

    global $bp,$wpdb;
    $blog_id = (int)$wpdb->blogid;
    $post=wp_get_single_post();
    
    $activity_id=  bp_activity_get_activity_id( array(
		'user_id' => $post->post_author,
		'component' => $bp->blogs->id,
		'type' => "new_blog_post",
                "item_id"=>$blog_id,
		'secondary_item_id' => $post->ID
		
	));
    
    if(!empty($activity_id))
        bp_core_delete_notifications_by_item_id(  $bp->loggedin_user->id, $activity_id, $bp->ac_notifier->id,  'new_activity_comment_'.$activity_id);

    
      $comments=ac_notifier_get_all_blog_post_comment_ids($post->ID);
      
      $activities=ac_notifier_get_activity_ids(array("type"=>"new_blog_comment",
                                                     "component" => $bp->blogs->id,
                                                  "item_id"=>$blog_id,
                                                  "secondary_ids"=>$comments
                                                ));


    foreach((array)$activities as $ac_id)
         bp_core_delete_notifications_by_item_id(  $bp->loggedin_user->id, $ac_id, $bp->ac_notifier->id,  'new_activity_comment_'.$ac_id);

}



function RemoveNotificationTopic(){
    global $bp;
    
    if(!(bp_is_active("groups")&&bp_is_active("forums")))
        return;
  
    
    if(bp_is_group_forum_topic()&&  is_user_logged_in()){
        $topic_id = bp_forums_get_topic_id_from_slug( $bp->action_variables[1] );//get id from slug
        $topic=get_topic($topic_id);
        $group_id= $bp->groups->current_group->id;

       
         $activity_id=  bp_activity_get_activity_id( array(
                        'user_id' => $topic->poster_id,
                        'component' => $bp->groups->id,
                        'type' => "new_forum_topic",
                        "item_id"=>$group_id,
                        'secondary_item_id' => $topic_id

                ));

         
        if(!empty ($activity_id))
               bp_core_delete_notifications_by_item_id(  $bp->loggedin_user->id, $activity_id, $bp->ac_notifier->id,  'new_activity_comment_'.$activity_id);


        $posts=ac_notifier_get_forum_post_ids($topic_id);
        if(!empty($posts)){
             
            $activities=ac_notifier_get_activity_ids(array( "item_id"=>$group_id,
                                                            "secondary_ids"=>$posts,
                                                            "component"=>$bp->groups->id,
                                                            "type"=>"new_forum_post"

                                                            ));
            foreach((array)$activities as $ac_id)
                bp_core_delete_notifications_by_item_id(  $bp->loggedin_user->id, $ac_id, $bp->ac_notifier->id,  'new_activity_comment_'.$ac_id);

             }
    }
   
}



function ClearNotificationOnDelete($ac_ids){
    global $bp;

    
    foreach((array)$ac_ids as $activity_id)
        bp_core_delete_all_notifications_by_type( $activity_id, $bp->ac_notifier->id, 'new_activity_comment_'.$activity_id, $secondary_item_id = false );
}




function ac_notifier_find_involved_persons($activity_id){
    global $bp,$wpdb;
   return $wpdb->get_col($wpdb->prepare("select DISTINCT(user_id) from {$bp->activity->table_name} where item_id=%d and user_id!=%d ",$activity_id,$bp->loggedin_user->id));//it finds all uses who commted on the activity
 }

function ac_notifier_get_all_blog_post_comment_ids($post_id) {
    global $wpdb;
    return $wpdb->get_col($wpdb->prepare("SELECT comment_ID as id FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved = '1' ORDER BY comment_date", $post_id));
}


function ac_notifier_get_forum_post_ids($topic_id){
    global $wpdb,$bbdb;
    return $wpdb->get_col($wpdb->prepare("SELECT post_id FROM {$bbdb->posts} where topic_id=%d",$topic_id));
}


function ac_notifier_get_activity_ids($params){
    global $bp,$wpdb;
    extract($params);
    $list="(".join(",", $secondary_ids).")";//create a set to use in the query;

    return $wpdb->get_col($wpdb->prepare("SELECT id from {$bp->activity->table_name} where type=%s and component=%s and item_id=%d and secondary_item_id in {$list}",$type,$component,$item_id));
   
}

function ac_notifier_activity_get_permalink( $activity_id, $activity_obj = false ) {
	global $bp;

	if ( !$activity_obj )
		$activity_obj = new BP_Activity_Activity( $activity_id );
                    
	
		if ( 'activity_comment' == $activity_obj->type )
			$link = bp_get_activity_directory_permalink(). 'p/' . $activity_obj->item_id . '/';
		else
			$link = bp_get_activity_directory_permalink() . 'p/' . $activity_obj->id . '/';
	

	return apply_filters( 'ac_notifier_activity_get_permalink', $link );
}


/***** Group Notifications *****/
add_action('bp_include','bp_local_group_notifier_load');

function bp_local_group_notifier_load(){
    
    include_once (plugin_dir_path(__FILE__).'loader.php');
    
}

class BPLocalGroupNotifierHelper{
    
    private static $instance;

    private function __construct() 
	{
		add_action('bp_activity_add',array($this,'notify_members'));    
        add_action('bp_activity_screen_single_activity_permalink', array($this,'delete_on_single_activity'),10,2);            

    }
    
    
    public static function get_instance()
	{
        if(!isset(self::$instance))
           self::$instance= new self();
        
        return self::$instance;
        
    }
   
    function notify_members($params){
        global $bp;
 
        
        if($params['component']!=$bp->groups->id)
            return ;

        
        $activity_id= bp_activity_get_activity_id($params);

        if(empty($activity_id))
            return;
      
        
        $activity= new BP_Activity_Activity($activity_id);
        
        $group_id=$activity->item_id;
       
       
        $members_data=  BP_Groups_Member::get_all_for_group( $group_id, false,false,false );//include admin/mod
        
       
        $members=$members_data['members'];

       
        foreach((array)$members as $member){
            if($member->user_id==$activity->user_id)
                 continue;

            
             self::add_notification($group_id, $member->user_id, 'localgroupnotifier', 'group_local_notification_'.$activity_id, $activity_id);
        }


    }



    function delete_on_single_activity($activity, $has_access){
        if(!is_user_logged_in())
            return;

        if(!$has_access)
           return ;

        BP_Core_Notification::delete_for_user_by_item_id(get_current_user_id(), $activity->item_id, 'localgroupnotifier','group_local_notification_'.$activity->id, $activity->id);
    
    }
   
    
    function DeleteFromGroupForums(){
        if(!is_user_logged_in()||!function_exists('bbpress'))
            return;
        
        
        if ( bp_is_single_item() && bp_is_groups_component() && bp_is_current_action( 'forum' )&&  bp_is_action_variable('topic') ){
            

            if(!self::notification_exists(
                    array(
                        'item_id'=>  bp_get_current_group_id(),
                        'component'=>'localgroupnotifier',
                        'user_id'=>  get_current_user_id()
                     ))
              )
             return;

            
				$topic_slug = bp_action_variable( 1 );
                $post_status = array( bbp_get_closed_status_id(), bbp_get_public_status_id() );
				$topic_args = array( 'name' => $topic_slug, 'post_type' => bbp_get_topic_post_type(), 'post_status' => $post_status );
				$topics     = get_posts( $topic_args );

				
				if ( !empty( $topics ) ) 
					$topic = $topics[0];

                if(empty($topic))
                    return;
                
  
                
                $default = array(
                    'post_type'      => bbp_get_reply_post_type(), // Only replies
                    'post_parent'    => $topic->ID, // Of this topic
                    'posts_per_page' => -1, // all
                    'paged'          =>false, 
                    'orderby'        => 'date',
                    'order'          => 'ASC' ,
                    'post_status'    =>'any'   
           

                );
  
            global $wpdb;
                
            $reply_ids=array();
            
            $replies=  get_posts($default);
            
           
            if(!empty($replies))
                $reply_ids=  wp_list_pluck ($replies, 'ID');
            
           
            
            $reply_ids[]=$topic->ID;
            $list='('.join(',',$reply_ids).')';

            
            $activity_ids=$wpdb->get_col($wpdb->prepare("SELECT meta_value AS id FROM {$wpdb->postmeta} WHERE meta_key=%s AND post_id IN {$list}",'_bbp_activity_id'));

            
            $activities = bp_activity_get_specific( array( 'activity_ids' => $activity_ids, 'show_hidden' => true, 'spam' => 'all', ) );
            
            
            if($activities['total']>0)
                $activities=$activities['activities'];
            
            
            
            $current_user=get_current_user_id();

            foreach((array)$activities as $activity){
                

                 BP_Core_Notification::delete_for_user_by_item_id($current_user, $activity->item_id, 'localgroupnotifier','group_local_notification_'.$activity->id, $activity->id);

            }
                
        
    }
    
  }
    
    
    function add_notification( $item_id, $user_id, $component_name, $component_action, $secondary_item_id = 0, $date_notified = false ) {

            if(self::notification_exists(array(
               'item_id'=>$item_id,
               'component'=>$component_name,
               'action'=>$component_action,
               'secondary_item_id'=>$secondary_item_id,
               'user_id'=>$user_id

               )))
             return ;
    
            if ( empty( $date_notified ) )
               $date_notified = bp_core_current_time();
            

            $notification                   = new BP_Core_Notification;
            $notification->item_id          = $item_id;
            $notification->user_id          = $user_id;
            $notification->component_name   = $component_name;
            $notification->component_action = $component_action;
            $notification->date_notified    = $date_notified;
            $notification->is_new           = 1;

            if ( !empty( $secondary_item_id ) )
                $notification->secondary_item_id = $secondary_item_id;

            if ( $notification->save() )
                return true;

            return false;
    }

   
    function notification_exists($args='' ){
        
        global $bp,$wpdb;
        
        $args=  wp_parse_args($args,array(
                    'user_id'=>false,
                    'item_id'=>false,
                    'component'=>false,
                    'action'=>false,
                    'secondary_item_id'=>false
                ));
        
        extract($args);

        $query="SELECT id FROM {$bp->core->table_name_notifications} ";

        $where=array();

        if($user_id)
            $where[]=$wpdb->prepare("user_id=%d",$user_id);

        if($item_id)
            $where[]=$wpdb->prepare("item_id=%d",$item_id);

        if($component)
            $where[]=$wpdb->prepare("component_name=%s",$component);

        if($action)
            $where[]=$wpdb->prepare("component_action=%s",$action);
        if($secondary_item_id)
            $where[]=$wpdb->prepare("secondary_item_id=%d",$secondary_item_id);


        $where_sql=  join(" AND ", $where);
       
        return $wpdb->get_var($query." WHERE {$where_sql}");
    
    }
}




BPLocalGroupNotifierHelper::get_instance();

 

   function bp_local_group_notifier_format_notifications($action, $item_id, $secondary_item_id, $total_items, $format = 'string'){

       $group_id=$item_id; 
       $group = groups_get_group( array( 'group_id' => $group_id ) );
       $group_link = bp_get_group_permalink( $group ); 

       if ( (int) $total_items > 1 ) {
                    $text = sprintf( __( '%1$d new activities in the group "%2$s"', 'bp-local-group-notifier' ), (int) $total_items, $group->name );

                    if ( 'string' == $format ) {
                        return '<a href="' . $group_link . '" title="' . __( 'New group Activities', 'bp-local-group-notifier' ) . '">' . $text . '</a>';
                    } else {
                        return array(
                            'link' => $group_link,
                            'text' => $text
                        );
                    }
        } else {
                    $activity= new BP_Activity_Activity($secondary_item_id);

                    $text = strip_tags($activity->action);//here is the hack, think about it :)

                    $notification_link = bp_activity_get_permalink( $activity->id, $activity );

                    if ( 'string' == $format ) {
                        return '<a href="' . $notification_link . '" title="' .$text . '">' . $text . '</a>';
                        } else {
                        return array(
                            'link' => $notification_link,
                            'text' => $text
                        );
                    }
                } 
    }
	
?>