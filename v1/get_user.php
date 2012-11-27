<?
    $status = '200';
    $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
    if ($link) {
        mysql_select_db(DBNAME);

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

    $ret = array( 'status' => $status, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
