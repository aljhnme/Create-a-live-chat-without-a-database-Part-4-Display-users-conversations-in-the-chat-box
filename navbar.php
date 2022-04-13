<?php
session_start();
 
if (!isset($_SESSION['user'])) 
{
  header('location:register.php');
}
?>
<div class="container">
  <div class="row">
   <div class="col-lg-10 col-sm-10 col-12 offset-lg-1 offset-sm-1">
    <nav class="navbar navbar-expand-lg bg-info rounded">
     <a class="navbar-brand text-light" href="#">Navbar</a>
     <div class="collapse navbar-collapse" id="navbarSupportedContent" style="display: unset !important;">
        <ul class="nav nav-pills mr-auto justify-content-end">

         <?php
          $current_page_name=basename($_SERVER['PHP_SELF']);

          if ($current_page_name != "index.php") 
          {
         ?>
         <li class="nav-item active">
           <a class="nav-link text-light" href="index.php">index</a>
         </li>
         <?php
          }
         ?>
         <li class="nav-item active">
           <a class="nav-link text-light" href="logout.php">logout</a>
         </li>

         <li class="nav-item active">
           <a class="nav-link text-light" href="profile.php">Profile (<?php echo $_SESSION['user'];?>)</a>
         </li>

         <li class="nav-item">
         </li>
      </ul>
     </div>
    </nav> 
   </div>
  </div>
 </div>



