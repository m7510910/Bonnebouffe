<!DOCTYPE html>
<html>
<head>
	<title>Acceuil</title>
	<link rel="stylesheet" type="text/css" href="./styles/stylebase.css">
	<link rel="stylesheet" type="text/css" href="./styles/stylerecette.css">
</head>
	<?php
		$con = mysqli_connect('localhost','root','Mario748!','bonnebouffe') or die("Connection error!");
	?>
<body>

	<div class="top">
		CUISINE INTERNATIONALE<br>
		12. rue Bonne bouffe
	</div>

	<div class="btngroup">
		<a href="index.php?links=index"><button>Acceuil</button></a>
		<a href="index.php?links=login"><button>Login</button></a>
		<a href="index.php?links=recipe"><button>Recettes</button></a>
		<a href="index.php?links=contact"><button>Contact</button></a>
		<a href="index.php?links=reference"><button>Reference</button></a>
	</div>

	<?php
		if(isset($_GET["links"]))
		{
			$link = $_GET["links"];

			switch ($link) 
			{
				case 'index':
					include('./pages/base/acceuil.php');
					break;

				case 'login':
					session_destroy();
					include('./pages/base/login.php');
					break;

				case 'recipe':
					include('./pages/base/recettebase.php');
					break;

				case 'contact':
					include('./pages/base/contact.php');
					break;

				case 'reference':
					include('./pages/base/reference.php');
					break;

				case 'newuser':
					include('./pages/base/newuser.php');
					break;

				case 'signup':
					include('./pages/base/login.php');
					break;
			}
		}
		else
		{
			include('./pages/base/acceuil.php');
		}
	?>

</body>
</html>