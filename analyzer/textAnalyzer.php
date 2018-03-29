<?php	
    include ("./textConverter.php");
    
    //HTML DOM structure
    $doc = new DOMDocument();
    $doc->loadHTMLFile("../input/tmp/phpHV46rO.html");
    $doc->saveHTML();
    $xpath = new DOMXpath($doc);

    //Function getParagraphs, located into textConverter.php file
    $paragraphs = getParagraphs($pArray = array());

/* 1) Longitud de las líneas (60 caracteres frase) */

    $i=0;
    foreach ($paragraphs as $words) {
        //This array is filled with index of the end of the sentence
        $arrayEnd = array();
        
        //We must split into words (Taking into account UTF-8 encoding)
        $characters = preg_split("//u", $paragraphs[$i], null, PREG_SPLIT_NO_EMPTY);

        //Removing blank spaces
        for($j=0; $j<count($characters); $j++){ 
          if ($characters[$j] == ' '){ 
             unset($characters[$j]);
          }
        }
        $characters = array_values($characters);
        
        //Loop through each character
        for($j=0; $j<count($characters); $j++){ 
            
            //Only split sentences when these cases aren't false
            if ($characters[$j] == '.'){   
               //Case (...)
                if(!($characters[$j+1]=='.' || $characters[$j-1]=='.'|| $characters[$j+1]==',')){
                   array_push($arrayEnd, $j);
                }
            }        
            
            //Case (¿/¡..?/! Sentence2)
            if ($characters[$j] == '?' || $characters[$j] =='!'){
                if (ctype_upper($characters[$j+1])){
                   array_push($arrayEnd, $j);
                }
            }
        }
        //Substraction between indexs of arrayEnd determines the number of characters in the sentence.
        for($k=0; $k<strlen($arrayEnd[$k]); $k++){
            $subtraction=0;
            if($k==0){
                $subtraction=(int)$arrayEnd[$k];
            }else{
                $subtraction=(int)$arrayEnd[$k] - (int)$arrayEnd[$k-1];
            }
            
            //Sentences can't contain more than 60 characters
            if ($subtraction>60){ 
                 //echo "ERROR: las frases no pueden contener más de 60 caracteres" . '<br>';
            }
        }
        $i++;
    }

    
/* 2) Números grandes (100000 es el máximo) */

    //Iteration over the <p> returned by "getParagraphs" function
    $i=0;
    foreach ($paragraphs as $words) {
        //We must split into words
        $words = explode(" ", trim($paragraphs[$i]));
        
        //Loop through each word. If we find a number, check if it's greater than 100.000  
        foreach($words as $word){
            if (is_numeric($word) && (int)$word>100000){
               //echo 'ERROR: El número' . $word. 'es muy grande';
            } 
        }
        $i++;
    }


/* 3) Caracteres especiales */

    //Paragraphs can't contain any of these special characters
    $specialCharacters = array("|", "#", "~", "%", "&", "¬", "<", ">", "\\");
    $i=0;
    foreach ($paragraphs as $words) {
        //We must split into characters
        $characters = preg_split("//u", $paragraphs[$i], null, PREG_SPLIT_NO_EMPTY);
        //print_r($characters);
        
        //Loop through each character. If we find a special character, we got an error  
        foreach($characters as $key => $value){
            $character = explode("-", $value);
            $character = trim($character[0]);
            if (in_array($character, $specialCharacters)) {
                //echo "ERROR: No puede haber caracteres especiales como: " . $character;
            }
        }
        $i++;
    }

    
/* 4) Caracteres de orden ("º", "ª") */

    //Paragraphs can't contain order characters
    $orderCharacters = array("º", "ª");
    $i=0;
    foreach ($paragraphs as $words) {
        //We must split into characters
        $characters = preg_split("//u", $paragraphs[$i], null, PREG_SPLIT_NO_EMPTY);
        //print_r($characters);
        
        //Loop through each character. If we find an order character, we got an error  
        foreach($characters as $key => $value){
            $character = explode("-", $value);
            $character = trim($character[0]);
            
            if (in_array($character, $orderCharacters)) {
                //echo "ERROR: No puede haber caracteres de orden (º/ª)";
            }
        }
        $i++;
    }


// 5) Número de palabras por frase (15 palabras máximo por frase)
    
    //First of all. Iterating the paragraphs
    for($i=0; $i<count($paragraphs); $i++) {
        
        //This array is filled with index of the end of the sentence
        $arrayEnd = array();
        
        //Iterating each paragraph, splitting into words(Taking into account UTF-8 encoding)
        for($j=0; $j<strlen($paragraphs[$i]); $j++){
            $characters = preg_split("//u", $paragraphs[$i], null, PREG_SPLIT_NO_EMPTY);
        }
        
        //Loop through each character. Searching cutting patterns
        for($l=0; $l<count($characters); $l++){ 
            //Only split sentences when these cases aren't false
            if ($characters[$l] == '.'){
                //Cases (etc.,) / (...)
                if(!($characters[$l+1]=='.' || $characters[$l-1]=='.' || $characters[$l+1]==',')){
                    array_push($arrayEnd, $l+1);
                }
            }
            //Case (¿/¡Words?/!+Sentence)
            if ($characters[$l] == '?' || $characters[$l] =='!'){
                if (ctype_upper($characters[$l+1]) || ctype_upper($characters[$l+2])){
                   array_push($arrayEnd, $l+1);
                }
            }
        }

        //Iteration according to obtained indexes 
        for($k=0; $k<strlen($arrayEnd[$k]); $k++){ 
            if($k!=0){
               (int)$arrayEnd[$k] = (int)$arrayEnd[$k] - (int)$arrayEnd[$k-1];
            }    
            //Splitting the paragraph into senteces (in position k)
            $newArray = str_split_unicode($paragraphs[$i], $arrayEnd[$k]);
                    
            //Counting words per sentence obtained
            preg_match_all('/\pL+/u', $newArray[0], $nWords);

            if(count($nWords[0]) > 15){
                /*echo "ERROR: Existen frases con más de 15 palabras___";
                echo 'La frase es: '. $newArray[0] . '<br>';*/
            }
            
            //Removing processed sentence
            $paragraphs[$i] = iconv_substr($paragraphs[$i], (int)$arrayEnd[$k], (int)strlen($paragraphs[$i]));
        }
    }
           
    /**
     *This function is similar to str_split, but can process unicode characters.
     **/
    function str_split_unicode($str, $l = 0) {
        if ($l > 0) {
            $ret = array();
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
                return $ret;
            }
            return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }


