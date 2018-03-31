<?php
    include ("./textConverter.php");
    
    //HTML DOM structure
    $doc = new DOMDocument();
    $doc->loadHTMLFile("../input/tmp/phpHV46rO.html");
    $doc->saveHTML();
    $xpath = new DOMXpath($doc);

    //Function allText, located at textConverter.php file
    $allText = allText($textArray = array());
    
    
/* 1) La fuente del texto pertenece a los estilos aceptados */

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
                echo "ERROR, fuente no aceptada: " . $value;
            }
        }
    }
    
    
/* 2) El tamaño del texto tiene que ser como mínimo 12 y como máximo 16	*/

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
                //echo "ERROR, el tamaño del texto debe estar entre 12 y 16";
            }
        }
    }
        

/* 3) No existe texto en cursiva */

    //Definition of tags wich can include italic font. (<em>/<i>/or <... style="font-style: italic")
    $italicTags = $xpath->query('//em | //i  | //body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $italicTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $italicTags->item($i);
        
        //If <em> or <i> appears in html, we got an error
        if ($element->tagName == ('em') || $element->tagName == ('i')) {
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
                    //echo "ERROR, no debe existir texto en cursiva";
                }
            }
        }
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
    if ($countBold > 5){
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
    if ($countUnderline > 5){
        //echo "ERROR, no debe más de un % de palabras subrayadas";
    }
    
    
/* 6) No existen textos con sombreado */

    //Definition of tags wich can include "style="text-shadow"
    $shadowTags = $xpath->query('//body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $shadowTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $shadowTags->item($i);
        
        //Get the substring of style="" if we have text-shadow in the text
        $pos = strpos($element->getAttribute('style'), 'text-shadow');

        if(gettype($pos)=='integer'){
            //echo "ERROR, no pueden existir textos con sombreado";
        }
    }
    
    
/* 7) No existen más de un % de palabras en mayúsculas (5 palabras_incluido) */

    //Iteration over the tags returned by "allText" function
    $j=0; $nWordsCapital=0;
    foreach ($allText as $tag) {
        //We must split into words
        $nWordsTag = explode(" ", trim($allText[$j]));
        
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
        //echo "ERROR, has superado el límite de mayúsculas establecido";
    }


    
    
/* 8) Color de fuente negro */	

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
                //echo "ERROR, el color de fuente debe ser negro";
            }
        }
    }
    
      
/* 9) Color de fondo blanco sólido	*/

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
                //echo "ERROR, el color de fondo debe ser blanco sólido";
            }
        }
    }
    
    
/* 10) Cantidad de palabras en la diapositiva no supera el límite establecido (50 palabras) */

    //Counting all words in array returned by "allText" function
    $i=0; $nWordsSlide = 0; 
    foreach ($allText as $tag) {
        $nWordsTag = count(explode(" ", trim($allText[$i])));
        $i++;
        $nWordsSlide = $nWordsSlide + $nWordsTag;
    }
    //echo '[ '.$nWordsSlide.']';
    if ((int)$nWordsSlide > 50){
        //echo "ERROR, has superado el límite de palabras establecido";
    }
?>