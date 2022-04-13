<?php 
  session_start();
  $us_se=$_SESSION['user'];
  $special_Character=array("'",'"',';','>','<','_','-',':');
  //The message is encrypted
  $msg=str_rot13(str_replace($special_Character,'',$_POST['msg']));

  $msg_us=$us_se.'_to_'.$_POST['us_chat'].'-'.$us_se.'>'.rand().';'.$msg.':';

  file_put_contents('chat.txt',$msg_us,FILE_APPEND);
?>