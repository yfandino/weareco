<?php
require_once "classes/Cliente.php";
require_once "classes/Producto.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<title><?php echo $title?></title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,600" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
</head>
<body>
<?php require_once 'header.php'; ?>
<?php
if (!isset($_SESSION['cliente'])) {
    require_once '_modalLoginRegistro.php';
}
?>
