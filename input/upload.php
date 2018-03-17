<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")  { 
        $target_dir = "./tmp/";
        $target_file = $target_dir . basename($_FILES["file_uploaded"]["tmp_name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check whether something is wrong
        if($_FILES['file_upload']['error'] > 0){
            $alerta = "** Ha habido un problema. Inténtelo de nuevo **";
            echo "<script>"; 
                echo "if(alert('$alerta'));";  
                    echo "window.location = '../index.php';"; 
            echo "</script>"; 
        }
        
        // We only allow only html files
        if($_FILES['file_uploaded']['type'] != 'text/html'){
            $alerta = "** Debe subir un archivo con extensión .html **";
            echo "<script>"; 
                echo "if(alert('$alerta'));";  
                    echo "window.location = '../index.php';"; 
            echo "</script>"; 
        }
        
        // Upload file
        if (move_uploaded_file($_FILES["file_uploaded"]["tmp_name"], $target_file)) {
                header('Location:../resultado.php');
        } else {
                echo "Sorry, there was an error uploading your file.";
        }
    }
    else{
        console.log("Input fail");
    }
?>