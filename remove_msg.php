<?php 
 
 session_start();

 $text_msg=file_get_contents('chat.txt');

 $id_msg=$_POST['id_msg_chat'];
 $username_ch=$_POST['username_ch'];
 $user_se=$_SESSION['user'];
 
 $find_id_to=substr($text_msg,strpos($text_msg,$id_msg));
 $le_fr_id_to_endmsg=strlen(substr($find_id_to,0,strpos($find_id_to,':')));

 $len_f_n_user=strlen($user_se.'_to_'.$username_ch.'-'.$user_se.'>');

 $full_length_u_ch=$len_f_n_user+$le_fr_id_to_endmsg+1;

 $st_pi_f_msg=strpos($text_msg,$id_msg)-$len_f_n_user;

 $remove_msg_ch=str_replace(substr($text_msg,$st_pi_f_msg,$full_length_u_ch),'',$text_msg);

 file_put_contents('chat.txt',$remove_msg_ch);
?>