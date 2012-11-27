<?
    $status = '200';
    $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
    if ($link) {
        mysql_select_db(DBNAME);

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

    $ret = array( 'status' => $status, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
