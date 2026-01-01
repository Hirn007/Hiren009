<?php
include_once('header.php');
?>

<!-- Signup Form Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="p-5 bg-dark rounded mb-5" style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);">
                    <h2 class="text-center mb-4" style="color: #C8A882; letter-spacing: 2px;">SIGN UP</h2>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-exclamation-circle mr-2"></i><?php echo htmlspecialchars($error); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle mr-2"></i><?php echo htmlspecialchars($success); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="signup.php">
                        <div class="form-group mb-4">
                            <label for="fullname" class="mb-2" style="color: #C8A882; font-weight: 500;">Full Name</label>
                            <input type="text" class="form-control form-control-lg" id="fullname" name="fullname" 
                                   placeholder="Enter your full name" required
                                   style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;">
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="mb-2" style="color: #C8A882; font-weight: 500;">Email Address</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                   placeholder="Enter your email" required
                                   style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;">
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="mb-2" style="color: #C8A882; font-weight: 500;">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                   placeholder="Enter your password" required
                                   style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;">
                        </div>

                        <div class="form-group mb-4">
                            <label for="cpassword" class="mb-2" style="color: #C8A882; font-weight: 500;">Confirm Password</label>
                            <input type="password" class="form-control form-control-lg" id="cpassword" name="cpassword" 
                                   placeholder="Re-enter your password" required
                                   style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;">
                        </div>

                        <div class="form-group form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms"
                                   style="border-color: #C8A882;">
                            <label class="form-check-label" for="terms" style="color: #fff;">
                                I agree to the Terms &amp; Conditions
                            </label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-lg btn-block font-weight-bold py-3 mb-3"
                                style="background-color: #C8A882; color: #000; border: none; letter-spacing: 2px;">
                            <i class="fa fa-user-plus mr-2"></i>SIGN UP
                        </button>
                    </form>

                    <hr style="border-color: #C8A882; opacity: 0.3;">

                    <div class="text-center">
                        <p class="mb-3" style="color: #fff;">
                            Already have an account? 
                            <a href="login.php" style="color: #C8A882; text-decoration: none; font-weight: bold;">
                                Login Here
                            </a>
                        </p>
                        <a href="index.php" style="color: #999; text-decoration: none;">
                            <i class="fa fa-arrow-left mr-2"></i>Back to Home
                        </a>
                    </div>

                    <hr style="border-color: #C8A882; opacity: 0.3;">

                    <div class="text-center mt-4">
                        <p class="mb-3" style="color: #999; font-size: 0.9rem;">Or sign up with:</p>
                        <button type="button" class="btn btn-outline-light btn-sm mr-2 mb-2">
                            <i class="fab fa-facebook-f mr-2"></i>Facebook
                        </button>
                        <button type="button" class="btn btn-outline-light btn-sm mb-2">
                            <i class="fab fa-google mr-2"></i>Google
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Signup Form End -->

<?php
include_once('footer.php');
?>

