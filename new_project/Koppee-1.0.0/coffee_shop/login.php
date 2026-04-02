<?php include_once('header.php'); ?>

<!-- Login Form Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="p-5 bg-dark rounded mb-5" 
                     style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);">

                    <h2 class="text-center mb-4" 
                        style="color: #C8A882; letter-spacing: 2px;">
                        LOGIN
                    </h2>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-exclamation-circle mr-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="login">

                        <div class="form-group mb-4">
                            <label style="color:#C8A882;">Email Address</label>
                            <input type="email" name="email"
                                   class="form-control form-control-lg"
                                   placeholder="Enter your email"
                                   required
                                   style="background:#1a1a1a;border:1px solid #C8A882;color:#fff;">
                        </div>

                        <div class="form-group mb-4">
                            <label style="color:#C8A882;">Password</label>
                            <input type="password" name="password"
                                   class="form-control form-control-lg"
                                   placeholder="Enter your password"
                                   required
                                   style="background:#1a1a1a;border:1px solid #C8A882;color:#fff;">
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" name="remember">
                            <label class="form-check-label text-white">Remember me</label>
                        </div>

                        <button type="submit" name="login_btn"
                                class="btn btn-lg btn-block font-weight-bold"
                                style="background:#C8A882;color:#000;">
                            LOGIN
                        </button>

                    </form>

                    <hr style="border-color:#C8A882;opacity:0.3;">

                    <div class="text-center">
                        <p class="text-white">
                            Don't have an account?
                            <a href="signup" style="color:#C8A882;font-weight:bold;">
                                Sign Up Here
                            </a>
                        </p>
                        <a href="index" style="color:#999;">
                            Back to Home
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Form End -->

<?php include_once('footer.php'); ?>