// ** 6) Cantidad de texto por página (75 palabras por diapositiva)
    
    
// 7) Formato de las fechas (13 de enero del 2017 en lugar de 13/01/2017)
    
    //Iteration over the <p> returned by "getParagraphs" function
    $paragraphs = getParagraphs($pArray = array()); 
    for($i=0; $i<count($paragraphs); $i++) {
        
        //Looking for a date format
        if( preg_match_all("/([0-9]{2})\-([0-9]{2})\-([0-9]{4})/i", $paragraphs[$i], $dates) ||
            preg_match_all("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/i", $paragraphs[$i], $dates) ||
            preg_match_all("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/i", $paragraphs[$i], $dates) ||
            preg_match_all("/([0-9]{4})\/([0-9]{2})\/([0-9]{2})/i", $paragraphs[$i], $dates)
        ){
            //Converting array of dates to string
            $datesFound=implode(", ", $dates[0]);
            //echo "ERROR: las siguientes fechas deberían tener un formato del estilo de '<em>28 de marzo del 2018</em>':" . '<br>' . $datesFound. '<br>';
        }
    }

    
// 8) Uso de pronombres (2 máximo por frase)
    
    //Iteration over the <p> returned by "getParagraphs" function
    $paragraphs = getParagraphs($pArray = array()); 
    //First of all. Iterating the paragraphs
    for($i=0; $i<count($paragraphs); $i++) {
        
        //This array is filled with index of the end of the sentence
        $arrayEnd = array();
        
        //Iterating each paragraph, splitting into words(Taking into account UTF-8 encoding)
        for($j=0; $j<strlen($paragraphs[$i]); $j++){
            $characters = preg_split("//u", $paragraphs[$i], null, PREG_SPLIT_NO_EMPTY);
        }
        
        //Loop through each character. Searching cutting patterns
        for($l=0; $l<count($characters); $l++){ 
            //Only split sentences when these cases aren't false
            if ($characters[$l] == '.'){
                //Cases (etc.,) / (...)
                if(!($characters[$l+1]=='.' || $characters[$l-1]=='.' || $characters[$l+1]==',')){
                    array_push($arrayEnd, $l+1);
                }
            }
            //Case (¿/¡Words?/!+Sentence)
            if ($characters[$l] == '?' || $characters[$l] =='!'){
                if (ctype_upper($characters[$l+1]) || ctype_upper($characters[$l+2])){
                   array_push($arrayEnd, $l+1);
                }
            }
        }

        //Iteration according to obtained indexes 
        for($k=0; $k<strlen($arrayEnd[$k]); $k++){ 
            if($k!=0){
               (int)$arrayEnd[$k] = (int)$arrayEnd[$k] - (int)$arrayEnd[$k-1];
            }    
            //Splitting the paragraph into senteces (in position k)
            $newArray = str_split_unicode($paragraphs[$i], $arrayEnd[$k]);
              
            //print_r($newArray); echo '<br>';echo '<br>';   
            
            //newArray[0] separar juntar con +
            $sentence = str_replace(" ","+", $newArray[0]);
            //print_r($sentence);
            
            //Using API (https://api.textgain.com)
            $q='https://api.textgain.com/1/tag?q=' . $sentence .'&lang=es&key=***';
            $data = json_decode(file_get_contents($q), true);
            print_r($data["text"]); echo "<br>"; echo "<br>";
            //echo count($data["text"]) .'<br>';
            
    
            //Removing processed sentence
            $paragraphs[$i] = iconv_substr($paragraphs[$i], (int)$arrayEnd[$k], (int)strlen($paragraphs[$i]));
        }
    }

    
    
// 9) Números romanos

    //Iteration over the <p> returned by "getParagraphs" function
    $paragraphs = getParagraphs($pArray = array()); 
    for($i=0; $i<count($paragraphs); $i++) {

        //Looking for a Roman numerals
        if(preg_match_all("/\b(?:X?L?(?:X{0,3}(?:IX|IV|V|V?I{1,3})|IX|X{1,3})|XL|L)\b/", $paragraphs[$i], $roman)){
            //Converting array of Roman numerals to string
            $numeralsFound=implode(", ", $roman[0]);
            //echo "ERROR: no puede haber números romanos: " . $numeralsFound;
        }
    }
  
    
// 10) Dirección del mensaje (Pronombres vosotros o ustedes)

    
// 11) Uso de forma pasiva (No usar forma pasiva de los verbos)
    
    
// 12) Sujeto de la oración (Las oraciones deben tener sujeto)
    
    
// 13) Composición de la oración (sujeto + verbo + complementos)
           
           
           



?>