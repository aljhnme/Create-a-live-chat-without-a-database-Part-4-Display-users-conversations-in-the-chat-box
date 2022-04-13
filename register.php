<!DOCTYPE html>
<html>
<head>
	 <?php 
      session_start();
      if (isset($_SESSION['user'])) 
      {
      	header('location:index');
      }
	 ?>
	<meta charset="utf-8" />
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
</head>
<body>
 <form class="formoid-metro-cyan form_r" method="post" style="font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;">
  <div class="title">
 	<h2><strong>Register</strong></h2>
 </div>

  <div id="alert">
    	
  </div>
  <div class="element-input">
	 <label class="title">username
	   <span class="required">*</span>
	 </label>
	  <input class="large" type="text" name="username" required="required"/>
  </div>

  <div class="element-input">
	 <label class="title">
			passsword<span class="required">*</span>
	 </label>
	 <input class="large" type="text" name="password" required="required"/>
  </div>
  
  <div class="element-input">
	 <label class="title">
			confirm password<span class="required">*</span>
	 </label>
	 <input class="large" type="text" name="confirm_password" required="required"/>
  </div>

   <div class="submit">
    <a class="btn btn-primary" href="login.php" role="button">login</a>
	  <input type="submit" value="register" name="click" />
   </div>	
</form>
</body>
<?php 
 
 $users_t=file_get_contents('users.txt');

 if (isset($_POST['click'])) 
 {
 	$username='{'.$_POST['username'].'}';
 	$ch_find_username=strpos($users_t,$username);

 	if (!preg_match('/[\';:^£$%&*()}{@#~?><>,|=_+¬-]/',$_POST['username'])) 
 	{
 	  if (empty($ch_find_username)) 
 	  {
 	  	 if (strlen($_POST['username']) > 5) 
 	  	 {
 	  	 	if ($_POST['password'] == $_POST['confirm_password']) 
 	  	 	{
 	  	 	 
 	  	 	 $id_user=rand();
 	  	 	 $pass=password_hash($_POST['password'], PASSWORD_DEFAULT);

 	  	 	 $user_in_t='(id='.$id_user.';user='.$username.';pass='.$pass.';):';

 	  	 	 file_put_contents('users.txt',$user_in_t,FILE_APPEND);
             
             $alert='<div class="alert alert-success">successfully registered</div>';
             
             header('location:login.php');
 	  	 	}else{
 	  	 		$alert='<div class="alert alert-warning">password does not match</div>';
 	  	 	}
 	  	 }else{
 	  	 	$alert='<div class="alert alert-warning">Please add more than 5 characters</div>';
 	  	 }
 	  }else{
 	  	$alert='<div class="alert alert-danger">This username is already in use</div>';
 	  }
 	}else{
 	  $alert='<div class="alert alert-danger">It is not possible to add special characters</div>';
 	}
 }
?>
<script type="text/javascript">
	$("#alert").html('<?php echo $alert ?>');
</script>
</html>