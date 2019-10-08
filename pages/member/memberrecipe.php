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
					$sql1 = "SELECT * FROM recettes WHERE idrecette LIKE '%$searchedrecipe%' OR nom LIKE '%$searchedrecipe%' OR ingredients LIKE '%$searchedrecipe%';";
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
							<td>$id <input type='hidden' name='idlist[]' value='$id'></td>
							<td>$name</td>
							<td>$ingredient</td>
							<td>$preparation</td>
							<td>$nbperson</td>
							<td>$cost</td>
							<td><img class='recipeimg' src='./images/$photo'></td>
							<td>$date</td>
							<td>$author</td>
							<td><a href='memberindex.php?links=recipedetail&id=$id'><input type='button' name='detail' value='detail'></a></td>
							</tr>";
						}			
					}

					$rowcount = mysqli_query($con, "SELECT COUNT(*) FROM recettes;");
					$nbrows = mysqli_fetch_row($rowcount);
					$pagenumbers = ceil($nbrows[0] / 10);

					if (isset($_POST['searchbtn'])) 
					{		
						$searchedrecipe = $_POST['recipesearch'];
						$sql = "SELECT * FROM recettes WHERE idrecette LIKE '%$searchedrecipe%' OR nom LIKE '%$searchedrecipe%' OR ingredients LIKE '%$searchedrecipe%';";
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
							<td>$id <input type='hidden' name='idlist[]' value='$id'></td>
							<td>$name</td>
							<td>$ingredient</td>
							<td>$preparation</td>
							<td>$nbperson</td>
							<td>$cost</td>
							<td><img class='recipeimg' src='./images/$photo'></td>
							<td>$date</td>
							<td>$author</td>
							<td><a href='memberindex.php?links=recipedetail&id=$id'><input type='button' name='detail' value='detail'></a></td>
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
	</form>		
</body>
</html>