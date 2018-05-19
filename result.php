<?php
    if(!isset($_SESSION)){ 
        session_start();
        include_once ("./analyzer/textAnalyzer.php");
        include_once ("./analyzer/designAnalyzer.php");
        $textResult = textAnalyzer();
        $designResult = designAnalyzer();
    }
    //Get the file uploaded, included in session
    $file_uploaded = $_SESSION['file_uploaded'];
    
    /*Scores 
      (Score_X * 100(%)) / Total(Score_X of each one(Desing and Text)*/
    $textScore = array();
    $textScore['P1'] = (8*100)/152;
    $textScore['P2'] = (4*100)/152;    
    $textScore['P3'] = (8*100)/152;
    $textScore['P4'] = (2*100)/152;
    $textScore['P5'] = (6*100)/152;
    $textScore['P6'] = (1*100)/152;
    $textScore['P7'] = (3*100)/152;
    $textScore['P8'] = (8*100)/152;
    $textScore['P9'] = (10*100)/152;
    $textScore['P10'] = (10*100)/152;
    $textScore['P11'] = (8*100)/152;
    $textScore['P12'] = (9*100)/152;
    
    $designScore = array();
    $designScore['P1'] = (10*100)/152;
    $designScore['P2'] = (10*100)/152;    
    $designScore['P3'] = (8*100)/152;
    $designScore['P4'] = (7*100)/152;
    $designScore['P5'] = (6*100)/152;
    $designScore['P6'] = (5*100)/152;
    $designScore['P7'] = (4*100)/152;
    $designScore['P8'] = (8*100)/152;
    $designScore['P9'] = (9*100)/152;
    $designScore['P10'] = (8*100)/152;
    
    //Text to be printed into result's page
    $pautasText = array();
    $pautasText['P1'] = "El tamaño de las líneas debe de ser inferior a 60 caracteres";
    $pautasText['P2'] = "Evitar el uso de números grandes";
    $pautasText['P3'] = "Evitar el uso de caracteres especiales";
    $pautasText['P4'] = "Evitar el uso de caracteres de orden";
    $pautasText['P5'] = "Evitar el uso de más de 15 palabras por frase";
    $pautasText['P6'] = "Escribir las fechas al completo";
    $pautasText['P7'] = "Evitar abusar de los pronombres";
    $pautasText['P8'] = "No utilizar números romanos";
    $pautasText['P9'] = "Dirigir el mensaje a la audiencia usando la 2ª persona";
    $pautasText['P10'] = "No utilizar la forma pasiva";
    $pautasText['P11'] = "Las oraciones han de tener sujeto";
    $pautasText['P12'] = "Las oraciones deben seguir el orden de: sujeto + verbo + complementos";
    
    $pautasDesign = array();
    $pautasDesign['P1'] = "La fuente del texto pertenece a los estilos aceptados";
    $pautasDesign['P2'] = "El tamaño del texto tiene que ser como mínimo 12 y como máximo 16";
    $pautasDesign['P3'] = "No existe texto en cursiva";
    $pautasDesign['P4'] = "No existen más de un % de palabras en negrita";
    $pautasDesign['P5'] = "No existen más de un % de palabras subrayadas";
    $pautasDesign['P6'] = "No existen textos con sombreado";
    $pautasDesign['P7'] = "No existen más de un % de palabras en mayúsculas";
    $pautasDesign['P8'] = "Color de fuente negro";
    $pautasDesign['P9'] = "Color de fondo blanco sólido";
    $pautasDesign['P10'] = "Cantidad de palabras en la diapositiva no supera el límite establecido (50)";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Application that provides an easy-to-read analysis">
    <meta name="author" content="Jorge López-Guerrero Iglesias">
    <title>Easy-to-Read Advisor</title> 
    
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384 BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   
    <!-- Custom styles -->
    <link rel="shortcut icon" type="image/png" href="./images/logo_etr.png"/> 
    <link rel="stylesheet" href="./styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>
    
