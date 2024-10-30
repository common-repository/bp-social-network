<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Friendships</a></li>
    <li><a href="#tabs-2">Messages</a></li>
    <li><a href="#tabs-3">Comments</a></li>
    <li><a href="#tabs-4">Stream Posts</a></li>
  </ul>
  <?php 	   $Type = array("Friends", "Messages", "Comments", "Posts");?>
  <div id="tabs-1">
    <ul class="vb_buddy_awards_list_ul">
       <?php  echo GetTotalRewards($Type[0]);?>
    </ul>
  </div>
  <div id="tabs-2">
     <ul class="vb_buddy_awards_list_ul">
       <?php  echo GetTotalRewards($Type[1]);?>
    </ul>
  </div>
  <div id="tabs-3">
     <ul class="vb_buddy_awards_list_ul">
       <?php  echo GetTotalRewards($Type[2]);?>
    </ul>
  </div>
  <div id="tabs-4">
     <ul class="vb_buddy_awards_list_ul">
       <?php  echo GetTotalRewards($Type[3]);?>
    </ul>
  </div>
</div>