<!DOCTYPE html>
<html>
<head>
	<title>Recettes</title>
</head>
<body>

	<p class="hometext">Liste de Recettes</p>

	<form method="GET">
		<div class="searchbar">
			<input type="text" name="recipesearch"> <input type="submit" name="searchbtn" value="Rechercher">
		</div>
	</form>

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
						<td>$id</td>
						<td>$name</td>
						<td>".substr($ingredient, 0,20)."</td>
						<td>".substr($preparation, 0,20)."</td>
						<td>$nbperson</td>
						<td>$cost</td>
						<td><img class='recipeimg' src='./images/$photo'></td>
						<td>$date</td>
						<td>$author</td>
						<td><a href='index.php?links=recipedetail&id=$id'><input type='button' name='detail' value='detail'></a></td>
						</tr>";
					}			
				}

				$rowcount = mysqli_query($con, "SELECT COUNT(*) FROM recettes;");
				$nbrows = mysqli_fetch_row($rowcount);
				$pagenumbers = ceil($nbrows[0] / 10);

				if (isset($_GET['pagenb'])) 
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
					echo "<a href='index.php?links=recipe&pagenb=$i'>$i</a>";
				}

				echo "</div>";

				if (isset($_GET['searchbtn'])) 
				{
					$searchedrecipe = $_GET['recipesearch'];
					$sql = "SELECT * FROM recettes WHERE nom='%$searchedrecipe%' OR ingredient='%$searchedrecipe%';";
					$search = mysqli_query($con, $sql);

					while($recipefetch=mysqli_fetch_row($search))
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
						<td>$id</td>
						<td>$name</td>
						<td>".substr($ingredient, 0,20)."</td>
						<td>".substr($preparation, 0,20)."</td>
						<td>$nbperson</td>
						<td>$cost</td>
						<td><img class='recipeimg' src='./images/$photo'></td>
						<td>$date</td>
						<td>$author</td>
						<td><a href='index.php?links=recipedetail&id=$id'><input type='button' name='detail' value='detail'></a></td>
						</tr>";
					}
				}
			?>
		</table>
	</div>

</body>
</html>