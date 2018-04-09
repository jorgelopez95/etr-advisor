<?php
   if(!isset($_SESSION)){ session_start(); } 
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
    <style>
        #chartdiv{
            width: 100%; height: 350px; font-size: 20px;
        }
        #chartdiv .amcharts-chart-div a{
            display: none !important;
        }
    </style>
</head>
    
<body onload="load()">
    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="row">
                <!-- Logo -->
              <div class="navbar-header col-md-1 col-sm-2">
                  <a href="/"><img src="./images/logo_etr.png" alt="ETR Advisor"> </a>
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
        <div class="row featurette" class="row">
            <h4>Has obtenido una valoración de:</h4> 
            <h2 style="font-size: 50px; font-weight: 500;">90/100</h2>
            <div class="progress" style="margin-left:20%; margin-top: 2% ;width: 70%;">
              <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 89%"></div>
            </div>
            <?php
            $var = $_GET['file'];
    
            echo "<img src='../images/html_file.png'> <h4>$var</h4></img>"
            ?>
        </div>
      
        <hr class="featurette-divider">
         
         <!-- Análisis -->
        <div class="well" id="analisis" style="margin-top: 0px">
                <h3 style="text-align:center; font-size: 40px; font-style: italic">Análisis de resultados</h3>
        </div>
        <div class="row featurette">         
            <div class="row">
                <div class="col-md-12">
                    <h2 style="margin-bottom: 0px">Resultados</h2> 
                    <?php
                        include_once ("./analyzer/textAnalyzer.php");
                        include_once ("./analyzer/designAnalyzer.php");
                        $textResult = textAnalyzer();
                        $designResult = designAnalyzer();
                        
                        //Bucles recorriendo estos arrays y pintando los resultados
                        print_r($designResult);
                        echo '<br>';echo '<br>';
                        print_r($textResult);
                        
                        //echo "<h5>$designResult</h5> <br>>";
                        //Destruir session
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2 style="margin-bottom: 0px">Puntuación por categoría</h2> 
                </div>
            </div>
            <div id="chartdiv"></div>
        </div>
        
        <hr class="featurette-divider">
        
        <!-- Points -->
        <div class="well" id="pautas" style="margin-top: 0px">
                <h3 style="text-align:center; font-size: 40px; font-style: italic">Pautas</h3>
        </div>
        <div class="row featurette"> 
              <div class="col-md-6"> 
                  <div class="panel panel-info" style="margin: 20px 20px 0px 20px">
                      <div class="panel-heading" style="text-align: center; font-size: 20px; color:black">TEXTO</div>
                      <table class="table table-hover">
                          <tbody>
                              <tr>
                                  <td>El tamaño de las líneas debe de ser inferior a 60 caracteres</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar el uso de números grandes</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar el uso de caracteres especiales</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar el uso de caracteres de orden</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar el uso de más de 15 palabras por frase</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar escribir más de 75 palabras por diapositiva</td>
                                  <td>3,85 puntos</td>
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
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>Evitar abusar de los pronombres</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>No utilizar números romanos</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>Dirigir el mensaje a la audiencia usando la 2ª persona</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>No utilizar la forma pasiva</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>Las oraciones han de tener sujeto</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                  <td>Las oraciones deben seguir el orden de: sujeto + verbo + complementos</td>
                                  <td>3,85 puntos</td>
                              </tr>
                              <tr>
                                <td></td>
                                  <td style="font-weight: bolder">50 puntos</td>
                              </tr>
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
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>El tamaño del texto tiene que ser como mínimo 12 y como máximo 16</td>
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existe texto en cursiva</td>
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existen más de un % de palabras en negrita</td>
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existen más de un % de palabras subrayadas</td>
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existen textos con sombreado</td>
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>No existen más de un % de palabras en mayúsculas</td>
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>Color de fuente negro</td>
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>Color de fondo blanco sólido</td>
                                  <td>5 puntos</td>
                              </tr>
                              <tr>
                                  <td>Cantidad de palabras en la diapositiva no supera el límite establecido</td>
                                  <td>5 puntos</td> 
                              </tr>
                              <tr>
                                <td></td>
                                  <td style="font-weight: bolder">50 puntos</td>
                              </tr>
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
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="./scripts/chart.js"></script>
    <script src="./scripts/top.js"></script>
    
</body>
    
</html>