<!DOCTYPE html>
<html>
<head>
	<title>Recettes</title>
</head>
<body>

	<p class="hometext">Liste de Recettes</p>

	<form method="post">
		<div class="searchbar">
			<input type="text" name="recipesearch"> <input type="submit" name="searchbtn" value="Rechercher">
		</div>

		<div>
			<table class="recipe">
				<tr>
					<th></th>
					<th>Numero</th>
					<th>Nom</th>
					<th>Ingredient</th>
					<th>Preparation</th>
					<th>Nombre Personne</th>
					<th>Cout</th>
					<th>Photo</th>
					<th>Date inscrite</th>
					<th>Autheur</th>
					<th></th>
				</tr>

				<?php
					$sql1 = "SELECT * FROM recettes WHERE nom LIKE '%$searchedrecipe%' OR ingredients LIKE '%$searchedrecipe%';";
					$search = mysqli_query($con, $sql);
					$nbre = mysqli_num_rows($search);

					function showresult()
					{
						global $con, $offset;

						$sql = "SELECT * FROM recettes LIMIT $offset,10;";

						$recipequery = mysqli_query($con, $sql);

						while($recipefetch=mysqli_fetch_row($recipequery))
						{
							$id = $recipefetch[0];
							$name = $recipefetch[1];
							$ingredient = $recipefetch[2];
							$preparation = $recipefetch[3];
							$nbperson = $recipefetch[4];
							$cost = $recipefetch[5];
							$photo = $recipefetch[7];
							$date = $recipefetch[6];
							$author = $recipefetch[8];

							echo "<tr>
							<td><input type='checkbox' name='recipelist[]' value='$id'></td>
							<td>$id <input type='hidden' name='idlist[]' value='$id'></td>
							<td><input type='text' name='namelist[]' value='$name'></td>
							<td><input type='text' name='ingredientlist[]' value='$ingredient'></td>
							<td><input type='text' name='preparationlist[]' value='$preparation'></td>
							<td><input type='text' name='nbpersonlist[]' value='$nbperson'></td>
							<td><input type='text' name='costlist[]' value='$cost $'></td>
							<td><img class='recipeimg' src='./images/$photo'></td>
							<td><input type='text' name='datelist[]' value='$date'></td>
							<td><input type='text' name='authorlist[]' value='$author'></td>
							<td><a href='adminindex.php?links=recipedetail&id=$id'><input type='button' name='detail' value='detail'></a></td>
							</tr>";
						}			
					}

					$rowcount = mysqli_query($con, "SELECT COUNT(*) FROM recettes;");
					$nbrows = mysqli_fetch_row($rowcount);
					$pagenumbers = ceil($nbrows[0] / 10);

					if (isset($_POST['searchbtn'])) 
					{		
						$searchedrecipe = $_POST['recipesearch'];
						$sql = "SELECT * FROM recettes WHERE nom LIKE '%$searchedrecipe%' OR ingredients LIKE '%$searchedrecipe%';";
						$search = mysqli_query($con,$sql);
						$nbre = mysqli_num_rows($search);

						while ($recipefetch = mysqli_fetch_row($search)) 
						{
							$id = $recipefetch[0];
							$name = $recipefetch[1];
							$ingredient = $recipefetch[2];
							$preparation = $recipefetch[3];
							$nbperson = $recipefetch[4];
							$cost = $recipefetch[5];
							$photo = $recipefetch[7];
							$date = $recipefetch[6];
							$author = $recipefetch[8];

							echo "<tr>
							<td><input type='checkbox' name='recipelist[]' value='$id'></td>
							<td>$id <input type='hidden' name='idlist[]' value='$id'></td>
							<td><input type='text' name='namelist[]' value='$name'></td>
							<td><input type='text' name='ingredientlist[]' value='$ingredient'></td>
							<td><input type='text' name='preparationlist[]' value='$preparation'></td>
							<td><input type='text' name='nbpersonlist[]' value='$nbperson'></td>
							<td><input type='text' name='costlist[]' value='$cost $'></td>
							<td><img class='recipeimg' src='./images/$photo'></td>
							<td><input type='text' name='datelist[]' value='$date'></td>
							<td><input type='text' name='authorlist[]' value='$author'></td>
							<td><a href='adminindex.php?links=recipedetail&id=$id'><input type='button' name='detail' value='detail'></a></td>
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
				foreach ($_POST['recipelist'] as $selected) 
				{
					$sql = "DELETE FROM recettes WHERE idrecette='$selected';";

					$delete = mysqli_query($con, $sql);				
				}
			}

			if(isset($_POST['modifybtn']))
			{
				$index = 0;
				$selectarray = $_POST['recipelist'];
				$namearray = $_POST['namelist'];
				$ingredientarray = $_POST['ingredientlist'];
				$preparationarray = $_POST['preparationlist'];
				$nbpersonarray = $_POST['nbpersonlist'];
				$costarray = $_POST['costlist'];
				$datearray = $_POST['datelist'];
				$authorarray = $_POST['authorlist'];

				foreach($_POST['idlist'] as $selected)
				{
					if(in_array($selected, $selectarray))
					{
						$newname = $namearray[$index];
						$newing = $ingredientarray[$index];
						$newprep = $preparationarray[$index];
						$newnb = $nbpersonarray[$index];
						$newcost = $costarray[$index];
						$newdate = $datearray[$index];
						$newauthor = $authorarray[$index];

						if(!empty($newname) && !empty($newing) && !empty($newprep) && !empty($newnb) && !empty($newcost) && !empty($newdate) && !empty($newauthor) && is_numeric($newcost) && is_numeric($newnb))
						{
							$sql = "UPDATE recettes SET nom='$newname', ingredients='$newing',preparation='$newprep',nombrepersonne='$newnb',cout=$newcost,dateinscrite='$newdate', idmembre='$newauthor' WHERE idrecette='$selected';";
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