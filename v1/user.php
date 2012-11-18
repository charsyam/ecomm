<?php
    session_start();
    header('Content-type: application/json');

    $status = '200';
    $link = mysql_connect('localhost', 'ecomm', 'ecomm1' ) or die('Could not connect: '.mysql_error());
    if ($link) {
        mysql_select_db('ecomm');

        $method = $_SERVER['REQUEST_METHOD'];
        if( $method == "GET" ){
            $email = $_GET['email'];
            $password = md5($_GET['password']);
            $query = "select * from tbl_user where email='$email' and password='$password'";
            $result = mysql_query($query);
            if( !$result ){
                $status = "500";
                $message = mysql_error();
            }else{
                $num_rows = mysql_num_rows($result);
                if( $num_rows != 1 ){
                    $status = "501";
                    $message = "invalid email or password";
                }else{
                    $row = mysql_fetch_array($result);
                    $_SESSION['email'] = $row["email"];
                    $_SESSION["login"] = 1;
                    $_SESSION["name"] = $row["name"];
                }
            }
        }
        else if( $method == "POST" ){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $password = md5($_POST['password']);

            $query = "insert into tbl_user values( '', '$name', '$email', '$phone', '$password', '$address' )";
            $result = mysql_query($query);
            if( !$result ){
                $status = "500";
                $message = mysql_error();
            }
        }
    }else{
        $status = '500';
        $message = mysql_error();
    }

    $ret = array( 'status' => $status, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
