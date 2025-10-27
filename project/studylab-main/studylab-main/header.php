<?php
	function active($currect_page){
	  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ; // current page url
	  $url = end($url_array);  
	  if($currect_page == $url){
		  echo 'active'; //class name in css 
	  } 
	}
	?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>StudyLab - Free Bootstrap 4 Template by Colorlib</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="css/animate.css">
  
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">

  
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
 <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
   <div class="container">
     <a class="navbar-brand" href="index.php"><span>Study</span>Lab</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
       <span class="oi oi-menu"></span> Menu
     </button>

     <li class="<?php active('index.php')?>"><a href="./index.php">Home</a></li>
                            <li class="<?php active('about.php')?>"><a href="./about.php">About</a></li>
                            <li class="<?php active('course.php')?>"><a href="./course.php">course</a></li>
                            
                                    <li class="<?php active('instructor.php')?>"><a href="./instructor.php">instructor</a></li>
                                </ul>
                            </li>
                            <li class="<?php active('blog.php')?>"><a href="./blog.php">Blog</a></li>
                            <li class="<?php active('contact.php')?>"><a href="./contact.php">Contact</a></li>
                        </ul>
                    </nav>


     </div>
   </div>
 </nav>
 <!-- END nav -->