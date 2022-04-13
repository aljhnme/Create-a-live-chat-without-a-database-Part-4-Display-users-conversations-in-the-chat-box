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
	<link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
  <form class="formoid-metro-cyan form_l" method="post" style="font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;">
    <div class="title">
 	  <h2><strong>Login</strong></h2>
 	</div>
    <div id="alert">
    	
    </div>

    <div class="element-input">
	 <label class="title">
			username<span class="required">*</span>
	 </label>
     <input class="large" type="text" name="username" required="required"/>
	</div>

	<div class="element-input">
		<label class="title">
			password<span class="required">*</span>
		</label>
		<input class="large" type="text" name="password" required="required"/>
	</div>	

    <div class="submit">
    	<a class="btn btn-primary" href="register.php" role="button">Register</a>
    	<input type="submit" value="Login" name="click_l" />
    </div>	

  </form>
</body>
<?php
 
 $users_t=file_get_contents('users.txt');

 if (isset($_POST['click_l'])) 
 {
   if (strlen($_POST['username']) > 5) 
   {
   	 $username='{'.$_POST['username'].'}';
   	 $ch_find_username=strpos($users_t,$username);

   	 if (!empty($ch_find_username)) 
   	 {
   	 	 $length_username_oth=strlen($username)+6;
   	 	 $get_pass_this_account=substr($users_t,$ch_find_username+$length_username_oth);
         $password=substr($get_pass_this_account,0,strpos($get_pass_this_account,';'));

         if (password_verify($_POST['password'],$password)) 
         {
         	$alert='<div class="alert alert-success">Successful login</div>';
         	$_SESSION['user']=$_POST['username'];
         	header('location:index.php');

         }else{
         	$alert='<div class="alert alert-warning">wrong password</div>';
         }

   	 }else{
   	 	$alert='<div class="alert alert-warning">This username does not exist</div>';
   	 }
   }else{
   	$alert='<div class="alert alert-warning">Please add more than 5 characters</div>';
   }
 }
?>
<script type="text/javascript">
	$("#alert").html('<?php echo $alert ?>');
</script>
</html>