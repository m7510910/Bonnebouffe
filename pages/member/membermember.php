<!DOCTYPE html>
<html>
<head>
	<title>Recettes</title>
</head>
<body>
<!--Ajout de membre-->
	<p class="hometext">Ajout de Membre</p>

	<?php
		$memberid = $_SESSION['member'];
		$sql = "SELECT * FROM membres WHERE idmembre='$memberid';";

		$findmember = mysqli_query($con, $sql);
		$getmember = mysqli_fetch_row($findmember);

		echo "<form method='post'>
		<table class='createmember'>
			<tr>
				<td>Prenom:</td>
				<td><input type='text' name='firstname' value='$getmember[1]'></td>
				<td>Nom:</td>
				<td><input type='text' name='lastname' value='$getmember[2]'></td>
			</tr>
			<tr>
				<td>Telephone:</td>
				<td><input type='text' name='phone' value='$getmember[3]'></td>
				<td>Adresse:</td>
				<td><input type='text' name='address' value='$getmember[4]'></td>
				<td>Date de naissance:</td>
				<td><input type='date' name='birth' value='$getmember[5]'></td>
			</tr>
			<tr>
				<td>Login:</td>
				<td><input type='text' name='login' value='$getmember[6]'></td>
				<td>Password:</td>
				<td><input type='text' name='password' value='$getmember[7]'></td>
			</tr>
			<tr>
				<td><input type='submit' name='modifybtn' value='Modifier'></td>
			</tr>
		</table>
	</form>";

		if(isset($_POST['modifybtn']))
		{
			if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['login']) && !empty($_POST['password']))
			{
				$year = strtok($_POST['birth'], '-');
				$id = substr($_POST['lastname'], 0,3) . substr($_POST['firstname'], 0,2) . $year;
				$firstname = $_POST['firstname'];
				$lastname = $_POST['lastname'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];
				$birth = $_POST['birth'];
				$login = $_POST['login'];
				$password = $_POST['password'];

				$sql = "UPDATE membres
						SET idmembre='$id', prenom='$firstname', nom='$lastname', telephone='$phone', adresse='$address', datedenaissance='$birth', login='$login', password='$password'
						WHERE idmembre='$memberid';";
						
				$createmember = mysqli_query($con, $sql);
			}
		}
	?>
</body>
</html>