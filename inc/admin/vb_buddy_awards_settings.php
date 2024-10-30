<?php
if(isset($_GET['save_points']))
{
update_option('vb_buddy_friends_points',$_POST['txtFriendshipPoints']);
update_option('vb_buddy_messages_points',$_POST['txtMessagesPoints']);
update_option('vb_buddy_posts_points',$_POST['txtPostPoints']);
update_option('vb_buddy_comments_points',$_POST['txtCommentsPoints']);
?>
<script>
window.location = "admin.php?page=vb_buddy_awards_settings";
</script>
<?php
exit;
}
elseif(isset($_GET['save_text']))
{
update_option('vb_buddy_friends_text',$_POST['txtFriendshipText']);
update_option('vb_buddy_messages_text',$_POST['txtMessagesText']);
update_option('vb_buddy_posts_text',$_POST['txtPostText']);
update_option('vb_buddy_comments_text',$_POST['txtCommentsText']);
?>
<script>
window.location = "admin.php?page=vb_buddy_awards_settings";
</script>
<?php
exit;
}
else
{
?>
<div class="wrap">
    
    <div class="welcome-panel" style="padding-bottom: 9px;">
        <img style="float: left; height: 48px; margin-right: 10px;" src="<?php echo plugins_url('../../images/med_logo.png',__FILE__); ?>" />
        <h2>vBSocial BuddyPress Awards Settings</h2>
        <h4> <span class="redlight">Unlock </span>all the features, in the <a href="http://vbsocial.com/buddypress-social-network/">Premium version, </a>including Private Messages, Friend Requests, User Awards, and Social Settings. <a href="Read more...">Buy Now!</a> |  <a href="http://vbsocial.com/buddypress-social-network/">Read More</a></h4>
<p></p>
        <div id="tabs">
            <ul>
              <li><a href="#tabs-1">Awards Points</a></li>
              <li><a href="#tabs-2">Awards Text</a></li>
            </ul>
            <div id="tabs-1">
                <?php
                    $friendsPoints = get_option('vb_buddy_friends_points');
                    $messagesPoints = get_option('vb_buddy_messages_points');
                    $postsPoints = get_option('vb_buddy_posts_points');
                    $commentsPoints = get_option('vb_buddy_comments_points');
                ?>
              <form action="admin.php?page=vb_buddy_awards_settings&save_points=1" method="post">
                  <table class="buddy_settings_table">
                      <tr>
                          <td class="firstTd">Friendship Points</td>
                          <td><input type="text" name="txtFriendshipPoints" value="<?php echo $friendsPoints;  ?>" disabled/></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Messages Points</td>
                          <td><input type="text" name="txtMessagesPoints" value="<?php echo $messagesPoints; ?>" disabled/></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Stream Post Points</td>
                          <td><input type="text" name="txtPostPoints" value="<?php echo $postsPoints; ?>"disabled /></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Comments Points</td>
                          <td><input type="text" name="txtCommentsPoints" value="<?php echo $commentsPoints; ?>" disabled/></td>
                      </tr>
                      <tr>
                          <td class="firstTd"></td>
                          <td><input type="submit" name="btnSubmitPoints" class="button" value="Save" /></td>
                      </tr>
                  </table>    
              </form>    
            </div>
            <div id="tabs-2">
             <?php
                    $friendsText = get_option('vb_buddy_friends_text');
                    $messagesText = get_option('vb_buddy_messages_text');
                    $postsText = get_option('vb_buddy_posts_text');
                    $commentsText = get_option('vb_buddy_comments_text');
                ?>
              <form action="admin.php?page=vb_buddy_awards_settings&save_text=1" method="post">
                  <table class="buddy_settings_table">
                      <tr>
                          <td class="firstTd">Friendship Text</td>
                          <td><input type="text" name="txtFriendshipText" value="<?php echo $friendsText; ?>" disabled/></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Messages Text</td>
                          <td><input type="text" name="txtMessagesText" value="<?php echo $messagesText; ?>" disabled/></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Stream Post Text</td>
                          <td><input type="text" name="txtPostText" value="<?php echo $postsText; ?>"disabled /></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Comments Text</td>
                          <td><input type="text" name="txtCommentsText" value="<?php echo $commentsText; ?>"disabled /></td>
                      </tr>
                      <tr>
                          <td class="firstTd"></td>
                          <td><input type="submit" name="btnSubmitPoints" class="button" value="Save" /></td>
                      </tr>
                  </table>    
              </form>    
            </div>
      </div>
    </div>
</div>
<?php } ?>