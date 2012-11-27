<?
    session_start();
    header('Content-type: application/json');
    require("../config.php");

    $status = "200";
    $count = 0;
    $idlist = "";
    $query = "test";
    if (empty($_POST["checkitem"]) ){
        $status = "501";
        $message = "no checkitem";
    }else{
        $N = count($_POST["checkitem"]);
        for( $i=0; $i<$N; $i++ ){
            $num = $_POST["checkitem"][$i];
            if( $i == 0 ){
                $idlist = "$num";
            }else{
                $idlist = $idlist.",$num";
            }
        }

        $query = "delete from tbl_seller where id in ($idlist)";
        $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
        mysql_select_db(DBNAME);
        $result = mysql_query($query);
        $count = mysql_affected_rows();
        $message = mysql_error();
    }

    $ret = array( 'status' => $status, 'count' => $count, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
