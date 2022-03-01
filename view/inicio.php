<?php 
	session_start();
	if(isset($_SESSION['usuario'])){

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Início</title>
	<?php require_once "menu.php"; ?>
	<style>
		img{
			display: block;
    		margin-left: auto;
    		margin-right: auto;
		}
	</style>
</head>
<body>
	<img src="../img/raposab.png" >
</body>
</html>

<?php 
}else{
	header("location:../index.php");
	}
 ?>