<!DOCTYPE html>
<html>
<head>
<style type="text/css">
.inputs span {
    font-size: 13px;
    font-weight: 600;
    color: #9e9e9e
}
.inputs input {
    height: 48px;
    border: 2px solid #9e9e9e
}	
</style>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
</head>
<body>
	<br>
	<br>
  <?php include 'navbar.php'; ?>
  <div class="container">
  	<div class="row height d-flex justify-content-center align-items-center">
  	 <div class="col-md-8">
  	  <?php 
       $t_users=file_get_contents('users.txt');
       
       $usrename_sess='{'.$_SESSION['user'].'}';
       $from_user_to=strlen($usrename_sess)+6;

       $ch_find_po_username_sess=strpos($t_users,$usrename_sess)+$from_user_to;
       $text_this_username=substr($t_users,$ch_find_po_username_sess);

       //fetch_name_img

       $to_name_image=substr($text_this_username,strpos($text_this_username,';')+5);
       $name_image=substr($to_name_image,0,strpos($to_name_image,';'));

       if ($name_image == "") 
       {
        $img_profile='profile.jpg';
       }else{
        $img_profile=$name_image;
       }
  	  ?>
  	  <br>
  	 <div id="alert">
  	  	
  	 </div>
     <form method="post" enctype="multipart/form-data">
  	   <div class="card py-5">
  	    <div class="inputs px-4"> <span class="text-uppercase">UserName</span> 
          <input type="text" name="username" id="username" 
          value="<?php echo $_SESSION['user']?>" class="form-control"> 
		 </div>

	  <div class="row mt-3 g-2">
        <div class="col-md-6">
           <div class="inputs px-4"> 
           	<span class="text-uppercase">Previous Password
            </span> 
            <input type="text" required name="p_password" id="p_password" class="form-control">
        </div>

        </div>
        <div class="col-md-6">
          <div class="inputs px-4"> <span class="text-uppercase">new password</span><input type="text" name="n_password" id="n_password" class="form-control"> </div>
        </div>
       </div>

      <div class="mt-3 px-4"> 
      	<span class="text-uppercase name">Profile Picture</span>
        <div class="d-flex flex-row align-items-center mt-2"> 
           <img src="Profile_Picture/<?php echo $img_profile?>" id="img_us" width="110" class="rounded">
           <div class="ml-3"><input type="file" name="img_profile" id="img_profile"></div>
        </div>
     </div>
     <br>

       <div class="mt-3 px-4 d-flex justify-content-between align-items-center">
         <input type="submit" class="btn btn-primary" value="Update" name="click">
	   </div> 
		     
  	 </div>
   </form>
   </div>
 </div>
  </div>
  <?php 
    if (isset($_POST['click'])) 
    {
      $password_po=strpos($text_this_username,';');
      $p_password=substr($text_this_username,0,strpos($text_this_username,';'));
      
      $alert="";
      $n_password="";
      if (password_verify($_POST['p_password'],$p_password)) 
      {
       
       if (empty($_POST['n_password'])) 
       {
       	 $start=$ch_find_po_username_sess+$password_po+1;
       	 $end_w_p=0;
       }else{
         $start=$ch_find_po_username_sess;
         $end_w_p=strlen($p_password)+1;
         $n_password.=password_hash($_POST['n_password'],PASSWORD_DEFAULT).';';
         $alert.='<div class="alert alert-success">Password changed</div>';
       }
       
       $target_dir='Profile_Picture/';
       $target_file=$target_dir.$_SESSION['user'].$_FILES['img_profile']['name'];
       $FileType=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

       $types=['png','jpg'];

       $FILE_IMG='';
       $end_w_img=0;
       if (!empty($_FILES['img_profile']['name'])) 
       {
       	 if (in_array($FileType,$types)) 
       	 {             
             if ($name_image != "") 
             {
             	 unlink('Profile_Picture/'.$name_image);
             	 $end_w_img=5+strlen($name_image);
             }

       	   	 move_uploaded_file($_FILES['img_profile']['tmp_name'],$target_file);

             $FILE_IMG='img='.$_SESSION['user'].$_FILES['img_profile']['name'].';';

             $alert.='<div class="alert alert-success">The image has been successfully updated</div>';

          ?>
           <script type="text/javascript">
           	 var n_image_user='<?php echo $target_dir.$_SESSION['user'].$_FILES['img_profile']['name']?>';

           	 $('#img_us').attr('src',n_image_user);
           </script>
         <?php

       	 }else{
       	 	$alert.='<div class="alert alert-danger">Please select a valid image file</div>';
       	 }
       }

       $text_val_n_insert=$n_password.$FILE_IMG;
       $end=$end_w_p+$end_w_img;

       $username_p='{'.$_POST['username'].'}';

       $ch_po_find_username=strpos($t_users,$username_p);
       
       $ch_su_us='';
       if ($_POST['username'] != "") 
       {
       	 if (!preg_match('/[\';:^£$%&*()}{@#~?><>,|=_+¬-]/',$_POST['username'])) 
       	 {
       	 	if (strlen($_POST['username']) > 5) 
       	 	{
       	 		if ($_SESSION['user'] != $_POST['username']) 
       	 		 {
       	 		 	if (!empty($ch_po_find_username)) 
       	 		 	{
       	 		 	  $alert.='<div class="alert alert-danger">This username belongs to someone else</div>';
       	 		 	}else{

       	 		 		$_SESSION['user']=$_POST['username'];
       	 		 		$ch_su_us='yes';
       	 		 		$alert.='<div class="alert alert-success">Username has changed</div>';
                        
               ?>
               <script type="text/javascript">
	              $("#username").val('<?php echo $_POST['username'];?>');
               </script>
              <?php
       	 		 	}
       	 		 } 

       	 	}else{
       	 		$alert.='<div class="alert alert-warning">Please add more than 5 characters in the username field</div>';
       	 	}
       	 }else{
       	 	$alert.='<div class="alert alert-danger">Please do not enter special characters in the username field</div>';
       	 }
       }else{
       	$alert.='<div class="alert alert-danger">Please add something in the username field</div>';
       }

       $update_n_t=substr_replace($t_users,$text_val_n_insert,$start,$end);

       if ($ch_su_us == 'yes') 
       {
         $update_n_t=str_replace($usrename_sess,$username_p,$update_n_t);
       }

       file_put_contents('users.txt',$update_n_t);


      }else{
      	$alert.='<div class="alert alert-warning">The previous password is incorrect</div>';
      }
    
    }
  ?>
  <script type="text/javascript">
  	$("#alert").html('<?php echo $alert;?>')
  </script>
</body>
</html>