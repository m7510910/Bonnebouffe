<?php
		session_start();
		if($_SESSION['member'] == "") 
		{
			echo "<script>window.location.href='../../index.php'</script>";
		}
		
		$con = mysqli_connect('localhost','mopscom_marc','Mario748','mopscom_bonnebouffe') or die("Connection error!");
		if(!$con)
		{
			$con = mysqli_connect('localhost','root','Mario748!','bonnebouffe');
		}
	?>
<!DOCTYPE html>
<html>
<head>
	<title>Bonne Bouffe</title>
	<link rel="stylesheet" type="text/css" href="../../styles/stylebase.css">
	<link rel="stylesheet" type="text/css" href="../../styles/stylerecette.css">
</head>
<body>

	<div class="top">
		CUISINE INTERNATIONALE<br>
		12. rue Bonne bouffe
	</div>

	<div class="btngroup">
		<a href="memberindex.php?links=index"><button>Acceuil</button></a>
		<a href="memberindex.php?links=logout"><button>Deconnection</button></a>
		<a href="memberindex.php?links=recipe"><button>Recettes</button></a>
		<a href="memberindex.php?links=member"><button>Membres</button></a>
		<a href="memberindex.php?links=myrecipe"><button>Mes recettes</button></a>
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
					echo "<script>window.location.href='../../index.php'</script>";
					break;

				case 'recipe':
					include('./memberrecipe.php');
					break;

				case 'recipedetail':
					include('../base/recettedetail.php');				
					break;

				case 'member':
					include('./membermember.php');
					break;

				case 'myrecipe':
					include('./membermyrecipe.php');
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