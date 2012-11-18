<?
    function getCurrentTime(){
        return date("Y-m-d H:i");
    }

    function getFileContents($filename){
        $size = filesize( $filename );
        $id = fopen($filename,"r");
        $html = fread( $id, $size );
        fclose( $id );
        return $html;
    }
?>
