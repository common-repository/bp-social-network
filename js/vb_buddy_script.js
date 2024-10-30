jQuery(function(){
    
    jQuery('#vb_opener_messages').click(function(){
        jQuery('.vb_open_friends').hide();
        jQuery('.vb_open_notifications').hide();
        jQuery('.vb_open_login').hide();
        jQuery('.vb_open_loggedIn').hide();
        
        jQuery('.vb_open_messages').slideToggle(250,'linear');
    });
    
    jQuery('#vb_buddy_like_box_opener').click(function(){
       jQuery('.vb_buddy_like_box_open').slideToggle(250,'linear');
    });
    
    jQuery('#vb_opener_notification').click(function(){
        
        jQuery('.vb_open_friends').hide();
        jQuery('.vb_open_messages').hide();
        jQuery('.vb_open_login').hide();
        jQuery('.vb_open_loggedIn').hide();
        
        jQuery('.vb_open_notifications').slideToggle(250,'linear');
    });
    
    
	jQuery('#vb_opener_login').click(function(){
        
        jQuery('.vb_open_friends').hide();
        jQuery('.vb_open_messages').hide();
        jQuery('.vb_open_notifications').hide();
        
        jQuery('.vb_open_login').slideToggle(250,'linear');
        jQuery('.vb_open_loggedIn').slideToggle(250,'linear');
    });
    
    
    jQuery('#vb_opener_friends').click(function(){
        
        jQuery('.vb_open_loggedIn').hide();
        jQuery('.vb_open_messages').hide();
        jQuery('.vb_open_notifications').hide();
        jQuery('.vb_open_login').hide();
        
        jQuery('.vb_open_friends').slideToggle(250,'linear');
    });
    
    jQuery('.vb_buddy_scroll_up').click(function(){
        jQuery('html, body').animate({ scrollTop: 0}, 500);
     });
    
    jQuery('#open_message_dialog').click(function(){
        var opt = {
        autoOpen: false,
        modal: true,
        width: 500,
        height:300,
        title: 'New Message',
        position: ['center',200]
	};
       var theDialog = jQuery('.send_message_dialog').dialog(opt);
       theDialog.dialog("open");
    });
    
    jQuery("#vb_buddy_receiver_name").live("keyup", function(event) 
	{
		
                var ReceiverName = jQuery('#vb_buddy_receiver_name').val();	
		var Data = "ReceiverName="+ReceiverName;
		if(ReceiverName.length >=3)
		{			
			var data = { action: 'vb_buddy_load_users', recname: ReceiverName };
                        jQuery.post(ajaxurl, data, function(response) {
                                //alert('Got this from the server: ' + response);
                                jQuery("#UserFetchBox").html(response).show();
                        });
			
		}
	});
        
        jQuery(".FetchedUserDiv").live("click",function(){
            
            var username = jQuery(this).children('.UserInfo').children('h1').attr('id');
            jQuery("#vb_buddy_receiver_name").val(username);
            jQuery("#UserFetchBox").hide();
            jQuery("#UserFetchBox").empty();
        });
        
        jQuery('#btnSendMessage').click(function(){
            
            
            
            if(jQuery('#vb_buddy_receiver_name').val() != '' && jQuery('#vb_buddy_message_subject_input').val() != '' && jQuery('#vb_buddy_message_area').val() != '')
                {
                     jQuery('.vb_buddy_message_notify').html('Sending Message ...');
                     jQuery('.vb_buddy_message_notify').css('color','#13B31A');
                     
                     var sendTo = jQuery('#vb_buddy_receiver_name').val();
                     var sendSub = jQuery('#vb_buddy_message_subject_input').val();
                     var sendMsg = jQuery('#vb_buddy_message_area').val();
                     
                     var dataMessage = { action: 'vb_buddy_send_message', to: sendTo, subject: sendSub, message: sendMsg };
                        jQuery.post(ajaxurl, dataMessage, function(responseMessage) {
                                //alert('Got this from the server: ' + response);
                                jQuery('.vb_buddy_message_notify').html(responseMessage);
                                jQuery('.vb_buddy_message_notify').css('color','green');								                                jQuery('.send_message_dialog').dialog("close");
                        });
                }
            else
                {
                     jQuery('.vb_buddy_message_notify').html('Please fill all the fields');
                     jQuery('.vb_buddy_message_notify').css('color','red');
                }
        });
        
        
        jQuery( "#tabs" ).tabs();
        
        jQuery('.vb_notification').click(function(){
           		   jQuery(this).css('background','white');	
				   
				   var countBefore = jQuery('#vb_opener_notification .jewelCount #livenotifications_num_notifications').html();
				   var countAfter = --countBefore;
				   if(countAfter > -1)
				   {
					jQuery('#vb_opener_notification .jewelCount #livenotifications_num_notifications').html(countAfter);	
				   }
				   var award_id = jQuery(this).attr('id').substring(11);		   	
           
           var data = { action: 'vb_buddy_read_notify', ardId: award_id};
                      					  jQuery.post(ajaxurl, data, function(response) { });
        });
        		jQuery('body').click(function(){			jQuery('.vb_open_friends').hide();			jQuery('.vb_open_notifications').hide();			jQuery('.vb_open_login').hide();			jQuery('.vb_open_loggedIn').hide();			jQuery('.vb_open_messages').hide();			jQuery('.vb_buddy_like_box_open').hide();		});				jQuery('.vb_buddy_floating_strip').click(function(event){		   event.stopPropagation();		});		
    
});

