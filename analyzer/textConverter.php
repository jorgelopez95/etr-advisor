<?php

        //$file = $_GET['file'];  $doc->loadHTMLFile($file);

/**
 * In this funtion, the whole text is pulled from the html file
 **/
    function allText($text = array()){
        //HTML DOM structure
        $doc = new DOMDocument();
        $doc->loadHTMLFile("../input/tmp/phpHV46rO.html");
        $doc->saveHTML();        

        //Searching tags that can include text
        $h1 = $doc->getElementsByTagName('h1');
        foreach ($h1 as $textTag) {
            array_push($text, $textTag->nodeValue);
        }
        $h2 = $doc->getElementsByTagName('h2');
        foreach ($h2 as $textTag) {
            array_push($text, $textTag->nodeValue);
        }
        $h3 = $doc->getElementsByTagName('h3');
        foreach ($h3 as $textTag) {
            array_push($text, $textTag->nodeValue);
        }
        $h4 = $doc->getElementsByTagName('h4');
        foreach ($h4 as $textTag) {
            array_push($text, $textTag->nodeValue);
        }
        $h5 = $doc->getElementsByTagName('h5');
        foreach ($h5 as $textTag) {
            array_push($text, $textTag->nodeValue);
        }
        $h6 = $doc->getElementsByTagName('h6');
        foreach ($h6 as $textTag) {
            array_push($text, $textTag->nodeValue);
        }
        $p = $doc->getElementsByTagName('p');
        foreach ($p as $textTag) {
            array_push($text, $textTag->nodeValue);
        }
        $a = $doc->getElementsByTagName('a');
        foreach ($a as $textTag) {
            array_push($text, $textTag->nodeValue);
        }
        return $text;
    }

    
/**
* In this funtion, only the text placed into <p> tags is taked into account
**/
    function getParagraphs($text = array()){
        //HTML DOM structure
        $doc = new DOMDocument();
        $doc->loadHTMLFile("../input/tmp/phpHV46rO.html");
        $doc->saveHTML();        

        //Searching tags that can include text
        $p = $doc->getElementsByTagName('p');
        foreach ($p as $textTag) {
            array_push($text, $textTag->nodeValue);
        }
        return $text;
    }
?>