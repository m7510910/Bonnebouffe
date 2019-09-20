<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>

	<div class="leftside"></div>

	<div class="rightside">
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
				<td><a href="index.php?links=userlogin"><button>Entrez</button></a></td>
				<td><a href="index.php?links=newuser">Non Membre?</a></td>
			</tr>
		</table>

		<span class="loginpagetext">Administrateur</span>
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
				<td><a href="index.php?links=adminlogin"><button>Entrez</button></a></td>
			</tr>
		</table>
	</div>
	
</body>
</html>