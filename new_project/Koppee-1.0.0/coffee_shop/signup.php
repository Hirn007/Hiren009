<?php
	include_once('header.php');
	?>

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            
            
            <div class="row">
                
                <div class=" offset-lg-2 col-lg-8">
					 <h3 align="center" class="mb-5">Signup In Here</h3>
                    <div class="">
                        <form action="signup" method="post"  enctype="multipart/form-data">
                            <div class="row">
								
                                <div class="col-lg-12 m-2">
                                    <input type="text" class="form-control"  name="email" placeholder="Email" required>
                                </div>
								<div class="col-lg-12 m-2">
                                    <input type="password" class="form-control"  name="password" placeholder="Password" required>
                                </div>
					
                                <button type="submit" name="signup" class="btn btn-lg btn-block">signup</button>
                                    <a href="login">If you already Registred Then Login Here </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
<?php
   include_once('footer.php');
   ?>