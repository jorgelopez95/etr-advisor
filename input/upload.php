<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST")  { 
        extract($_POST);
        
        $target_dir = "./tmp/";
        $target_file = $target_dir . basename($_FILES["file_uploaded"]["tmp_name"] . ".html");
        $file = $_FILES['file_uploaded']['tmp_name'];
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $finfo = new finfo(FILEINFO_MIME);
        
        if (strpos($finfo->file($_FILES['file_uploaded']['tmp_name']),'text/html') === 0) {
          if (move_uploaded_file($file, $target_file)) {
            $_SESSION['file_uploaded'] = $_FILES['file_uploaded']['tmp_name'];
            header('Location:../result.php?file=' . $_FILES['file_uploaded']['name']);
          } 
          else {
            $alerta = "** Ha habido un problema. Inténtelo de nuevo **";
            echo "<script>"; 
                echo "if(alert('$alerta'));";  
                    echo "window.location = '../index.php';"; 
            echo "</script>"; 
          }
        }
        else{
            $alerta = "** Debe subir un archivo de tipo html **";
            echo "<script>"; 
                echo "if(alert('$alerta'));";  
                    echo "window.location = '../index.php';"; 
            echo "</script>"; 
        }
    }
    else{
        header("HTTP/1.0 405 Method Not Allowed"); 
    }
?>