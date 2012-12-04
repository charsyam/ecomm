<?
    require("../config.php");
    $method = $_SERVER['REQUEST_METHOD'];
    if( $method == "POST" ){
        $title = $_POST["title"];
        $price = $_POST["price"];
        $label = $_POST["label"];
        $seller = $_POST["seller"];
        $comment = $_POST["comment"];
        $origin =$_POST["origin"];

        $file_count = 0;
        for($j=0; $j < count($_FILES["file"]['name']); $j++){
            if( $_FILES["file"]['name']["$j"] != "" ){
                $file_count++;
            }
        }


        if( $file_count == 0 ){
            printf("need image");
            exit(0);
        }

        $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
        mysql_select_db(DBNAME);

        $query = "insert into tbl_goods values( '', '$title', $price, $seller, '', '$origin', '$comment')";
        $result = mysql_query($query);
        $id = mysql_insert_id();
        print $query;
        print $id;

        if($file_count > 0)
        { 
            for($j=0; $j < count($_FILES["file"]['name']); $j++)
            { //loop the uploaded file array
                if( $_FILES["file"]['name']["$j"] == "" ){
                    continue;
                }

                $new_filename = $id.'_'.$j; //file name
                $new_filename = md5($new_filename);

                $path = 'uploads/'.$new_filename; //generate the destination path
                if( $j == 0 ){
                    $image = $path;
                    $query = "update tbl_goods set image='$image' where id=$id";
                    $result = mysql_query($query);
                }

                $realpath = '../'.$path;
                print $realpath;
                move_uploaded_file($_FILES["file"]['tmp_name']["$j"],$realpath);

                $query = "insert into tbl_images values( '', $id, '$path')";
                $result = mysql_query($query);
            }
        }
    }
?>

<meta http-equiv="refresh" content="0; url=../admin.php">
