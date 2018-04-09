<?php
	
if(!isset($_SESSION)){ session_start(); } 

function textAnalyzer(){
    
    include_once ("./analyzer/textConverter.php");
    include_once ("./analyzer/morphosyntacticAnalyzer.php");
    $file_uploaded = $_SESSION['file_uploaded'];
    $file_uploaded = './input' . $file_uploaded . '.html';
    
    //HTML DOM structure
    $doc = new DOMDocument();
    //$doc->loadHTMLFile("../input/tmp/phpHV46rO.html");
    $doc->loadHTMLFile($file_uploaded);
    $doc->saveHTML();
    $xpath = new DOMXpath($doc);

    $textAnalyzerArray = array();
 
    //Function getParagraphs, located at textConverter.php file
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
            if ((int)$subtraction>60){ 
                $textAnalyzerArray['P1'] = 'El párrafo ['.$paragraphs[$i]. '] contiene frases de más de 60 caracteres. Concretamente posee '.$subtraction.'.';
                 //echo "ERROR: las frases no pueden contener más de 60 caracteres" . '<br>';
            }
        }
        $i++;
    }
    

    
/* 2) Números grandes (100000 es el máximo) */

    $P2_errors = array();
    //Iteration over the <p> returned by "getParagraphs" function
    $i=0;
    foreach ($paragraphs as $words) {
        //We must split into words
        $words = explode(" ", trim($paragraphs[$i]));
        
        //Loop through each word. If we find a number, check if it's greater than 100.000  
        foreach($words as $word){
            if (is_numeric($word) && (int)$word>100000){
                array_push($P2_errors, $word);
               //echo 'ERROR: El número' . $word. 'es muy grande';
            } 
        }
        $i++;
    }
    if (!empty($P2_errors)){
        $numberError = implode(", ", $P2_errors);
        $textAnalyzerArray['P2'] = 'Tu texto contiene algún numero ('.$numberError.') mayor que 100.000';
    }
    unset($P2_errors);


/* 3) Caracteres especiales */

    $P3_errors = array();
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
                array_push($P3_errors, $character);
                //echo "ERROR: No puede haber caracteres especiales como: " . $character;
            }
        }
        $i++;
    }
    if (!empty($P3_errors)){
        $specialError = implode(", ", $P3_errors);
        $textAnalyzerArray['P3'] = 'No puede haber caracteres especiales como '.$specialError.' .';
    }
    unset($P3_errors);
    
    
/* 4) Caracteres de orden ("º", "ª") */

    $P4_errors = array();
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
                array_push($P4_errors, $character);
                //echo "ERROR: No puede haber caracteres de orden (º/ª)";
            }
        }
        $i++;
    }
    if (!empty($P4_errors)){
        $orderError = implode(", ", $P4_errors);
        $textAnalyzerArray['P4'] = 'El texto de la diapositiva no debe incluir caracteres de orden como '.$orderError.' .';
    }
    unset($P4_errors);


