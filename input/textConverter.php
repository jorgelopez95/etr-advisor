<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")  { 
        
        //Archivo subido se guarda en el tmp con nombre filename
        $filename = $_POST['filename'];
        
        
        $fp = fopen('./tmp/$filename','w');
        fwrite($fp, "");
        fclose($fp);
    }
    else{
        console.log('Input fail');
    }

?>