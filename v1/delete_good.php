<?
    session_start();
    header('Content-type: application/json');
    require("../config.php");

    $status = "200";

    if ( isset($_SESSION["admin"]) ){
        $id = $_GET["id"];

        $query = "delete from tbl_goods where id=$id";
        $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
        mysql_select_db(DBNAME);
        $result = mysql_query($query);
        $count = mysql_affected_rows();

        $query = "delete from tbl_images where good_id=$id";
        $result = mysql_query($query);
        $count = mysql_affected_rows();
        $message = mysql_error();
    }

    $ret = array( 'status' => $status, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
