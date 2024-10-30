<?php
    if(isset($_GET['save_notify']))
    {
        update_option('vb_buddy_isModeration', $_POST['chkIsModeration']);
        update_option('vb_buddy_isFriends', $_POST['chkIsFriends']);
        update_option('vb_buddy_isMessages', $_POST['chkIsMessages']);
        update_option('vb_buddy_isGeneral', $_POST['chkIsGeneral']);
        ?>
        <script>
            window.location = "admin.php?page=vb_buddy_settings";
        </script>
        <?php
        exit;
        
    }
    elseif(isset($_GET['save_user_drop']))
    {   
        update_option('vb_buddy_linkPersonal', $_POST['chkLinkPersonal']);
        update_option('vb_buddy_linkPost', $_POST['chkLinkPost']);
        update_option('vb_buddy_linkAvatar', $_POST['chkLinkAvatar']);
        update_option('vb_buddy_linkMessage', $_POST['chkLinkMessage']);
        update_option('vb_buddy_linkPassword', $_POST['chkLinkPassword']);
        update_option('vb_buddy_linkNotify', $_POST['chkLinkNotify']);
        update_option('vb_buddy_linkGeneral', $_POST['chkLinkGeneral']);
        update_option('vb_buddy_linkFriends', $_POST['chkLinkFriends']);
        ?>
        <script>
            window.location = "admin.php?page=vb_buddy_settings";
        </script>
        <?php
        exit;
    }
    elseif(isset($_GET['save_general']))
    {
        update_option('vb_buddy_scroll_arrow', $_POST['ddlScrollingArrow']);
        update_option('vb_buddy_awards_url', $_POST['txtAwardsPageUrl']);
        update_option('vb_buddy_is_points', $_POST['chkIsPoints']);				update_option('vb_buddy_notify_length', $_POST['txtNotifyLength']);
        
         ?>
        <script>
            window.location = "admin.php?page=vb_buddy_settings";
        </script>
        <?php
        exit;
    }
    elseif(isset($_GET['save_social']))
    {
        update_option('vb_buddy_facebook_like', $_POST['chkFacebookLike']);
        update_option('vb_buddy_facebook_like_style', $_POST['ddlFacebookStyle']);
        
        update_option('vb_buddy_twitter_like', $_POST['chkTwitterLike']);
        update_option('vb_buddy_twitter_like_style', $_POST['ddlTwitterStyle']);
        
        update_option('vb_buddy_google_like', $_POST['chkGoogleLike']);
        update_option('vb_buddy_google_like_style', $_POST['ddlGoogleStyle']);
        
        ?>
        <script>
            window.location = "admin.php?page=vb_buddy_settings";
        </script>
        <?php
        exit;
    }
    else
    {
?>
        <style type="text/css">
        .redlight {
	color: #F00;
}
        </style>
        
<div class="wrap">
    
    <div class="welcome-panel" style="padding-bottom: 9px;">
        <img style="float: left; height: 48px; margin-right: 10px;" src="<?php echo plugins_url('../../images/med_logo.png',__FILE__); ?>" />
        <h2>vBSocial BuddyPress Social Network Settings</h2>
        <h4> <span class="redlight">Unlock </span>all the features, in the <a href="http://vbsocial.com/buddypress-social-network/">Premium version, </a>including Private Messages, Friend Requests, User Awards, and Social Settings. <a href="Read more...">Buy Now!</a> |  <a href="http://vbsocial.com/buddypress-social-network/">Read More</a></h4>
<p></p>
        <div id="tabs">
            <ul>
              <li><a href="#tabs-1">Notifications Settings</a></li>
              <li><a href="#tabs-2">User Dropdown links</a></li>
              <li><a href="#tabs-3">General Settings</a></li>
              <li><a href="#tabs-4">Social Settings</a></li>
            </ul>
            <div id="tabs-1">
                <?php
                    $isModeration = get_option('vb_buddy_isModeration');
                    $isFriends = get_option('vb_buddy_isFriends');
                    $isMessages = get_option('vb_buddy_isMessages');
                    $isGeneral = get_option('vb_buddy_isGeneral');
                    
                    $chkedModeration = $isModeration == 'on' ? 'checked=checked' : '';
                    $chkedFriends = $isFriends == 'on' ? 'checked=checked' : '';
                    $chkedMessages = $isMessages == 'on' ? 'checked=checked' : '';
                    $chkedGeneral = $isGeneral == 'on' ? 'checked=checked' : '';
                    
                ?>
              <form action="admin.php?page=vb_buddy_settings&save_notify=1" method="post">
                  <table class="buddy_settings_table">
                      <tr>
                          <td class="firstTd">Moderation Notifications</td>
                          <td><input type="checkbox" name="chkIsModeration" <?php echo $chkedModeration; ?> /></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Friends Notifications</td>
                          <td><input type="checkbox" name="chkIsFriends" <?php echo $chkedFriends; ?> disabled />
                          <a href="http://vbsocial.com/buy-wordpress-plugins/">Unlock Now</a></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Messages Notifications</td>
                          <td><input type="checkbox" name="chkIsMessages" <?php echo $chkedMessages; ?> disabled /> <a href="http://vbsocial.com/buy-wordpress-plugins/">Unlock Now</a></td>
                      </tr>
                      <tr>
                          <td class="firstTd">General Notifications</td>
                          <td><input type="checkbox" name="chkIsGeneral" <?php echo $chkedGeneral; ?> /></td>
                      </tr>
                      <tr>
                          <td class="firstTd"></td>
                          <td><input type="submit" name="btnSubmitNotify" class="button" value="Save" /></td>
                      </tr>
                  </table>    
              </form>    
            </div>
            <div id="tabs-2">
              <?php
                $linkPersonal = get_option('vb_buddy_linkPersonal');
                $linkPost = get_option('vb_buddy_linkPost');
                $linkAvatar = get_option('vb_buddy_linkAvatar');
                $linkMessage = get_option('vb_buddy_linkMessage');
                $linkPassword = get_option('vb_buddy_linkPassword');
                $linkNotify = get_option('vb_buddy_linkNotify');
                $linkGeneral = get_option('vb_buddy_linkGeneral');
                $linkFriends = get_option('vb_buddy_linkFriends');
                
                $chkedLinkPersonal = $linkPersonal == 'on' ? 'checked=checked' : '';
                $chkedLinkPost = $linkPost == 'on' ? 'checked=checked' : '';
                $chkedLinkAvatar = $linkAvatar == 'on' ? 'checked=checked' : '';
                $chkedLinkMessage = $linkMessage == 'on' ? 'checked=checked' : '';
                $chkedLinkPassword = $linkPassword == 'on' ? 'checked=checked' : '';
                $chkedLinkNotify = $linkNotify == 'on' ? 'checked=checked' : '';
                $chkedLinkGeneral = $linkGeneral == 'on' ? 'checked=checked' : '';
                $chkedLinkFriends = $linkFriends == 'on' ? 'checked=checked' : '';
                
                
              ?>
              <form action="admin.php?page=vb_buddy_settings&save_user_drop=1" method="post">
                  <table class="buddy_settings_table">
                      <tr>
                          <td class="firstTd">Personal Details</td>
                          <td><input type="checkbox" name="chkLinkPersonal" <?php echo $chkedLinkPersonal; ?> /></td>
                          
                          <td class="firstTd">Latest Posts</td>
                          <td><input type="checkbox" name="chkLinkPost" <?php echo $chkedLinkPost; ?> /></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Edit Avatar</td>
                          <td><input type="checkbox" name="chkLinkAvatar" <?php echo $chkedLinkAvatar; ?> /></td>
                          
                          <td class="firstTd">Latest Messgages</td>
                          <td><input type="checkbox" name="chkLinkMessage" <?php echo $chkedLinkMessage; ?> /></td>
                      </tr>
                      <tr>
                          <td class="firstTd">Email & Password</td>
                          <td><input type="checkbox" name="chkLinkPassword" <?php echo $chkedLinkPassword; ?> /></td>
                          
                          <td class="firstTd">Your Notification</td>
                          <td><input type="checkbox" name="chkLinkNotify" <?php echo $chkedLinkNotify; ?> /></td>
                      </tr>
                      <tr>
                          <td class="firstTd">General Settings</td>
                          <td><input type="checkbox" name="chkLinkGeneral" <?php echo $chkedLinkGeneral; ?> /></td>
                          
                          <td class="firstTd">People your ignore</td>
                          <td><input type="checkbox" name="chkLinkFriends" <?php echo $chkedLinkFriends; ?> /></td>
                      </tr>
                       <tr>
                          <td class="firstTd"></td>
                          <td></td>
                          
                          <td class="firstTd"></td>
                          <td><input type="submit" name="btnSubmitUserDrop" class="button" value="Save" /></td>
                      </tr>
                      
                  </table>    
              </form>
            </div>
            <div id="tabs-3">
              <?php 
                $ddlScrollArrow = get_option('vb_buddy_scroll_arrow');
                $awardPageUrl = get_option('vb_buddy_awards_url');								$notifyLength =  get_option('vb_buddy_notify_length');
                $isPoints = get_option('vb_buddy_is_points');
                $checkIsPoints = $isPoints == 'on' ? 'checked=checked' : '';
                
              ?>
              <form action="admin.php?page=vb_buddy_settings&save_general=1" method="post">
                  <table class="buddy_settings_table">
                      <tr>
                          <td class="firstTd">Scrolling Arrow</td>
                          <td>
                              <select name="ddlScrollingArrow">
                                  <option value="double-angle-up" <?php if($ddlScrollArrow == 'double-angle-up'){ echo 'selected=selected'; }?> >Default</option>
                                  <option value="angle-up" <?php if($ddlScrollArrow == 'angle-up'){ echo 'selected=selected'; }?>>Angle Up</option>
                                  <option value="caret-up" <?php if($ddlScrollArrow == 'caret-up'){ echo 'selected=selected'; }?>>Caret Up</option>
                                  <option value="arrow-up" <?php if($ddlScrollArrow == 'arrow-up'){ echo 'selected=selected'; }?>>Arrow Up</option>
                                  <option value="chevron-up" <?php if($ddlScrollArrow == 'chevron-up'){ echo 'selected=selected'; }?>>Chevron Up</option>
                              </select>
                          </td>
                      </tr>
                      
                      <tr>
                          <td class="firstTd">Awards Page Link</td>
                          <td><input type="text" name="txtAwardsPageUrl" value="<?php echo $awardPageUrl; ?>" readonly/>
                          <a href="http://vbsocial.com/buy-wordpress-plugins/">Unlock Now</a></td>
                      </tr>
                      
                      <tr>
                          <td class="firstTd">Points</td>
                          <td><input type="checkbox" name="chkIsPoints" <?php echo $checkIsPoints; ?> disabled /><a href="http://vbsocial.com/buy-wordpress-plugins/">Unlock Now</a></td>
                      </tr>					  <tr>
                          <td class="firstTd">Notifications Limit</td>
                          <td><input type="text" name="txtNotifyLength" value="<?php echo $notifyLength; ?>" /></td>
                      </tr>
                      
                      <tr>
                          <td class="firstTd"></td>
                          <td><input type="submit" name="btnSaveGeneralSet" class="button" value="Save" /></td>
                      </tr>
                  </table>  
               </form>
            </div>
            <div id="tabs-4">
                <?php
                    $facebookLike = get_option('vb_buddy_facebook_like');
                    $facebookLikeStyle = get_option('vb_buddy_facebook_like_style');
                    $chkedFacebookLike = $facebookLike == 'on' ? 'checked=checked' : '';
                    
                    $twitterLike = get_option('vb_buddy_twitter_like');
                    $twitterLikeStyle = get_option('vb_buddy_twitter_like_style');
                    $chkedTwitterLike = $twitterLike == 'on' ? 'checked=checked' : '';
                    
                    $googleLike = get_option('vb_buddy_google_like');
                    $googleLikeStyle = get_option('vb_buddy_google_like_style');
                    $chkedGoolgeLike = $googleLike == 'on' ? 'checked=checked' : '';
                ?>
              <form action="admin.php?page=vb_buddy_settings&save_social=1" method="post">
                  <table class="buddy_settings_table">
                      <tr>
                          <td class="firstTd">Facebook</td>
                          <td><input type="checkbox" name="chkFacebookLike" <?php echo $chkedFacebookLike; ?> /></td>
                          <td class="firstTd">Facebook Style</td>
                          <td>
                              <select name="ddlFacebookStyle">
                                  <option <?php if($facebookLikeStyle == 'standard') { echo 'selected=selected';}?>>standard</option>
                                  <option <?php if($facebookLikeStyle == 'box_count') { echo 'selected=selected';}?>>box_count</option>
                                  <option <?php if($facebookLikeStyle == 'button_count') { echo 'selected=selected';}?>>button_count</option>
                                  <option <?php if($facebookLikeStyle == 'button') { echo 'selected=selected';}?>>button</option>
                              </select>
                          </td>
                      </tr>
                      <tr>
                          <td class="firstTd">Twitter (<a href="http://vbsocial.com/buy-wordpress-plugins/">Locked</a>)</td>
                          <td><input type="checkbox" name="chkTwitterLike" <?php echo $chkedTwitterLike; ?> disabled/></td>
                          <td class="firstTd">Twitter Style</td>
                          <td>
                              <select name="ddlTwitterStyle">
                                  <option <?php if($twitterLikeStyle == 'none') { echo 'selected=selected';}?>>Locked</option>
                                  <option <?php if($twitterLikeStyle == 'horiztontal') { echo 'selected=selected';}?>>Locked</option>
                                  <option <?php if($twitterLikeStyle == 'vertical') { echo 'selected=selected';}?>>Locked</option>
                              </select>
                          </td>
                      </tr>
                      
                      <tr>
                          <td class="firstTd">Google (<a href="http://vbsocial.com/buy-wordpress-plugins/">Locked</a>)</td>
                          <td><input type="checkbox" name="chkGoogleLike" <?php echo $chkedGoolgeLike; ?> disabled/></td>
                          <td class="firstTd">Google Style</td>
                          <td>
                              <select name="ddlGoogleStyle">
                                  <option <?php if($googleLikeStyle == 'standard') { echo 'selected=selected';}?>>Locked</option>
                                  <option <?php if($googleLikeStyle == 'small') { echo 'selected=selected';}?>>Locked</option>
                                  <option <?php if($googleLikeStyle == 'medium') { echo 'selected=selected';}?>>Locked</option>
                                  <option <?php if($googleLikeStyle == 'tall') { echo 'selected=selected';}?>>Locked</option>
                              </select>
                          </td>
                      </tr>
                      
                      <tr>
                          <td class="firstTd"></td>
                          <td></td>
                          <td class="firstTd"></td>
                          <td><input type="submit" name="btnSaveSocialSet" class="button" value="Save" /></td>
                      </tr>
                  </table>  
               </form>
            </div>
      </div>
    </div>
</div>
<?php } ?>