

<?php
include_once('model.php');
class control extends model {

    function __construct() {

        $url = $_SERVER['PATH_INFO'];   // URL fetch

        switch($url){

            case '/':
                include_once('index.php');
            break;
            case '/index':
                if(isset($_REQUEST['submit'])){
                    echo "<script>
                    alert('Login Successfully');
                    window.location='dashbord';
                    </script>";
                }
                include_once('index.php');
                break;
            case '/admin_register':

                if(isset($_REQUEST['signup'])){
                    $name = $_REQUEST['name'];
                    $email = $_REQUEST['email'];
                    $password = md5($_REQUEST['password']);

                    $arr = array("name" => $name,
                                 "email" => $email,
                                 "password" => $password
                                );

                $run=$this->insert('admin',$arr);
                }


                include_once('admin_register.php');
            break;

            case '/dashbord':
                include_once('dashbord.php');
            break;

            case '/add_categories':
                include_once('add_categories.php');
            break;

            case '/manage_categories':
                // $coffe_arr=$this->select('categories');
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