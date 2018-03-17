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
    <link rel="stylesheet" href="styles.css">
</head>
    
<body>
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
                      <li><a href="#info"><span class="glyphicon glyphicon-eye-open" style="margin-right: 10px;"></span>Información</a></li>
                      <li><a href="#lectura"><span class="glyphicon glyphicon-book" style="margin-right: 10px;"></span>Lectura Fácil</a></li>
                      <li><a href="#contacto"><span class="glyphicon glyphicon-envelope" style="margin-right: 10px;"></span>Contacto</a></li>
                  </ul>
              </div>
          </div>
        </div>
    </nav>
    

      <hr class="featurette-divider">

        
      <div class="row featurette">         
          <div class="row">
              <div class="col-md-12">
                  <h2 class="featurette-heading" id="pautas">Pautas</h2> 
              </div>
          </div>
          <div class="col-md-6"> 
              <div class="panel panel-warning" style="margin: 20px 20px 0px 20px">
                  <div class="panel-heading" style="text-align: center; font-size: 20px; color:black">TEXTO</div>
                  <table class="table table-hover">
                      <tbody>
                          <tr>
                              <td>El tamaño de las líneas debe de ser inferior a 60 caracteres</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>Evitar el uso de números grandes</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>Evitar el uso de caracteres especiales</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>Evitar el uso de caracteres de orden</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>Evitar el uso de más de 15 palabras por frase</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>Evitar escribir más de 75 palabras por diapositiva</td>
                              <td>7,7 puntos</td>
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
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>Evitar abusar de los pronombres</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>No utilizar números romanos</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>Dirigir el mensaje a la audiencia usando la 2ª persona</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>No utilizar la forma pasiva</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>Las oraciones han de tener sujeto</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                              <td>Las oraciones deben seguir el orden de: sujeto + verbo + complementos</td>
                              <td>7,7 puntos</td>
                          </tr>
                          <tr>
                            <td></td>
                              <td style="font-weight: bolder">100 puntos</td>
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
                              <td>10 puntos</td>
                          </tr>
                          <tr>
                              <td>El tamaño del texto tiene que ser como mínimo 12 y como máximo 16</td>
                              <td>10 puntos</td>
                          </tr>
                          <tr>
                              <td>No existe texto en cursiva</td>
                              <td>10 puntos</td>
                          </tr>
                          <tr>
                              <td>No existen más de un % de palabras en negrita</td>
                              <td>10 puntos</td>
                          </tr>
                          <tr>
                              <td>No existen más de un % de palabras subrayadas</td>
                              <td>10 puntos</td>
                          </tr>
                          <tr>
                              <td>No existen textos con sombreado</td>
                              <td>10 puntos</td>
                          </tr>
                          <tr>
                              <td>No existen más de un % de palabras en mayúsculas</td>
                              <td>10 puntos</td>
                          </tr>
                          <tr>
                              <td>Color de fuente negro</td>
                              <td>10 puntos</td>
                          </tr>
                          <tr>
                              <td>Color de fondo blanco sólido</td>
                              <td>10 puntos</td>
                          </tr>
                          <tr>
                              <td>Cantidad de palabras en la diapositiva no supera el límite establecido</td>
                              <td>10 puntos</td> 
                          </tr>
                          <tr>
                            <td></td>
                              <td style="font-weight: bolder">100 puntos</td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
        
    
        
    <!-- Button back-to-top -->
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click para subir" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>

    <!-- Footer -->    
    <footer style="margin: 55px 0px 15px 15px; font-weight: bolder">
        <p>&copy; Escuela Técnica Superior de Ingenieros Informáticos (UPM).</p>
    </footer>
    </div>
    
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });
            $('#back-to-top').click(function () {
                $('#back-to-top').tooltip('hide');
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });        
            $('#back-to-top').tooltip('show');
        });
    </script>
</body>
    
</html>