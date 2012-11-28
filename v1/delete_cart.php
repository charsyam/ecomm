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
            unset($_SESSION["cart"]["$num"]);
        }

    }

    $ret = array( 'status' => $status, 'count' => $count, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
