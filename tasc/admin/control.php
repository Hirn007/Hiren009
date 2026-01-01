<?php
include_once('model.php');
class control extends model {

    function __construct() {

		echo "My name is Control";
        $url = $_SERVER['PATH_INFO'];   
		echo $url;

        switch($url){
            case '/dashbord':
                include_once('dashbord.php');
            break;

            case '/add_categories':
                include_once('add_categories.php');
            break;

            case '/manage_categories':
               
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
                
            break;
        }
    }
}

$obj = new control;

?>