/* 5) Número de palabras por frase (15 palabras máximo por frase) */
/* 8) Uso de pronombres (2 máximo por frase) */
/* 10) Dirección del mensaje (Se debe usar la segunda persona) */
/* 11) Uso de forma pasiva (No usar forma pasiva de los verbos) */
/* 12) Sujeto de la oración (Las oraciones deben tener sujeto) */
/* 13) Composición de la oración (sujeto + verbo + complementos) */
    
    $P5_errors = array(); $P5_errors = array(); $P8_errors = array(); $P11_errors = array(); $P12_errors = array(); $P13_errors = array();

    $secondPersonCounter=0;
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
            //print_r($newArray);echo '<br>'; echo '<br>';
        
            /* [REGLA 5] */
            //Counting words per sentence obtained
            preg_match_all('/\pL+/u', $newArray[0], $nWords);
            if(count($nWords[0]) > 15){
                //echo 'ERROR: Existen frases con más de 15 palabras en la frase: '. $newArray[0] . '<br>';
            }
            
            //MORPHOLOGIC
            $prepCounter = 0; //Only prepositions per sentence must be taken into account.
            $passiveCounter = 0;
            $passiveAux = array(); //For special treatments in passive voice
            $preps = array();
            $passives = array();
            $syntax = array();
            
            //Function getMorphological, located at morphosyntacticAnalyzer.php file
            $arrayAnalysis = array();
            sleep(1); //Sleep 1 seconds cause of the API. (2 requests per second)
            $arrayAnalysis = getAnalysis($newArray[0]);
            //print_r($arrayAnalysis[0]); echo '<br>';
            
            //Loop through each word  
            foreach($arrayAnalysis[0] as $key => $value){
                //Morphological analysis is given in the format: [word]->description1, description2, ...
                $value = str_replace(',', '', $value);
                
                //Searching strings according to the rules
                /* [REGLA 8] */
                if(strstr($value, 'preposición')){
                    array_push($preps, $key);
                    $prepCounter++;
                }
                /* [REGLA 10] */
                if(strstr($value, '2')){
                    $secondPersonCounter++;
                }
                /* [REGLA 11] */
                if(strstr($value, 'pasiva')){
                    array_push($passives, $key);
                    $passiveCounter++;
                }
                /* [REGLA 12] */
                if(strstr($value, 'sujeto')){
                    array_push($syntax, 'sujeto');
                }
                /* Special treatments (se + verb) */
                if(strstr($value, 'nombre')){
                    array_push($passiveAux, 'nombre');
                }
                if(strstr($key, 'se')){
                    array_push($passiveAux, $key);
                }
                if(strstr($value, 'verbo') && in_array('se', $passiveAux) && !in_array('nombre', $passiveAux)){
                    $passiveCounter++;
                    unset($passiveAux);
                }
            }
            /* [REGLA 8] */
            if((int)$prepCounter > 2){
                $prepsFound=implode(", ", $preps);
                $textAnalyzerArray['P8'] = 'Las frases no pueden contener más de 2 preposiciones. La frase ['.$newArray[0].'] tiene las siguientes: ('.$prepsFound .')';
                //echo 'ERROR: Las frases no pueden contener más de 2 preposiciones. La frase ['.$newArray[0].'] tiene las siguientes: ('.$prepsFound .')';
            }
            /* [REGLA 10] */
        	if((int)$secondPersonCounter==0){
                $textAnalyzerArray['P10'] = 'No se encuentran expresiones en segunda persona en la frase ['.$newArray[0].']';
        	    //echo 'ERROR: No se encuentran expresiones en segunda persona en la frase ['.$newArray[0].']';
        	}            
            /* [REGLA 11] */
            if((int)$passiveCounter > 0){
                $passivesFound=implode(", ", $passives);
                $textAnalyzerArray['P11'] = 'Intenta no usar la voz pasiva. Como en la frase: ['.$newArray[0].']';
            	//echo 'ERROR: Intenta no usar la voz pasiva. Como en la frase: ['.$newArray[0].']';
            }
            
            // SYNTACTIC
            /* [REGLA 12] */
            if(!($arrayAnalysis[1][0]=='iof_isSubject')){
                $textAnalyzerArray['P12'] = 'Las oraciones deben tener sujeto. Error en la frase: ['.$newArray[0].']';
                //echo 'ERROR: Las oraciones deben tener sujeto. Error en la frase: ['.$newArray[0].']';echo '<br>';
            }
            /* [REGLA 13] */
            //Subject + verb + complements
            if(!($arrayAnalysis[1][0]=='iof_isSubject') && (!in_array('iof_isDirectObject', $arrayAnalysis) || !in_array('iof_isComplement', $arrayAnalysis))){
                $textAnalyzerArray['P13'] = 'Las oraciones deben tener la estructura: "sujeto + verbo + complementos". Error en la frase: ['.$newArray[0].']';
                //echo 'ERROR: Las oraciones deben tener la estructura: sujeto+verbo+complementos. Error en la frase: ['.$newArray[0].']'; echo '<br>';
            }
                
            //Removing processed sentence
            $paragraphs[$i] = iconv_substr($paragraphs[$i], (int)$arrayEnd[$k], (int)strlen($paragraphs[$i]));
        }
    }
    
 


// ** 6) Cantidad de texto por página (75 palabras por diapositiva)
    
    
/* 7) Formato de las fechas (13 de enero del 2017 en lugar de 13/01/2017) */
    
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
            $textAnalyzerArray['P7'] = 'Las siguientes fechas deberían tener un formato del estilo de "28 de marzo del 2018": '.$datesFound.'.';
            //echo "ERROR: las siguientes fechas deberían tener un formato del estilo de '<em>28 de marzo del 2018</em>':" . '<br>' . $datesFound. '<br>';
        }
    }

    
/* 9) Números romanos */

    //Iteration over the <p> returned by "getParagraphs" function
    $paragraphs = getParagraphs($pArray = array()); 
    for($i=0; $i<count($paragraphs); $i++) {

        //Looking for a Roman numerals
        if(preg_match_all("/\b(?:X?L?(?:X{0,3}(?:IX|IV|V|V?I{1,3})|IX|X{1,3})|XL|L)\b/", $paragraphs[$i], $roman)){
            //Converting array of Roman numerals to string
            $numeralsFound=implode(", ", $roman[0]);
            $textAnalyzerArray['P9'] = 'El texto no puede contener números romanos: '.$numeralsFound.'.';
            //echo "ERROR: no puede haber números romanos: " . $numeralsFound;
        }
    }
    
    
    return $textAnalyzerArray;
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

?>