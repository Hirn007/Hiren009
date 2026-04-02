

<?php
include_once('model.php');
class control extends model {


    function __construct() {
    
        model::__construct();
        $url = $_SERVER['PATH_INFO'];   // URL fetch

        switch($url){

            case '/':
                include_once('index.php');
            break;
            case '/index':
                if(isset($_REQUEST['submit'])){
                    $email = $_REQUEST['email'];
                    $password = md5($_REQUEST['password']);

                    $where=array("email"=>$email,"password"=>$password);
						
						$run=$this->select_where('admin',$where);
						$chk=$run->num_rows;
						if($chk) // 1 means true & 0 means false
						{
                            echo "<!DOCTYPE html><html><head><script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script></head><body><script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Welcome!',
                                text: 'Login Successfully',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location = 'dashbord';
                            });
                            </script></body></html>";
                            exit;
                        }else
                        {
                            echo "<!DOCTYPE html><html><head><script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script></head><body><script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: 'Invalid Email or Password',
                            }).then(function() {
                                window.location = 'index';
                            });
                            </script></body></html>";
                            exit;
                        }
                    
                        
                }
                    include_once('index.php');
                break;
            case '/admin_register':

                if(isset($_REQUEST['signup'])){
                    $name = $_REQUEST['name'];
                    $email = $_REQUEST['email'];
                    $password = md5($_REQUEST['password']);

                    $where = array("email" => $email);
                    $check = $this->select_where('admin', $where);
                    if ($check && $check->num_rows > 0) {
                        echo "<!DOCTYPE html><html><head><script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script></head><body><script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Email already exists! Please use a different email or log in.',
                        }).then(function() {
                            window.location = 'admin_register';
                        });
                        </script></body></html>";
                        exit;
                    } else {
                        $arr = array("name" => $name,
                                     "email" => $email,
                                     "password" => $password
                                    );
                        $run=$this->insert('admin',$arr);
                        echo "<!DOCTYPE html><html><head><script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script></head><body><script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Registration Successful',
                        }).then(function() {
                            window.location = 'index';
                        });
                        </script></body></html>";
                        exit;
                    }
                }


                include_once('admin_register.php');
            break;

            case '/dashbord':
                include_once('dashbord.php');
            break;

            case '/add_categories':	
				if(isset($_REQUEST['submit']))
				{
					$category_name=$_REQUEST['category_name'];
					$image=$_FILES['image']['name'];
					if($_FILES['image']['size']>0)
					{
						$path="assets/images/categories/".$image;  // path where we upload img
						$dup_file1=$_FILES['image']['tmp_name']; // get duplicate file
						move_uploaded_file($dup_file1,$path); // move dupl image in path
					}
					$arr=array("category_name"=>$category_name,"image"=>$image);
					$run=$this->insert('categories',$arr);
					if($run == true)
					{
						"<script>alert('categories Inserted Success');</script>";

                    }else{
                        "<script>alert('categories not Inserted ');</script>";
					}	
				}
				include_once('add_categories.php');
			break;

            case '/manage_categories':
				$category_arr=$this->select('categories');
				include_once('manage_categories.php');
			break;
                
				
            case '/add_products':
                
                include_once('add_products.php');
            break;

            case '/manage_products':
                	
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