<!DOCTYPE html>
<html>
<head>
	<title>Bonne Bouffe</title>
	<link rel="stylesheet" type="text/css" href="../../styles/stylebase.css">
	<link rel="stylesheet" type="text/css" href="../../styles/stylerecette.css">
</head>
	<?php
		session_start();
		if($_SESSION['admin'] == "") 
		{
			header('location: ../../index.php');
		}
		$con = mysqli_connect('localhost','root','Mario748!','bonnebouffe') or die("Connection error!");
	?>
<body>

	<div class="top">
		CUISINE INTERNATIONALE<br>
		12. rue Bonne bouffe
	</div>

	<div class="btngroup">
		<a href="adminindex.php?links=index"><button>Acceuil</button></a>
		<a href="adminindex.php?links=logout"><button>Deconnection</button></a>
		<a href="adminindex.php?links=recipe"><button>Recettes</button></a>
		<a href="adminindex.php?links=member"><button>Membres</button></a>
	</div>

	<?php

		$i = 0;

		if(isset($_GET["links"]))
		{
			$link = $_GET["links"];

			switch ($link) 
			{
				case 'index':
					include('../base/acceuil.php');
					break;

				case 'logout':
					session_destroy();
					header('location: ../../index.php');
					break;

				case 'recipe':
					include('./adminrecette.php');
					break;

				case 'recipedetail':
					include('../base/recettedetail.php');				
					break;

				case 'member':
					include('./adminmember.php');
					break;
			}
		}
		else
		{
			include('../base/acceuil.php');
		}
	?>

</body>
</html>