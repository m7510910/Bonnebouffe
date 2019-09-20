<!DOCTYPE html>
<html>
<head>
	<title>Recettes</title>
</head>
<body>

	<p class="hometext">Liste de Recettes</p>

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
				$index = 0;
				$sql = "select * from recettes";

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
					<td><input type='button' name='detail' value='detail'></td>
					</tr>";

					$index++;
				}
			?>
		</table>
	</div>

</body>
</html>