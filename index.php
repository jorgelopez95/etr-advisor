<?php
    session_start();
    $file_uploaded = $_SESSION['file_uploaded'];
    $file_upload = './input' . $file_uploaded . '.html';
    unlink($file_upload);
    session_destroy();
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
    
    <!-- Carousel -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide img-responsive" src="./images/libro.jpg" alt="Lectura Fácil">
          <div class="container">
            <div class="carousel-caption" style="top: 60px; bottom: auto; margin-left: 5%;">
              <h2>Lectura Fácil</h2><br>
              <p>La tecnología permite avanzar en la accesibilidad</p>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="second-slide img-responsive" src="./images/world.jpeg" alt="Mundo">
          <div class="container">
            <div class="carousel-caption" style="top: 47%; bottom: auto; margin-left: 0;">
              <h2>Accesibilidad </h2><br>
              <p>La Lectura Fácil ayuda a personas con limitaciones lingüísticas</p>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="third-slide img-responsive" src="./images/integration.jpg" alt="Integracion">
          <div class="container">
            <div class="carousel-caption" style="top: 24%; bottom: auto; margin-left: %;">
              <h2>Integración</h2><br>
              <p>La Lectura Fácil facilita la lectura a personas con discapacidad intelectual</p>
            </div>
          </div>
        </div>
      </div>
      coral<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    
    <!-- Upload file -->
    <div class="jumbotron jumbotron-billboard" style="margin: 0">
        <div class="img"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 style="text-align: center; font-size: 30px">Comprueba aquí si tu archivo es de Lectura Fácil</h2>
                    <form action="./input/upload.php" method="post" enctype="multipart/form-data">
                        <div class="col-lg-6 col-sm-6 col-md-12" id="browse" style="margin-top: 20px">
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        Browse &nbsp<span class="glyphicon glyphicon-folder-open"></span> 
                                        <input type="file" name="file_uploaded" style="display: none;">
                                    </span>
                                </label>
                                <input type="text" class="form-control" name="file_name" style="padding-left: 20%; font-size: 20px;" required>
                            </div>
                            <span class="help-block" style="text-align:center">
                                Solo se permiten archivos de tipo html
                            </span>
                        </div>
                    <input type="submit" class="btn btn-success btn-lg" id="upload" value="Comprobar resultados">
                    </form>
                </div>
            </div>
        </div>
    </div>
            
    <!-- Informacion del sitio web -->
    <div class="container marketing" style="margin: 0px; padding: 0px">
        <div class="well" id="info" style="margin-top: 40px">
                <h3 style="text-align:center; font-size: 40px; font-style: italic">Información del sitio web</h3>
        </div>

        <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" src="./images/laptop.png" alt="Generic placeholder image" width="140" height="140">
          <h2>Crea tu contenido</h2>
            <p><b>Easy-to-Read Advisor</b> analiza tu diapositiva, en formato <b>HTML</b>. Por tanto, el primer paso es obtener el contenido en dicho formato. La web <a class="" href="https://slidewiki.org/" target="_blank">SlideWiki</a> realiza esta labor por ti. </p>
              <!-- Collapse -->  
              <button class="btn btn-default buttonCollapse" onclick="document.getElementById('id01').style.display='block'">   
                  <h4>
                    <span class="glyphicon glyphicon-transfer" style="margin-right: 20px; color: Brown"></span>
                     Ver más
                  </h4>
              </button>
                <div id="id01" class="modal">
                  <div class="modal-content animate" action="/action_page.php">
                      <div class="row" id="modal-exit" style="padding-top: 1%;">
				                  <a type="button" onclick="document.getElementById('id01').style.display='none'" style="float: right !important;padding-right: 4%;">
				                    <span class="glyphicon glyphicon-remove"></span>
				                  </a>
				              </div> 
                      <div class="row" id="modal-row" style="padding-top: 2% !important; padding-left: 2%; padding-right: 1% !important;">
                        <div class="col-lg-4">
                            <h2 style="margin-top: 0px; margin-bottom: 4%">Selecciona una diapositiva</h2>
                            <img class="img-thumbnail" src="./images/instruc_1.png" alt="Instruccion 1" width="550" height="450" style="margin-bottom: 4%">
                            <p style="text-align: left">Una vez hayas accedido a SlideWiki, selecciona una diapositiva, o crea una. </p>
                            <p style="text-align: left">Aquí tienes un repositorio a modo de ejemplo: <a href="https://slidewiki.org/deck/108653" target="_blank">https://slidewiki.org/deck/108653</a></p>
                        </div>
                        <div class="col-lg-4">
                            <h2 style="margin-top: 0px; margin-bottom: 4%">Accede al modo edición</h2>
                            <p style="text-align: left">Clickando en "Editar" podrás realizar los cambios que consideres oportunos.</p>
                            <img class="img-thumbnail" src="./images/instruc_2.png" alt="Instruccion 1" width="416" height="350" style="margin-bottom: 4%">
                        </div>
                        <div class="col-lg-4">
                            <h2 style="margin-top: 0px; margin-bottom: 4%">Obtén el código HTML</h2>
                            <p style="text-align: left">Cuando estés listo, pulsa en "Editor HTML".</p>
                            <img class="img-thumbnail" src="./images/instruc_3.png" alt="Instruccion 1" width="550" height="450" style="margin-bottom: 4%">
                            <p style="text-align: left">Una vez llegados a este paso, debes copiar el código que se muestra en la imagen.</p>
                            <p style="text-align: left">Cópialo en un editor de texto, y una vez guardado tu archivo con extensión .html, ya podrás comprobar si es de Lectura Fácil</p>
                        </div>  
                        </div><!-- /.row -->
                    </div>
                </div>
        </div>
        <div class="col-lg-4">
          <img class="img-circle" src="./images/upload.png" alt="Subir archivo" width="140" height="140">
          <h2>Analiza tu archivo</h2>
          <p>Sube tu archivo con extensión .html, y podrás comprobar si cumples con las <a href="#pautas">pautas</a> de accesibilidad.</p>
            <br>
        </div>
        <div class="col-lg-4">
          <img class="img-circle" src="./images/resultados.jpg" alt="Resultados" width="140" height="140">
          <h2>Resultados</h2>
          <p>Una vez se haya procesado tu fichero, se proporcionará una <b>puntuación</b>. Además, se mostrará un <b>análisis detallado</b> de aquellos puntos que debes mejorar.</p>
        </div> 
        

       

      
    </div><!-- /.row -->

        <!-- Lectura fácil -->
        <div class="well" id="lectura" style="margin-top: 40px">
            <h3 style="text-align:center; font-size: 40px; font-style: italic">¿Qué es la Lectura Fácil?</h3>
        </div>
        <div class="row featurette" style="padding-top: 20px">
        <div class="col-md-7">
            <h2 class="featurette-heading" id="metodologia">Metodología</h2><br>
            <p class="lead" style="padding-left: 26px; font-size: 18px">La lectura fácil es la adaptación que permite una lectura y una comprensión más sencilla de un contenido. No sólo abarca el <b>texto</b>, sino también se refiere a las ilustraciones y <b>maquetación</b>. Se considera también lectura fácil el método por el cual se hacen más comprensibles los textos para todas y todos, eliminando barreras para la <b>comprensión</b>, el aprendizaje y la participación. (<a href="https://es.wikipedia.org/wiki/Lectura_f%C3%A1cil" target="_blank">vía Wikipedia</a>)</p> <br><br>
            <p class="lead" style="padding-left: 26px; font-size: 18px">Lectura Fácil se dirige a todas las personas, en especial a aquellas que tienen <b>dificultades lectoras</b> transitorias (inmigración, incorporación tardía a la lectura, escolarización deficiente...) o permanentes (trastornos del aprendizaje, diversidad funcional, senilidad...). (<a href="http://www.lecturafacil.net/es/info/que-es-la-lectura-facil-lf1/" target="_blank">vía Asociación de Lectura Fácil</a>)</p>
        </div>
        <div class="col-md-5">
            <div class="embed-responsive embed-responsive-16by9" style=" margin: 50px 25px 20px 25px">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/gbPXbMo7NiQ" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
      </div>

      <hr class="featurette-divider">

        
      <div class="row featurette">         
          <div class="row">
              <div class="col-md-12">
                  <h2 class="featurette-heading" id="pautas">Pautas</h2> 
              </div>
          </div>
              <div class="col-md-6"> 
                  <div class="panel panel-info" style="margin: 20px 20px 0px 20px">
                      <div class="panel-heading" style="text-align: center; font-size: 20px; color:black">TEXTO</div>
                      <table class="table table-hover">
                          <tbody>
                              <tr>
                                  <td>El tamaño de las líneas debe de ser inferior a 60 caracteres</td>
                                  
                              </tr>
                              <tr>
                                  <td>Evitar el uso de números grandes</td>
                                  
                              </tr>
                              <tr>
                                  <td>Evitar el uso de caracteres especiales</td>
                                  
                              </tr>
                              <tr>
                                  <td>Evitar el uso de caracteres de orden</td>
                                  
                              </tr>
                              <tr>
                                  <td>Evitar el uso de más de 15 palabras por frase</td>
                                  
                              </tr>
                              <!--tr>
                                  <td>Evitar escribir más de 75 palabras por diapositiva</td>
                                  
                              </tr-->
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
                                  
                              </tr>
                              <tr>
                                  <td>Evitar abusar de los pronombres</td>
                                  
                              </tr>
                              <tr>
                                  <td>No utilizar números romanos</td>
                                  
                              </tr>
                              <tr>
                                  <td>Dirigir el mensaje a la audiencia usando la 2ª persona</td>
                                  
                              </tr>
                              <tr>
                                  <td>No utilizar la forma pasiva</td>
                                  
                              </tr>
                              <tr>
                                  <td>Las oraciones han de tener sujeto</td>
                                  
                              </tr>
                              <tr>
                                  <td>Las oraciones deben seguir el orden de: sujeto + verbo + complementos</td>
                                  
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
                                  
                              </tr>
                              <tr>
                                  <td>El tamaño del texto tiene que ser como mínimo 12 y como máximo 16</td>
                                  
                              </tr>
                              <tr>
                                  <td>No existe texto en cursiva</td>
                                  
                              </tr>
                              <tr>
                                  <td>No existen más de un % de palabras en negrita</td>
                                  
                              </tr>
                              <tr>
                                  <td>No existen más de un % de palabras subrayadas</td>
                                  
                              </tr>
                              <tr>
                                  <td>No existen textos con sombreado</td>
                                  
                              </tr>
                              <tr>
                                  <td>No existen más de un % de palabras en mayúsculas</td>
                                  
                              </tr>
                              <tr>
                                  <td>Color de fuente negro</td>
                                  
                              </tr>
                              <tr>
                                  <td>Color de fondo blanco sólido</td>
                                  
                              </tr>
                              <tr>
                                  <td>Cantidad de palabras en la diapositiva no supera el límite establecido</td>
                           
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
        
        <!-- Contacto -->
        <div class="well" id="contacto" style="margin-top: 80px; margin-bottom: 30px">
            <h3 style="text-align:center; font-size: 40px; font-style: italic">Contacto</h3>
        </div>
	
        <div class="row">
            <div class="col-md-6">
                <iframe id="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3002.7683467614406!2d-3.8375662847629326!3d40.40540816425226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd418f59d1469d93%3A0xf68b5804693b49f0!2sCampus+Montegancedo+-+Universidad+Polit%C3%A9cnica+de+Madrid!5e1!3m2!1ses!2ses!4v1520724376251" width="650" height="350" frameborder="0" style="border:0; padding-left: 20px; width: 100%" allowfullscreen></iframe>
            </div>
            <div class="col-md-6">
                <h4 style="margin-top: 20px; margin-bottom: 20px; padding-left: 25px"><b>Envíanos tus comentarios</b></h4>
                <form action="contact.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" value="" placeholder="Nombre *" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" value="" placeholder="E-mail *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" value="" placeholder="Asunto *" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="3" placeholder="Mensaje *" required></textarea>
                    </div>
                    <h6 style="margin-left: 75%">* Campos obligatorios</h6>
                    <button class="btn btn-default" type="submit" name="submit" value="submit" style="margin-left: 35px; background-color:aliceblue; color:black">Enviar&nbsp<span class="glyphicon glyphicon-send"></span>
                    </button>
                </form>
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
    <script src="./scripts/browse.js"></script>
    <script src="./scripts/top.js"></script>
    <script>
  		// Get the modal
  		var modal = document.getElementById('id01');
  		// When the user clicks anywhere outside of the modal, close it
  		window.onclick = function(event) {
  			if (event.target == modal) {
  				modal.style.display = "none";
  			}
  		}
    </script>
</body>
    
</html>