<?php

if(!isset($_SESSION)){ session_start(); } 

function designAnalyzer(){
   
    include_once ("./analyzer/textConverter.php");
    $file_uploaded = $_SESSION['file_uploaded'];
    $file_uploaded = './input' . $file_uploaded . '.html';
    
    //HTML DOM structure
    $doc = new DOMDocument();
    $doc->loadHTMLFile($file_uploaded);
    $doc->saveHTML();
    $xpath = new DOMXpath($doc);

    $designAnalyzerArray = array();
    
    //Function allText, located at textConverter.php file
    $slideTags = allText();
    
    
/* 1) La fuente del texto pertenece a los estilos aceptados */

    $P1_errors = array();
    //Definition of tags wich can include font-family
    $textTags = $xpath->query('//body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $accepted_fonts = array("Arial", "Calibri", "Candara", "Corbel", "Gill Sans", "Helvética", "Myriad", "Segoe", "Tahoma", "Tiresias", "Verdana");
    $length = $textTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $textTags->item($i);
        
        //Get the substring of style="" if we have a font-family
        $pos = strpos($element->getAttribute('style'), 'font-family');

        if(gettype($pos)=='integer'){
            $subString = substr($element->getAttribute('style'), (int)$pos);

            //Split style elements in order to search font-family
            list($fontFamily, $value) = split('[:;]', $subString);
            $value = trim($value);
            
            if (!in_array($value, $accepted_fonts)) {
                array_push($P1_errors, $value);
                //echo "ERROR, fuente no aceptada: " . $value;
            }
        }
    }
    if (!empty($P1_errors)){
        $fontsError = implode(", ", $P1_errors);
        $designAnalyzerArray['P1'] = 'Tu diapositiva contiene fuentes no aceptadas: '. $fontsError;
    }
    unset($P1_errors);
    
    
/* 2) El tamaño del texto tiene que ser como mínimo 12 y como máximo 16	*/

    $P2_errors = array();
    //Definition of tags wich can include font-size
    $textTags = $xpath->query('//body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $textTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $textTags->item($i);
        
        //Get the substring of style="" if we have a font-size
        $pos = strpos($element->getAttribute('style'), 'font-size');

        if(gettype($pos)=='integer'){
            $subString = substr($element->getAttribute('style'), (int)$pos);
            
            //Split style elements in order to search font-size
            list($fontSize, $value) = split('[:;]', $subString);
            
            if (!((double)$value >= 12) && ((double)$value <= 16)){
                array_push($P2_errors, trim($value));
                //echo "ERROR, el tamaño del texto debe estar entre 12 y 16";
            }
        }
    }
    if (!empty($P2_errors)){
        $sizeError = implode(", ", $P2_errors);
        $designAnalyzerArray['P2'] = 'Existen fuentes con tamaño ('.$sizeError.'). Recuerda que el tamaño permitido está entre 12 y 16.';
    }
    unset($P2_errors);    


/* 3) No existe texto en cursiva */

    $P3_errors = 0;
    //Definition of tags wich can include italic font. (<em>/<i>/or <... style="font-style: italic")
    $italicTags = $xpath->query('//em | //i  | //body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $italicTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $italicTags->item($i);
        
        //If <em> or <i> appears in html, we got an error
        if ($element->tagName == ('em') || $element->tagName == ('i')) {
            $P3_errors++;
            //echo "ERROR, no debe existir texto en cursiva";
        } 
        else{        
            //Get the substring of style="" if we have a font-style
            $pos = strpos($element->getAttribute('style'), 'font-style');
    
            if(gettype($pos)=='integer'){
                $subString = substr($element->getAttribute('style'), (int)$pos);
                
                //Split style elements in order to search font-style
                list($fontStyle, $value) = split('[:;]', $subString);
                $value = trim($value);

                if (strcmp($value,'italic')==0){
                    $P3_errors++;
                    //echo "ERROR, no debe existir texto en cursiva";
                }
            }
        }
    }
    if ($P3_errors != 0){
        $designAnalyzerArray['P3'] = 'No debe existir texto en cursiva. Es decir, evita el uso de las etiquetas <em> o <i>, así como del estilo de fuente "italic"';
    }



/* 4) No existen más de un % de palabras en negrita	 (5 palabras_incluido) */

    //Definition of tags wich can include bold font. (<b> or <strong> or <... style="font-style: bold")
    $boldTags = $xpath->query('//b | //strong | //body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $boldTags->length;
    
    $countBold=0;
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $boldTags->item($i);
        
        //If <b> or <strong> appears in html more than 5 times, we got an error
        if ($element->tagName == ('b') || $element->tagName == ('strong')) {
            $countBold++;
        } 
        else{        
            //Get the substring of style="" if we have a font-style
            $pos = strpos($element->getAttribute('style'), 'font-style');
    
            if (gettype($pos)=='integer'){
                $subString = substr($element->getAttribute('style'), (int)$pos);
                
                //Split style elements in order to search font-style
                list($fontStyle, $value) = split('[:;]', $subString);
                $value = trim($value);

                if (strcmp($value,'bold')==0){
                    $countBold++;
                }
            }
        }
    }
    if ((int)$countBold > 5){
        $designAnalyzerArray['P4'] = 'En tu diapositiva hay demasiadas palabras en negrita('.$countBold .'). Intenta tener un número inferior a 6.';
        //echo "ERROR, no debe más de un % de palabras en negrita";
    }
    

/* 5) No existen más de un % de palabras subrayadas (5 palabras_incluido) */
   
    //Definition of tags wich can include underline font. (<u>  or <... style="text-decoration: underline")
    $underlineTags = $xpath->query('//u | //body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $underlineTags->length;
    
    $countUnderline=0;
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $underlineTags->item($i);
        
        //If <b> or <strong> appears in html more than 5 times, we got an error
        if ($element->tagName == ('u')) {
            $countUnderline++;
        } 
        else{        
            //Get the substring of style="" if we have "text-decoration: underline"
            $pos = strpos($element->getAttribute('style'), 'text-decoration');
    
            if (gettype($pos)=='integer'){
                $subString = substr($element->getAttribute('style'), (int)$pos);
                
                //Split style elements in order to search font-style
                list($fontStyle, $value) = split('[:;]', $subString);
                $value = trim($value);

                if (strcmp($value,'underline')==0){
                    $countUnderline++;
                }
            }
        }
    }
    if ((int)$countUnderline > 5){
        $designAnalyzerArray['P5'] = 'En tu diapositiva hay demasiadas palabras subrayadas('.$countUnderline .'). Intenta tener un número inferior a 6.';
        //echo "ERROR, no debe más de un % de palabras subrayadas";
    }
    
    
/* 6) No existen textos con sombreado */

    $P6_errors = 0;
    //Definition of tags wich can include "style="text-shadow"
    $shadowTags = $xpath->query('//body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $shadowTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $shadowTags->item($i);
        
        //Get the substring of style="" if we have text-shadow in the text
        $pos = strpos($element->getAttribute('style'), 'text-shadow');

        if(gettype($pos)=='integer'){
            $P6_errors++;
            //echo "ERROR, no pueden existir textos con sombreado";
        }
    }
    if ($P6_errors != 0){
        $designAnalyzerArray['P6'] = 'No puede existir texto sombreado. Por tanto, evita el uso del estilo "text-shadow".';
    }

    
    
/* 7) No existen más de un % de palabras en mayúsculas (5 palabras_incluido) */

    //Iteration over the tags returned by "allText" function
    $j=0; $nWordsCapital=0;
    foreach ($slideTags as $tag) {
        //We must split into words
        $nWordsTag = explode(" ", trim($slideTags[$j]));
        
        //Loop through each word. If we find a capital letter, counter is increased.  
        foreach($nWordsTag as $arr){
            if (ctype_upper($arr)){
               //echo "La cadena  consiste completamente de letras mayúsculas. <br>";
               $nWordsCapital++;
            } 
        }
        $j++;
    }
    if ((int)$nWordsCapital > 5){
        $designAnalyzerArray['P7'] = 'Has superado el límite establecido (5) de palabras completamente en mayúsculas.';
        //echo "ERROR, has superado el límite de mayúsculas establecido";
    }


    
    
/* 8) Color de fuente negro */	

    $P8_errors = 0;
    //Definition of tags wich can include "style="color"
    $colorTags = $xpath->query('//body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $colorTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $colorTags->item($i);
        
        //Get the substring of style="" if we have a color
        $pos = strpos($element->getAttribute('style'), 'color');

        if(gettype($pos)=='integer'){
            $subString = substr($element->getAttribute('style'), (int)$pos);
            
            //Split style elements in order to search color
            list($fontColor, $value) = split('[:;]', $subString);
            $value = trim($value);
            
            if (!(strcmp($value,'#000000')==0 ||  strcmp($value,'black')==0 || strcmp($value,'#Hex_RGB')==0)){
                $P8_errors++;
                //echo "ERROR, el color de fuente debe ser negro";
            }
        }
    }
    if ($P8_errors != 0){
        $designAnalyzerArray['P8'] = 'El color de la fuente debe ser negro. Este se puede indicar mediante los valores de color #000000, black o #Hex_RGB.';
    }
    
      
/* 9) Color de fondo blanco sólido	*/

    $P9_errors = 0;
    //Definition of tags wich can include "style="background-color o background"
    $backgroundTags = $xpath->query('//body | //span | //div');
    $length = $backgroundTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $backgroundTags->item($i);
        
        //Get the substring of style="" if we have background or background-color
        $pos = strpos($element->getAttribute('style'), 'background');
       
        if(gettype($pos)=='integer'){
            $subString = substr($element->getAttribute('style'), (int)$pos);
            
            //Split style elements in order to search background-color
            list($fontBackgroundColor, $value) = split('[:;]', $subString);
            $value = trim($value);
            
            if (!(strcmp($value,'#FFFFFF')==0 ||  strcmp($value,'white')==0)){
                $P9_errors++;
                //echo "ERROR, el color de fondo debe ser blanco sólido";
            }
        }
    }
    if ($P9_errors != 0){
        $designAnalyzerArray['P9'] = 'El color de fondo debe ser blanco. Este se puede indicar mediante los valores de background o background-color #FFFFFF o white.';
    }
    
    
/* 10) Cantidad de palabras en la diapositiva no supera el límite establecido (50 palabras) */

    //Counting all words in array returned by "allText" function
    $i=0; $nWordsSlide = 0; 
    foreach ($slideTags as $tag) {
        $nWordsTag = count(explode(" ", trim($slideTags[$i])));
        $i++;
        $nWordsSlide = $nWordsSlide + $nWordsTag;
    }
    //echo '[ '.$nWordsSlide.']';
    if ((int)$nWordsSlide > 50){
        $designAnalyzerArray['P10'] = 'La diapositiva contiene '.$nWordsSlide.' palabras, y el límite está establecido en 50.';
        //echo "ERROR, has superado el límite de palabras establecido";
    }
    
    
    return $designAnalyzerArray;
}
?>