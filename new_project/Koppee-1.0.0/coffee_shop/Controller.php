<?php
include_once('model.php');
class control extends model {


    function __construct() {
    
        model::__construct();
        $url = $_SERVER['PATH_INFO'];   // URL fetch

        switch($url){

            case '/login':
                if(isset($_REQUEST['login_btn']))
					{
						$email=$_REQUEST['email'];
						$password=md5($_REQUEST['password']);
						
						$where=array("email"=>$email,"password"=>$password);
						
						$run=$this->select_where('customers',$where);
						$chk=$run->num_rows;
						if($chk==1) // 1 means true & 0 means false
						{
                             echo "<script>
                            alert('Login Succussful');
                            window.location='index';
                            </script>";
                        }else{
                            echo "<script>
                            alert('Login Failed');
                            </script>";
                        }
                    }
                
                include_once('login.php');
            break;
            case '/index':
                
                    include_once('index.php');
                break;
            case '/signup':

            if(isset($_POST['signup'])){

                $email = $_POST['email'];
                $password = md5($_POST['password']);
                    $arr = array(
                        "email" => $email,
                        "password" => $password
                    );

                    $run = $this->insert('customers', $arr);
                  
                    if($run){
                        echo "<script>
                            alert('Registration Succussful');
                            window.location='login';
                        </script>";
                    } else {
                        echo "<script>
                            alert('Signup Failed');
                        </script>";
                    }
            }

            include_once('signup.php');
            break;

            case '/service':
                include_once('service.php');
            break;

            case '/menu':
                include_once('menu.php');
            break;

            case '/contact':
                // $coffe_arr=$this->select('categories');
				include_once('contact.php');
			break;
                

            case '/reservation':
                case '/reservation':

    if(isset($_POST['book_table'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $booking_date = $_POST['booking_date'];
        $booking_time = $_POST['booking_time'];
        $persons = $_POST['persons'];

        $arr = array(
            "name" => $name,
            "email" => $email,
            "booking_date" => $booking_date,
            "booking_time" => $booking_time,
            "persons" => $persons
        );

        $run = $this->insert('book_your_table', $arr);

        if($run){
            echo "<script>
                    alert('Booking Successful');
                    window.location='reservation';
                  </script>";
        } else {
            echo "<script>
                    alert('Booking Failed');
                  </script>";
        }
    }

    include_once('reservation.php');
break;
                include_once('reservation.php');
            break;

            case '/testimonial':
                	// $prod_arr=$this->select('product');
                include_once('testimonial.php');
            break;

            case '/about':
                include_once('about.php');
            break;

            default:
                // echo "404 Page Not Found";
            break;
        }
    }
}

$obj = new control;

?>