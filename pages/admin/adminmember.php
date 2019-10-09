<!DOCTYPE html>
<html>
<head>
	<title>Recettes</title>
</head>
<body>
<!--Ajout de membre-->
	<p class="hometext">Ajout de Membre</p>

	<form method="post">
		<table class="createmember">
			<tr>
				<td>Prenom:</td>
				<td><input type="text" name="firstname"></td>
				<td>Nom:</td>
				<td><input type="text" name="lastname"></td>
			</tr>
			<tr>
				<td>Telephone:</td>
				<td><input type="text" name="phone"></td>
				<td>Adresse:</td>
				<td><input type="text" name="address"></td>
				<td>Date de naissance:</td>
				<td><input type="date" name="birth"></td>
			</tr>
			<tr>
				<td>Login:</td>
				<td><input type="text" name="login"></td>
				<td>Password:</td>
				<td><input type="text" name="password"></td>
			</tr>
			<tr>
				<td><input type="submit" name="createbtn" value="Creer"></td>
			</tr>
		</table>
	</form>

	<?php
		if(isset($_POST['createbtn']))
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

				$sql = "INSERT INTO membres() VALUES('$id','$firstname','$lastname','$phone','$address','$birth','$login','$password');";
				$createmember = mysqli_query($con, $sql);
			}
		}
	?>

<!--Recherche et modification de membre partie admin-->	
	<p class="hometext">Liste de Membre</p>

	<form method="post">
		<div class="searchbar">
			<input type="text" name="membersearch"> <input type="submit" name="searchbtn" value="Rechercher">
		</div>

		<div>
			<table class="recipe">
				<tr>
					<th></th>
					<th>Numero</th>
					<th>Prenom</th>
					<th>Nom</th>
					<th>Telephone</th>
					<th>Adresse</th>
					<th>Date de naissance</th>
					<th>Login</th>
					<th>Password</th>
				</tr>

				<?php
					$sql = "SELECT * FROM membres;";
					$search = mysqli_query($con, $sql);
					$nbre = mysqli_num_rows($search);

					function showresult()
					{
						global $con, $offset;

						$sql = "SELECT * FROM membres LIMIT $offset,10;";

						$memberquery = mysqli_query($con, $sql);

						while($memberfetch=mysqli_fetch_row($memberquery))
						{
							echo "<tr>
								<td><input type='checkbox' name='selectedlist[]' value='$memberfetch[0]'></td>
								<td>$memberfetch[0]<input type='hidden' name='idlist[]' value='$memberfetch[0]'></td>
								<td><input class='tdinput' type='text' name='firstname[]' value='$memberfetch[1]'></td>
								<td><input class='tdinput' type='text' name='lastname[]' value='$memberfetch[2]'></td>
								<td><input class='tdinput' type='text' name='phone[]' value='$memberfetch[3]'></td>
								<td><input class='tdinput' type='text' name='adress[]' value='$memberfetch[4]'></td>
								<td><input class='tdinput' type='date' name='birth[]' value='$memberfetch[5]'></td>
								<td><input class='tdinput' type='text' name='login[]' value='$memberfetch[6]'></td>
								<td><input class='tdinput' type='text' name='password[]' value='$memberfetch[7]'></td>
							</tr>";							
						}			
					}

					$rowcount = mysqli_query($con, "SELECT COUNT(*) FROM membres;");
					$nbrows = mysqli_fetch_row($rowcount);
					$pagenumbers = ceil($nbrows[0] / 10);

					if (isset($_POST['searchbtn'])) 
					{		
						$membersearch = $_POST['membersearch'];
						$sql = "SELECT * FROM membres WHERE idmembre LIKE '%$membersearch%' OR prenom LIKE '%$membersearch%' OR nom LIKE '%$membersearch%';";
						$memberquery = mysqli_query($con, $sql);
						$nbre = mysqli_num_rows($search);

						while($memberfetch=mysqli_fetch_row($memberquery))
						{
							echo "<tr>
								<td><input type='checkbox' name='selectedlist[]' value='$memberfetch[0]'></td>
								<td>$memberfetch[0]<input type='hidden' name='idlist[]' value='$memberfetch[0]'></td>
								<td><input class='tdinput' type='text' name='firstname[]' value='$memberfetch[1]'></td>
								<td><input class='tdinput' type='text' name='lastname[]' value='$memberfetch[2]'></td>
								<td><input class='tdinput' type='text' name='phone[]' value='$memberfetch[3]'></td>
								<td><input class='tdinput' type='text' name='adress[]' value='$memberfetch[4]'></td>
								<td><input class='tdinput' type='date' name='birth[]' value='$memberfetch[5]'></td>
								<td><input class='tdinput' type='text' name='login[]' value='$memberfetch[6]'></td>
								<td><input class='tdinput' type='text' name='password[]' value='$memberfetch[7]'></td>
							</tr>";									
						}		
					}
					elseif (isset($_GET['pagenb'])) 
					{
						$offset = $_GET['pagenb'] * 10 - 10;
						showresult();
					}
					else
					{
						$offset = 0;
						showresult();
					}				

					echo "<div class='pagination'>";

					for ($i=1; $i <= $pagenumbers; $i++) 
					{ 
						echo "<a href='adminindex.php?links=recipe&pagenb=$i'>$i</a>";
					}

					echo "</div>";						
				?>
			</table>
		</div>		
		
		<input type="submit" class='deletebtn' name="deletebtn" value="Supprimer">
		<input type="submit" class="modifybtn" name="modifybtn" value="Modifier">
	</form>		

		<?php
			if (isset($_POST['deletebtn'])) 
			{
				foreach ($_POST['selectedlist'] as $selected) 
				{
					$sql = "DELETE FROM membres WHERE idmembre='$selected';";

					$delete = mysqli_query($con, $sql);				
				}
			}

			if(isset($_POST['modifybtn']))
			{
				$index = 0;
				$selectarray = $_POST['selectedlist'];
				$namearray = $_POST['firstname'];
				$lastnamearray = $_POST['lastname'];
				$phonearray = $_POST['phone'];
				$adressarray = $_POST['adress'];
				$birtharray = $_POST['birth'];
				$loginarray = $_POST['login'];
				$passwordarray = $_POST['password'];

				foreach($_POST['idlist'] as $selected)
				{
					if(in_array($selected, $selectarray))
					{
						$newname = $namearray[$index];
						$newing = $lastnamearray[$index];
						$newprep = $phonearray[$index];
						$newnb = $adressarray[$index];
						$newcost = $birtharray[$index];
						$newdate = $loginarray[$index];
						$newauthor = $passwordarray[$index];

						if(!empty($newname) && !empty($newing) && !empty($newprep) && !empty($newnb) && !empty($newcost) && !empty($newdate) && !empty($newauthor))
						{
							$sql = "UPDATE `membres` SET `prenom` = '$newname', `nom` = '$newing', `telephone` = '$newprep', `adresse` = '$newnb', `datedenaissance` = '$newcost', `login` = '$newdate', `password` = '$newauthor' WHERE `membres`.`idmembre` = '$selected';";

							$updaterecipes = mysqli_query($con, $sql);

							echo "<span class='updatetext success'>Mise a jour reussi!</span>";
						}
						else
						{
							echo "<span class='updatetext failure'>1 ou plusieur champ ne sont pas comforme!</span>";
						}
					}
					$index++;
				}

			}
		?>
</body>
</html>