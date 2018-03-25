<?php	
    $q='https://api.textgain.com/1/tag?q=El+Real+Madrid+es+el+mejor+equipo+del+mundo.&lang=es&key=***';

    $data = json_decode(file_get_contents($q), true);
    print_r($data);
    echo $data["text"];

    // 1) Longitud de las líneas
    
    // 2) Números grandes
    
    // 3) Caracteres especiales
    
    // 4) Caracteres de orden
    
    // 5) Número de palabras por frase
    
    // 6) Cantidad de texto por página
    
    // 7) Formato de las fechas
    
    // 8) Uso de pronombres
    
    // 9) Números romanos
    
    // 10) Dirección del mensaje
    
    // 11) Uso de forma pasiva
    
    // 12) Sujeto de la oración
    
    // 13) Composición de la oración
?>