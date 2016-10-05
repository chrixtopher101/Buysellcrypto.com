<?php
session_start();

            if (!isset($_SESSION['user_id'])) {
            	    header('Location: create_account.php');
            	}

                        		include 'conn.php';
                        		require_once("include/block_io.php");
                        		include 'key.php';


                        		$address  = $_POST['address'];
                        		$amounts   = $_POST['amount'];
                        		$balance   = $block_io->get_address_balance(array('addresses' => $_SESSION['address']));
                        		$amount    = $balance->data;
                        		$a_balance = $amount->available_balance;

            		if ($a_balance < $amounts) 

                            	{
                            	    echo '2';
                            	    exit;
                            	}


                $block_io->withdraw_from_addresses(array('amounts' =>$amounts,'from_addresses' => $_SESSION['address'],'to_addresses' => $address));


                echo '1';



                exit;


            mysqli_close($conn);
?>
