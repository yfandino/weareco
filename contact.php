<link type="text/css" rel="stylesheet" href="../fpdf.css">


<?php
	$title = 'Inicio - weareco';
	require_once 'head.php';
?>



<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h2 class="about-title">Contacta con nosotros</h2>
<p class="about-p">Suspendisse vel turpis eu lorem porttitor luctus. Etiam metus eros, lacinia et justo id, lobortis scelerisque purus. Proin elementum sit amet 
    tortor sed elementum. Vestibulum sollicitudin lacus vitae orci vehicula dignissim. In sit amet lacus in libero placerat hendrerit. Nam scelerisque porta quam,
    non accumsan ex ultricies sit amet.</p>
<div class="contacto">
<div class="container2">
  <form action="mailto:info@weareco.com">
    <label for="fname">Nombre</label>
    <input type="text" id="fname" name="firstname" placeholder="Escribre aquí tu nombre..">
    <label for="lname">Appellidos</label>
    <input type="text" id="lname" name="lastname" placeholder="Escribre aquí tus apellidos..">
    <label for="subject">Mensaje</label>
    <textarea id="subject" name="subject" placeholder="Escribe aquí tu mensaje.." style="height:200px"></textarea>

    <input type="submit" value="Enviar">
  </form>
</div>
</div>

</body>
</html>
