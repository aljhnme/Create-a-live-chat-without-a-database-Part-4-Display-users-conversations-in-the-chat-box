<!DOCTYPE html>
<html> 
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style_ch_list.css">
</head>
<body style="background:#E4E4E4;">
	<br>
	<br>
 <?php include 'navbar.php'; ?>
 <!--box chat-->
 <div class="col-md-12 col-lg-6" style="left:200px;">
     <div class="panel box_ch" style="width:380px;display:none;">
 
      <div class="panel-heading">
         <div class="panel-control">
           <div class="btn-group">
             <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#demo-chat-body"><i class="fa fa-chevron-down"></i></button>
             <button type="button" class="btn btn-default"><i class="fa fa-gear"></i></button>
           </div>
        </div>
        <h3 class="panel-title"></h3>
     </div>
    
       <div id="demo-chat-body" class="collapse in">

         <div class="nano has-scrollbar" style="height:380px">
           <div class="nano-content pad-all" tabindex="0" style="right: -17px;">
             <ul class="list-unstyled media-block msgm">

             </ul>
           </div>
            <div class="nano-pane">
             	<div class="nano-slider" style="height: 141px; transform: translate(0px, 0px);"></div>
            </div>
         </div>

            <div class="panel-footer">
              <div class="row">
                <div class="col-xs-9">
                 <input type="text" placeholder="Enter your text" class="form-control chat-input">
                </div>
                <div class="col-xs-3">
                  <button class="insert_msg btn btn-primary btn-block" type="submit">Send</button></div>
              </div>
            </div>
          <input type="hidden" id="username_ch">

       </div>
     </div>
 </div>

 <div class="container">
 	<div class="row">
 	  <div class="col-xs-12 col-sm-offset-3 col-sm-6" style="right:145px;">
 	  	<div class="panel panel-default" style="width:350px;">
 	  	  <div class="panel-heading c-list">
            <span class="title">Contacts</span> 	  	  	
 	  	  </div>
 	  	   <ul class="list-group">
 	  	   	 <?php 
               
               $t_users=file_get_contents('users.txt');
               $c_s_t=str_replace(array('(',')'),'',$t_users);

               $users=explode(':',$c_s_t);

               for ($i=0; $i < count($users)-1; $i++) 
               { 
               	 $da_user=str_replace(array('id=','user=','pass=','img='),'',$users[$i]);
                 $val_d_user=explode(';',$da_user);

                 $id_user=$val_d_user[0];
                 $username=preg_replace('/[^A-Za-z0-9\-]/','',$val_d_user[1]);
                 $img_profile=$val_d_user[3];
                 
                 if ($img_profile != "") 
                 {
                 	$image_profile=$img_profile; 
                 }else{
                    $image_profile='profile.jpg';
                 }
                 
                 //Ban my account from showing up
                 if ($_SESSION['user'] != $username) 
                 {
                 ?>
                  <li class="list-group-item">
                   <div class="col-xs-12 col-sm-3">
                     <img src="Profile_Picture/<?php echo $image_profile?>" alt="<?php echo $username?>" style="width:60px;height:60px;border-radius:50%;" />
                   </div>

                  <div class="col-xs-12 col-sm-9">
                   <span class="name"><?php echo $username; ?></span><br/>
                     <span id="display_box" data-username="<?php echo $username;?>" class="fa fa-comments text-muted c-info"></span>
                  </div>
                   <div class="clearfix"></div>
                </li>
               <?php
                 }
                }
 	  	   	   ?>
 	  	   </ul>
 	  	</div>
 	  </div>
 	</div>
 </div>
</body>
<script type="text/javascript">

	var user_clicking_chat;
	$(document).on('click','#display_box',function(){

       $(".msgm").html('');
        var username=$(this).data('username');
        $(".panel-title").text(username);
        user_clicking_chat=username;
        
        $("#username_ch").val(username);

        $(".insert_msg").attr('id',username);
        if ($(".box_ch").is(":hidden")) 
        {
          $(".box_ch").show();
        }

	});

	$(document).on('click','.insert_msg',function(){
            
          var msg=$(".chat-input").val();
          var us_chat=$(this).attr('id');

          if (msg.trim() != "") 
            {
               $.ajax({
                  url:"insert_msg.php",
                  method:"post",
                  data:{msg:msg,us_chat:us_chat},
                  success:function(data)
                  {
                    $(".chat-input").val('');
                  }
               });
            }

	});

	setInterval(function(){
      
       if (typeof user_clicking_chat != 'undefined') 
       { 
       	 var c_msg_box_chat=$(".msgm").children('li').length;
         
          $.ajax({
              url:"msgs_ch_us.php",
              type:"post",
              data:{user_clicking_chat:user_clicking_chat,c_msg_box_chat:c_msg_box_chat},
              success:function(data)
              {
              	if (data != "") 
              	{
                 $(".msgm").html(data);
                 $(".nano-content").scrollTop($(".nano-content")[0].scrollHeight);
              	}
              }
          });
       }
	},1000);

	$(document).on('click','.remove_msg',function(){
      
         var id_msg_chat=$(this).data('id_ch');
         var username_ch=$("#username_ch").val();

         $.ajax({
            url:"remove_msg.php",
            type:"post",
            data:{id_msg_chat:id_msg_chat,username_ch:username_ch},
            success:function(data)
            {
              $(".h_msg_sess"+id_msg_chat).remove();
            }
         });
	});
</script>
</html>