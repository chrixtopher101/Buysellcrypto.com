<?php session_start(); ?>

<?php 
        require_once("include/block_io.php");
        include 'key.php';
        include 'conn.php';
?>
<?php
        $f_name=$_POST['f_name'];
        $l_name=$_POST['l_name'];
        $email=$_POST['email'];
        $c_email=$_POST['c_email'];
        $username=$_POST['user_name'];
        $password=md5($_POST['password']);

        if($email != $c_email)
        {
          $_SESSION["reg_error"]="Email address dosen't matched";
          header('Location: create_account.php');
        }
        else {

          $query="SELECT * FROM users WHERE user_name='$username'";
          $result=mysqli_query($conn,$query);
          if(mysqli_num_rows($result) > 0)
          {
            $_SESSION["reg_error"]="Username in use";
        	
          }
        else {

            $address=$block_io->get_new_address();
            foreach ($address as $value) {
              $add=$value->address;
            }
          $sql="INSERT into users (first_name,last_name,user_name,email,password,address) VALUES ('$f_name','$l_name','$username','$email','$password','$add') ";
          if (mysqli_query($conn, $sql)) {
              $to      = $email;
                $subject = 'Registration Success';
                $message = 'Hi'.''.$f_name.''.$l_name.''.', Your Registration has beeen successfully completed';
                $headers = 'From: Chrixtopher101@gmail.com' . "\r\n" .
                    'Reply-To:'.$right_email . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);
            $_SESSION["reg_error"]="Registered successfully";
            header('Location: create_account.php');
            }
          else {
            header('Location: create_account.php');
            }
          }



          mysqli_close($conn);

          }


?>