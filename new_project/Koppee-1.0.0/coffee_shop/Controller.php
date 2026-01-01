

<?php
include_once('model.php');
class control extends model {

    function __construct() {

        $url = $_SERVER['PATH_INFO'];   // URL fetch

        switch($url){

            case '/signup':
               if(isset($_SESSION['uid']))
    {
        echo "<script>window.location='index';</script>";
    }
    else
    {
        if(isset($_REQUEST['submit']))
        {
            $fullname  = $_REQUEST['fullname'];
            $email     = $_REQUEST['email'];
            $password  = $_REQUEST['password'];
            $cpassword = $_REQUEST['cpassword'];
            $terms     = isset($_REQUEST['terms']) ? 1 : 0;

            // Password match check
            if($password != $cpassword)
            {
                echo "<script>alert('Password mismatch');</script>";
            }
            // Terms check
            else if($terms == 0)
            {
                echo "<script>alert('Accept Terms & Conditions');</script>";
            }
            else
            {
                // 🔥 SELECT QUERY (email already exist?)
                $check = $this->select_where('users', ['email' => $email]);

                if($check)
                {
                    echo "<script>alert('Email already registered');</script>";
                }
                else
                {
                    // 🔥 INSERT QUERY (signup)
                    $password = md5($password);

                    $arr = array(
                        "fullname" => $fullname,
                        "email"    => $email,
                        "password" => $password
                    );

                    $run = $this->insert('users', $arr);

                    if($run)
                    {
                        echo "<script>
                                alert('Signup Successful');
                                window.location='index';
                              </script>";
                    }
                    else
                    {
                        echo "<script>alert('Signup Failed');</script>";
                    }
                }
            }
        }

        include_once('signup.php');
    }

break;
                
            case '/index':
                 if(isset($_SESSION['uid']))
    {
        echo "<script>window.location='index';</script>";
    }
               
                include_once('index.php');
                break;
            case '/admin_register':

                


                include_once('admin_register.php');
            break;

            case '/dashbord':
                include_once('dashbord.php');
            break;

            case '/add_categories':
                include_once('add_categories.php');
            break;

            case '/manage_categories':
                $coffe_arr=$this->select('categories');
				include_once('manage_categories.php');
			break;
                

            case '/add_products':
                include_once('add_products.php');
            break;

            case '/manage_products':
                	// $prod_arr=$this->select('product');
                include_once('manage_products.php');
            break;

            case '/manage_contact':
                include_once('manage_contact.php');
            break;

            case '/Manage Customer':
                include_once('Manage Customer.php');
            break;

            case '/manage_cart':
                include_once('manage_cart.php');
            break;

            case '/manage_order':
                include_once('manage_order.php');
            break;

            case '/manage_feedback':
                include_once('manage_feedback.php');
            break;

            case '/delete':
                include_once('delete.php');
            break;

            default:
                // echo "404 Page Not Found";
            break;
        }
    }
}

$obj = new control;

?>