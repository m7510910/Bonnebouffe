<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<?php
		session_start();
	?>
</head>
<body>

	<div class="leftside"></div>

	<div class="rightside">
		<form method="POST">
			<span class="loginpagetext">Branchez-vous MEMBRE!</span>
			<table class="logintable">
				<tr>
					<td>Login: </td>
					<td><input type="text" name="loginmember"></td>
				</tr>
				<tr>
					<td>Password: </td>
					<td><input type="password" name="passwordmember"></td>
				</tr>
				<tr>
					<td><a href="index.php?links=userlogin"><input type="submit" name="userlogin" value="Entrez"></input></a></td>
					<td><a href="index.php?links=newuser">Non Membre?</a></td>
				</tr>
			</table>

			<span class="loginpagetext">Administrateur</span>
			<table class="logintable">
				<tr>
					<td>Login: </td>
					<td><input type="text" name="loginadmin"></td>
				</tr>
				<tr>
					<td>Password: </td>
					<td><input type="password" name="passwordadmin"></td>
				</tr>
				<tr>
					<td><a href="index.php?links=adminlogin"><input type="submit" name="adminlogin" value="Entrez"></input></a></td>
				</tr>
			</table>
		</form>
	</div>

	<?php
		if(isset($_POST['userlogin']))
		{
			$login = $_POST['loginmember'];
			$password = $_POST['passwordmember'];

			$sql = "SELECT login,password FROM membres WHERE login='$login' AND password='$password';";
			$findmember = mysqli_query($con, $sql);
			$foundmember = mysqli_num_rows($findmember);

			echo "$foundmember";
		}
		if (isset($_POST['adminlogin'])) 
		{
			$login = $_POST['loginadmin'];
			$password = $_POST['passwordadmin'];

			$sql = "SELECT login,password FROM admin WHERE login='$login' AND password='$password';";
			$findadmin = mysqli_query($con, $sql);
			$foundadmin = mysqli_num_rows($findadmin);

			if ($foundadmin == 1)
			{
				$getadmin = mysqli_fetch_row($findadmin);
				$_SESSION['admin'] = $getadmin[0];

				echo $_SESSION['admin'];

				header('location: ./pages/admin/adminindex.php');
			}
		}
	?>

</body>
</html>