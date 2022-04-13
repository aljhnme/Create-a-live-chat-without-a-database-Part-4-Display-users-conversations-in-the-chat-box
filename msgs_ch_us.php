<?php

 session_start();

 $text_ch_user=file_get_contents('chat.txt');

 $msg_us_session=$_SESSION['user'].'_to_'.$_POST['user_clicking_chat'].'-';

 $us_sent_me_msg=$_POST['user_clicking_chat'].'_to_'.$_SESSION['user'].'-';

 $get_msgs=preg_split('/('.$msg_us_session.'|'.$us_sent_me_msg.')/',$text_ch_user);

 if (count($get_msgs)-1 != $_POST['c_msg_box_chat']){

  for ($i=1; $i < count($get_msgs); $i++) 
   { 
 	$txt_us_msg=$get_msgs[$i];
    $full_msg=substr($txt_us_msg,0,strpos($txt_us_msg,':'));

    $c_to_idch=strpos($full_msg,'>');
    $c_to_msch=strpos($full_msg,';');
    $username_msg=substr($full_msg,0,$c_to_idch);
    
    $length_username=strlen($username_msg);
    
    $id_this_msg_ch=substr($full_msg,$c_to_idch+1,$c_to_msch-$length_username-1);

    $msg=str_rot13(substr($full_msg,strpos($full_msg,';')+1));

    if ($username_msg == $_SESSION['user']) 
    {
      
      $sty_ms='right';
      $button_r_msg='<i class="fa fa-remove remove_msg" data-id_ch="'.$id_this_msg_ch.'" style="font-size:25px"></i>';
    }else{
      $sty_ms='left';
      $button_r_msg='';
    }
   
   ?>
    <li class="mar-btm h_msg_sess<?php echo $id_this_msg_ch;?>"> 
      <div class="media-body pad-hor speech-<?php echo $sty_ms;?>">
        <div class="speech">
           <a href="#" class="media-heading"><?php echo $username_msg;?></a>
            <p class="msg_ch"><?php echo $msg;?></p>
            <?php echo $button_r_msg;?>
        </div>
      </div>
    </li>  
   <?php
    }
   }
   ?>