<?php
    //Check the submit action of contact from index.php
	if ($_SERVER["REQUEST_METHOD"] == "POST")  {  
        //Filds of the form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        
        //Composing the email message
        $email_from = $email;
        $email_subject = "[Easy-to-Read Advisor]: $subject";
        $email_body = "Nuevo mensaje en Easy-to-Read Advisor: \n".
                        "Nombre: $name \n".
                        "Mensaje:\n $message";
        $to = "jorge.lgi@hotmail.com";
        $headers = "From: $email_from \r\n";
        
        //Sending the email
        mail($to, $email_subject, $email_body, $headers);
        
        //Reloading index and sending ok message
        $confirmacion = "** Mensaje enviado correctamente. Gracias por su interés **";
        echo "<script>"; 
            echo "if(alert('$confirmacion'));";  
                echo "window.location = './index.php';"; 
        echo "</script>"; 
    }
    else{
        echo 'Input fail';
    }
?>