<body onload="load()">
    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="row">
                <!-- Logo -->
              <div class="navbar-header col-md-1 col-sm-2">
                  <a href="/"><img src="./images/logo_etr.png" alt="ETR Advisor"></a>
              </div>
              <!-- App text -->
              <div class="navbar-header col-md-5 col-sm-8" style="margin-left: 20px;">
                  <h1>Easy-to-Read Advisor
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarMain">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                      </button>
                  </h1>
              </div>
              <!-- Buttons -->
              <div id="navbarMain" class="navbar-collapse collapse col-md-6 col-sm-2">
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="/"><span class="glyphicon glyphicon-home" style="margin-right: 10px;"></span>Inicio</a></li>
                      <li><a href="#puntuacion"><span class="glyphicon glyphicon-screenshot" style="margin-right: 10px;"></span>Puntuación</a></li>
                      <li><a href="#analisis"><span class="glyphicon glyphicon-dashboard" style="margin-right: 10px;"></span>Análisis</a></li>
                      <li><a href="#pautas"><span class="glyphicon glyphicon-pencil" style="margin-right: 10px;"></span>Pautas</a></li>
                  </ul>
              </div>
          </div>
        </div>
    </nav>
    
    <div id="loader"></div>
    <h1 id="textWait">Analizando tu diapositiva</h1>
    
    <div class="time" style="display:none;" id="myDiv">
        
        <!-- Score -->
        <div class="well" id="puntuacion" style="margin-top: 0px">
                <h3 style="text-align:center; font-size: 40px; font-style: italic">Puntuación</h3>
        </div>
        <div class="row featurette" id="score">
            <h4>Has obtenido una valoración de:</h4> 
            <h2 style="font-size: 50px; font-weight: 500;">
                <?php
                //If textResult array doesn't contain a key, that means that this one is correct.
                    if(!empty($file_uploaded)){
                        $finalScore=0;
                        //Text
                        foreach($textScore as $key => $value){
                            if(!array_key_exists ($key, $textResult)){
                                $finalScore += $textScore[$key];
                                $finalTextScore += $textScore[$key];
                            }
                        }
                        //Design
                        foreach($designScore as $key => $value){
                            if(!array_key_exists ($key, $designResult)){
                                $finalScore += $designScore[$key];
                                $finalDesignScore += $designScore[$key];
                            }
                        }
                        echo round($finalScore)."%";
                    }else{
                        echo "-";
                    }
                ?>
            </h2>
            <div class="progress" style="margin-left:20%; margin-top: 2% ;width: 70%;">
              <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
              style=<?php echo 'width:' .$finalScore.'%'; ?> ></div>
            </div>
            <?php $var = $_GET['file']; ?>
            
            <img src='../images/html_file.png'> <h4> <?php if(!empty($file_uploaded)) echo "$var"; ?> </h4></img>
                <div class="info" style="cursor:help">
                    <img src="./images/folder.jpg" alt="info" style="margin-left: 8px">
                        <span class="infoFile">
                            <?php
                                $file_upload = './input' . $file_uploaded . '.html';
                                echo file_get_contents($file_upload, true); 
                            ?>
                        </span> 
                </div>
        </div>
      
        <hr class="featurette-divider">
         
         <!-- Análisis -->
        <div class="well" id="analisis" style="margin-top: 0px">
                <h3 style="text-align:center; font-size: 40px; font-style: italic">Análisis de resultados</h3>
        </div>
        <div class="row featurette">         
            <div class="row">
                <div class="col-12" id="resultados">
                    <h2 style="margin-bottom: 25px; font-size: 34px; font-weight: bolder">Resultados</h2> 
                    <h5 style="font-size: 22px; font-family: Times New Roman, Times, serif; margin: 20px; color: midnightblue; font-weight: bolder"> 
                        <?php 
                            if(empty($file_uploaded)){
                                echo "- correctos / - incorrectos";                        
                            } else{
                                $incorrects=count($designResult)+count($textResult);
                                $corrects= 22 - $incorrects;  
                                echo "$corrects correctos / $incorrects incorrectos"; 
                            }
                        ?>
                    </h5>
                        <div class='panel-group'>
                        <?php

                        if(!empty($file_uploaded)){
                            $i=0;
                            foreach($pautasDesign as $key => $value){
                                if(array_key_exists ($key, $designResult)){ ?>
                                     <div class='panel panel-danger'>
                                        <div class='panel-heading'>
                                            <h4 class='panel-title'><a data-toggle='collapse' <?php echo "href=#$key >"; echo $pautasDesign[$key]; ?>
                                                <span class="glyphicon glyphicon-alert" style="margin-left: 10px; color: salmon"></span>
                                            </a></h4>
                                        </div>
                                        <div <?php echo "id=$key "; ?> class='panel-collapse collapse'>
                                          <div class='panel-body' style="font-size: 16px"><?php echo $designResult[$key]; ?></div>
                                        </div>
                                      </div>
                                <?php } else { ?>
                                    <div class='panel panel-success'>
                                        <div class='panel-heading'>
                                            <h4 class='panel-title'><?php echo $pautasDesign[$key]; ?></h4>
                                        </div>
                                    </div>
                               <?php }
                                $i++;
                            }
                        }
                        ?>
                        <?php
                        $j=0;
                        if(!empty($file_uploaded)){
                            foreach($pautasText as $key => $value){
                                if(array_key_exists ($key, $textResult)){ ?>
                                     <div class='panel panel-danger'>
                                        <div class='panel-heading'>
                                            <h4 class='panel-title'><a data-toggle='collapse' <?php echo "href=#$key"."_2 >"; echo $pautasText[$key]; ?>
                                                <span class="glyphicon glyphicon-alert" style="margin-left: 10px; color: salmon"></span>
                                            </a></h4>
                                        </div>
                                        <div <?php echo "id=$key"."_2 "; ?> class='panel-collapse collapse'>
                                          <div class='panel-body'><?php echo $textResult[$key]; ?></div>
                                        </div>
                                      </div>
                                <?php } else { ?>
                                    <div class='panel panel-success'>
                                        <div class='panel-heading'>
                                            <h4 class='panel-title'><?php echo $pautasText[$key]; ?></h4>
                                        </div>
                                    </div>
                               <?php }
                                $j++;
                            }
                        }
                        ?>
                        </div>
                </div>
            </div>
            <div class="row" id="categoria">
                <div class="col-12">
                    <h2 style="margin-bottom: 0px; margin-top: 35px; font-weight: bolder">Puntuación por categoría</h2>
            	     <div class="row" style="padding-top: 2%">
                          <div class="col-md-4">
                            <div style="margin: 0 4em 2em; max-width: 700px;">
                              <canvas id="pie-chart" width="800" height="650"></canvas>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div style="margin: 0 4em 2em; max-width: 700px;">
                              <canvas id="pie-chart2" width="800" height="650"></canvas>
                            </div>
                        </div>
                          <div class="col-md-4">
                            <div style="margin: 0 4em 2em; max-width: 700px;">
                              <canvas id="pie-chart3" width="800" height="650"></canvas>
                            </div>
                          </div>
                    </div>
                </div>
            </div>

        </div>
        
        <hr class="featurette-divider">
        
        <!-- Points -->
        <div class="well" id="pautas" style="margin-top: 0px">
                <h3 style="text-align:center; font-size: 40px; font-style: italic">Pautas</h3>
        </div>
        <div class="row featurette"> 
                <div id="descripTables"> 
                  <h4>Las tablas representan la puntuación sobre 10 que se le da a cada pauta, debido a que cada una posee una importancia diferente. </h4>
                  <h6><em>La valoración final se hará teniendo en cuenta dicha ponderación sobre un total de 100. 
                          Es decir: Sumatorio de cada pauta acertada multiplicada por 100, y dividida entre 152 (suma total de puntos de texto y maquetación)</em>
                  </h6> 
                </div>
              <div class="col-md-6"> 
                  <div class="panel panel-info" style="margin: 20px 20px 0px 20px">
                      <div class="panel-heading" style="text-align: center; font-size: 20px; color:black">TEXTO</div>
                      <table class="table table-hover">
                          <tbody>
                              <tr>
                                  <td>El tamaño de las líneas debe de ser inferior a 60 caracteres</td>
                                  <td>8 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar el uso de números grandes</td>
                                  <td>4 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar el uso de caracteres especiales</td>
                                  <td>8 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar el uso de caracteres de orden</td>
                                  <td>2 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar el uso de más de 15 palabras por frase</td>
                                  <td>6 puntos</td>
                              </tr>
                              <tr>
                                  <td>Escribir las fechas al completo
                                      <div class="info">
                                          <img  src="./images/info.png" alt="info" style="margin-left: 8px">
                                          <span class="infoText2">
                                              <dl>
                                                  <dt><span class="glyphicon glyphicon-ok"></span></dt>
                                                  <dd>22 de junio del 2018</dd>
                                                  <dt><span class="glyphicon glyphicon-remove"></span></dt>
                                                  <dd>22/06/2018</dd>   
                                              </dl>
                                          </span> 
                                  </div>
                                      </td>
                                  <td>1 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar abusar de los pronombres</td>
                                  <td>3 puntos</td>
                              </tr>
                              <tr>
                                  <td>No utilizar números romanos</td>
                                  <td>8 puntos</td>
                              </tr>
                              <tr>
                                  <td>Dirigir el mensaje a la audiencia usando la 2ª persona</td>
                                  <td>10 puntos</td>
                              </tr>
                              <tr>
                                  <td>No utilizar la forma pasiva</td>
                                  <td>10 puntos</td>
                              </tr>
                              <tr>
                                  <td>Las oraciones han de tener sujeto</td>
                                  <td>8 puntos</td>
                              </tr>
                              <tr>
                                  <td>Las oraciones deben seguir el orden de: sujeto + verbo + complementos</td>
                                  <td>9 puntos</td>
                              </tr>
                              <!--tr>
                                <td></td>
                                  <td style="font-weight: bolder">50 puntos</td>
                              </tr-->
                          </tbody>
                      </table>
                  </div>
              </div>
              <div class="col-md-6">  
                  <div class="panel panel-warning" style="margin: 20px 20px 0px 20px">
                      <div class="panel-heading" style="text-align: center; font-size: 20px; color: black">MAQUETACIÓN</div>
                      <table class="table table-hover">
                          <tbody>
                              <tr>
                                  <td>
                                      La fuente del texto pertenece a los estilos aceptados
                                      <div class="info">
                                          <img src="./images/info.png" alt="info" style="margin-left: 8px">
                                          <span class="infoText">
                                              <ul>
                                                <li>Arial</li>
                                                <li>Calibri</li>
                                                <li>Candara</li>
                                                <li>Corbel</li>
                                                <li>Gill Sans</li>
                                                <li>Helvética</li>
                                                <li>Myriad</li>
                                                <li>Segoe</li>
                                                <li>Tahoma</li>
                                                <li>Tiresias</li>
                                                <li>Verdana</li>
                                              </ul>
                                          </span> 
                                      </div>
                                  </td>
                                  <td>10 puntos</td>
                              </tr>
                              <tr>
                                  <td>El tamaño del texto tiene que ser como mínimo 12 y como máximo 16</td>
                                  <td>10 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existe texto en cursiva</td>
                                  <td>8 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existen más de un % de palabras en negrita</td>
                                  <td>7 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existen más de un % de palabras subrayadas</td>
                                  <td>6 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existen textos con sombreado</td>
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existen más de un % de palabras en mayúsculas</td>
                                  <td>4 puntos</td>
                              </tr>
                              <tr>
                                  <td>Color de fuente negro</td>
                                  <td>8 puntos</td>
                              </tr>
                              <tr>
                                  <td>Color de fondo blanco sólido</td>
                                  <td>9 puntos</td>
                              </tr>
                              <tr>
                                  <td>Cantidad de palabras en la diapositiva no supera el límite establecido</td>
                                  <td>8 puntos</td> 
                              </tr>
                              <!--tr>
                                <td></td>
                                  <td style="font-weight: bolder">50 puntos</td>
                              </tr-->
                          </tbody>
                      </table>
                  </div>
              </div>
           </div>
	
    
        <!-- Footer -->    
        <footer style="text-align: left; margin: 55px 0px 15px 15px; font-weight: bolder">
            <p>&copy; Escuela Técnica Superior de Ingenieros Informáticos (UPM).</p>
        </footer>
    </div>
    
    
    <!-- Button back-to-top -->
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click para subir" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>
    
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="./scripts/loading.js"></script>
    <script src="./scripts/top.js"></script>
    <script>
      new Chart(document.getElementById("pie-chart"), {
          type: 'pie',
          data: {
            labels: ["Texto", "Maquetación", "Fallos"],
            datasets: [{
              label: "Porcentaje de cada categoría",
              backgroundColor: ["#FFD700", "#1E90FF","#F8F8FF"],
              data: [
                        '<?php echo round($finalTextScore, 2); ?>', 
                        '<?php echo round($finalDesignScore, 2); ?>', 
                        '<?php echo round((100-(round($finalTextScore,2) + round($finalDesignScore,2))), 2); ?>'
                    ]
            }]
          },
          options: {
            title: {
              display: true,
              text: 'Porcentaje de aciertos global'
            }
          }
      });
    </script>
    <script>
      new Chart(document.getElementById("pie-chart2"), {
          type: 'pie',
          data: {
            labels: ["Aciertos", "Fallos"],
            datasets: [{
              label: "Porcentaje de cada categoría",
              backgroundColor: ["#1E90FF","#e6f5ff"],
              data: [
                        '<?php echo round($finalDesignScore, 2); ?>',
                        '<?php echo round((100 - round($finalDesignScore, 2)), 2); ?>'
                    ]
            }]
          },
          options: {
            title: {
              display: true,
              text: 'Porcentaje de aciertos en maquetación'
            }
          }
      });
    </script>
    <script>
      new Chart(document.getElementById("pie-chart3"), {
          type: 'pie',
          data: {
            labels: ["Aciertos", "Fallos"],
            datasets: [{
              label: "Porcentaje de cada categoría",
              backgroundColor: ["#FFD700","#FDF5E6"],
              data: [
                        '<?php echo round($finalTextScore, 2); ?>', 
                        '<?php echo round(100 - round($finalTextScore, 2), 2); ?>']
            }]
          },
          options: {
            title: {
              display: true,
              text: 'Porcentaje de aciertos en texto'
            }
          }
      });
    </script>
</body>
</html>