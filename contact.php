<?php
    require './vendor/autoload.php';
    
    //Check the submit action of contact from index.php
	if ($_SERVER["REQUEST_METHOD"] == "POST")  { 
        //Filds of the form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        
        //Content
       // $from = new SendGrid\Email($name, $email);
                $from = new SendGrid\Email("Prueba", "prueba@gmail.com");
        $subject = $subject;
        $to = new SendGrid\Email("Easy-to-Read Advisorr", "jorge.lgi@hotmail.com");
        $content = new SendGrid\Content("text/html", "
        Nuevo mensaje en Easy-to-Read Advisor: <br>
         - De: {$name} <br>
         - Mensaje: <br>
            {$message}
        ");
        //Sending the mail
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $apiKey = ('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');
        $sg = new \SendGrid($apiKey);
        
        
        //Response
        $response = $sg->client->mail()->send()->post($mail);
    
   
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