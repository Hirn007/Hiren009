<?php
session_start();
include_once('model.php');
class control extends model {


    function __construct() {
    
        model::__construct();
       $url=$_SERVER['PATH_INFO']; 
        switch($url){

          case '/':

          case '/index':
         include_once('index.php');
          break;


          case '/login':

    if(isset($_SESSION['user_email']))
    {
        echo "<script>
            window.location='index';
        </script>";
    }
    else
    {
        if(isset($_REQUEST['submit']))
        {
            $email = $_REQUEST['email'];
            $password = md5($_REQUEST['password']);

            $where = array("email" => $email, "password" => $password);
            $run = $this->select_where('customers', $where);

            if($run && $run->num_rows == 1)
            {
                $fetch = $run->fetch_object();

                if($fetch->status == "Unblock")
                {
                    // SESSION SET
                    $_SESSION['user_email'] = $fetch->email;

                    echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Login Successful!',
                            icon: 'success'
                        }).then(() => {
                            window.location='index';
                        });
                    </script>";
                }
                else
                {
                    echo "<script>
                        Swal.fire({
                            title: 'Blocked!',
                            text: 'Your account is blocked!',
                            icon: 'error'
                        });
                    </script>";
                }
            }
            else
            {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Wrong Email or Password',
                        icon: 'error'
                    });
                </script>";
            }
        }

        include_once('login.php');
    }

break;


               case '/cust_logout':

               unset($_SESSION['user_email']);

                echo "<script>
                   Swal.fire({
                   title: 'Logout',
                   text: 'Logout Successful!',
                   icon: 'success'
                }).then(() => {
                    window.location='index';
               });
                   </script>";

               break;


         case '/signup':

    if(isset($_SESSION['user_email']))
    {
        echo "<script>
            window.location='index';
        </script>";
    }
    else
    {
        if(isset($_REQUEST['submit']))
        {
            $email = trim($_REQUEST['email']);
            $password = md5($_REQUEST['password']);

            // Check email already exists
            $where = array("email" => $email);
            $check = $this->select_where('customers', $where);

            if($check && $check->num_rows > 0)
            {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Email already exists!',
                        icon: 'error'
                    });
                </script>";
            }
            else
            {
                $arr = array(
                    "email" => $email,
                    "password" => $password
                );

                $run = $this->insert('customers', $arr);

                if($run)
                {
                    // Auto login (optional)
                    $_SESSION['user_email'] = $email;

                    echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Registration Successful!',
                            icon: 'success'
                        }).then(() => {
                            window.location='index';
                        });
                    </script>";
                }
                else
                {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Signup Failed!',
                            icon: 'error'
                        });
                    </script>";
                }
            }
        }

        include_once('signup.php');
    }

break;

            case '/service':
                include_once('service.php');
            break;

            case '/menu':
                include_once('menu.php');
            break;

           case '/contact':
    if(isset($_REQUEST['name']))
    {
        $name=$_REQUEST['name'];
        $email=$_REQUEST['email'];
        $phone=$_REQUEST['phone'];
        $subject=$_REQUEST['subject'];
        $message=$_REQUEST['message'];

        $arr=array("name"=>$name, "email"=>$email, "phone"=>$phone, "subject"=>$subject, "message"=>$message);

        $run=$this->insert('contact',$arr);

        if($run) {
            echo "Contact Submitted Success";
            exit;
        } else {
            echo "Not Success";
            exit;
        }
    }

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
            Swal.fire({
                title: 'Success!',
                text: 'Booking Successful',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location='index';
            });
            </script>";
        } else {
            echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Booking Failed',
                icon: 'error',
                confirmButtonText: 'OK'
            });
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

            case '/logout':

    // User session delete
    unset($_SESSION['user_email']);
    session_destroy();

    // Redirect to login page
    header("Location: index");
    exit;

break;

            default:
                // echo "404 Page Not Found";
            break;
        }
    }
}

$obj = new control;

?>