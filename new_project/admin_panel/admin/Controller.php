

<?php
session_start();
include_once('model.php');
class control extends model {


    function __construct() {
    
        model::__construct();
        $url = '';
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $scriptName = dirname($_SERVER['SCRIPT_NAME']);
            $url = substr($requestUri, strlen($scriptName));
            if ($url === false || $url === '') {
                $url = '/';
            }
        }

        if ($url === '') {
            $url = '/';
        }

        if (strpos($url, '/controller.php') === 0) {
            $url = substr($url, strlen('/controller.php'));
            if ($url === '') {
                $url = '/';
            }
        }

        switch($url){

            case '/':
            case '/index':
            case '/index.php':
                if(isset($_REQUEST['submit'])){
                    $email = $_REQUEST['email'];
                    $password = md5($_REQUEST['password']);

                    $where=array("email"=>$email,"password"=>$password);
						
						$run=$this->select_where('admin',$where);
						$chk=$run->num_rows;
						if($chk) // 1 means true & 0 means false
						{
                            $_SESSION['admin_logged_in'] = true;
                            $_SESSION['admin_email'] = $email;
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
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_email'] = $email;
                        echo "<!DOCTYPE html><html><head><script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script></head><body><script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Registration Successful',
                        }).then(function() {
                            window.location = 'dashbord';
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

            case '/logout':
                session_unset();
                session_destroy();
                echo "<!DOCTYPE html><html><head><script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script></head><body><script>
                Swal.fire({
                    icon: 'success',
                    title: 'Logged Out',
                    text: 'You have been logged out successfully.',
                    showConfirmButton: false,
                    timer: 1200
                }).then(function() {
                    window.location = 'index';
                });
                </script></body></html>";
                exit;
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

            case '/edit_categories':
                if(isset($_REQUEST['update'])){
                    $id = $_REQUEST['id'];
                    $category_name = $_REQUEST['category_name'];
                    $where = array("id" => $id);
                    $updateData = array("category_name" => $category_name);

                    if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){
                        $image = $_FILES['image']['name'];
                        $path = "assets/images/categories/".$image;
                        $tmpName = $_FILES['image']['tmp_name'];
                        move_uploaded_file($tmpName, $path);
                        $updateData['image'] = $image;
                    }

                    $run = $this->update('categories', $updateData, $where);
                    if($run){
                        echo "<script>alert('Category updated successfully'); window.location='manage_categories';</script>";
                        exit;
                    } else {
                        echo "<script>alert('Category update failed');</script>";
                    }
                }

                if(isset($_GET['edit_category'])){
                    $id = $_GET['edit_category'];
                    $where = array("id" => $id);
                    $result = $this->select_where('categories', $where);
                    if($result && $result->num_rows > 0){
                        $category_arr = array();
                        while($fetch = $result->fetch_object()){
                            $category_arr[] = $fetch;
                        }
                    } else {
                        echo "<script>alert('Category not found'); window.location='manage_categories';</script>";
                        exit;
                    }
                } elseif(isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $where = array("id" => $id);
                    $result = $this->select_where('categories', $where);
                    if($result && $result->num_rows > 0){
                        $category_arr = array();
                        while($fetch = $result->fetch_object()){
                            $category_arr[] = $fetch;
                        }
                    }
                }

                include_once('edit_categories.php');
            break;

            case '/add_products':
                if(isset($_REQUEST['submit'])){
                    $product_name = $_REQUEST['product_name'];
                    $price = $_REQUEST['price'];
                    $description = $_REQUEST['description'];
                    $status = $_REQUEST['status'];
                    $image = '';
                    if(isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0){
                        $image = $_FILES['product_image']['name'];
                        $path = "assets/images/products/".$image;
                        move_uploaded_file($_FILES['product_image']['tmp_name'], $path);
                    }
                    $arr = array(
                        "product_name" => $product_name,
                        "product_image" => $image,
                        "price" => $price,
                        "description" => $description,
                        "status" => $status
                    );
                    $run = $this->insert('products', $arr);
                    if($run){
                        echo "<script>alert('Product added successfully'); window.location='manage_products';</script>";
                        exit;
                    } else {
                        echo "<script>alert('Product could not be added');</script>";
                    }
                }
                include_once('add_products.php');
            break;

            case '/manage_products':
                $product_arr = $this->select('products');
                include_once('manage_products.php');
            break;

            case '/edit_products':
                if(isset($_REQUEST['update'])){
                    $id = $_REQUEST['id'];
                    $product_name = $_REQUEST['product_name'];
                    $price = $_REQUEST['price'];
                    $description = $_REQUEST['description'];
                    $status = $_REQUEST['status'];
                    $where = array("id" => $id);
                    $updateData = array(
                        "product_name" => $product_name,
                        "price" => $price,
                        "description" => $description,
                        "status" => $status
                    );
                    if(isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0){
                        $image = $_FILES['product_image']['name'];
                        $path = "assets/images/products/".$image;
                        move_uploaded_file($_FILES['product_image']['tmp_name'], $path);
                        $updateData['product_image'] = $image;
                    }
                    $run = $this->update('products', $updateData, $where);
                    if($run){
                        echo "<script>alert('Product updated successfully'); window.location='manage_products';</script>";
                        exit;
                    } else {
                        echo "<script>alert('Product update failed');</script>";
                    }
                }
                if(isset($_GET['edit_product'])){
                    $id = $_GET['edit_product'];
                    $where = array("id" => $id);
                    $result = $this->select_where('products', $where);
                    if($result && $result->num_rows > 0){
                        $product_arr = array();
                        while($fetch = $result->fetch_object()){
                            $product_arr[] = $fetch;
                        }
                    } else {
                        echo "<script>alert('Product not found'); window.location='manage_products';</script>";
                        exit;
                    }
                }
                include_once('edit_products.php');
            break;

            case '/manage_contact':
                if(isset($_GET['del_contact'])){
                    $id = $_GET['del_contact'];
                    $where = array("id" => $id);
                    $this->delete('contact', $where);
                    echo "<script>alert('Contact deleted'); window.location='manage_contact';</script>";
                }
                if(isset($_POST['reply_btn'])){
                    $to = $_POST['reply_email'];
                    $subject = $_POST['reply_subject'];
                    $message = $_POST['reply_message'];
                    $headers = "From: info@example.com";
                    if(mail($to, $subject, $message, $headers)){
                        echo "<script>alert('Reply sent successfully');</script>";
                    } else {
                        echo "<script>alert('Failed to send reply');</script>";
                    }
                }
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
                if(isset($_GET['del_category'])){
                    $id = $_GET['del_category'];
                    $where = array("id" => $id);
                    $this->delete('categories', $where);
                    echo "<script>alert('Category deleted'); window.location='manage_categories';</script>";
                }
                if(isset($_GET['del_prod'])){
                    $id = $_GET['del_prod'];
                    $where = array("id" => $id);
                    $this->delete('products', $where);
                    echo "<script>alert('Product deleted'); window.location='manage_products';</script>";
                }
            break;

            case '/logout':
                session_destroy();
                echo "<script>
                window.location='index';
                </script>";
            break;

            default:
                // echo "404 Page Not Found";
            break;
        }
    }
}

$obj = new control;
