<!DOCTYPE html>
<html>
<head>
	<title>Detail</title>
</head>
<body>
	<?php
		$id = $_GET['id'];
		$sql = "SELECT * FROM recettes WHERE idrecette='$id';";
		$searchrecipe = mysqli_query($con, $sql);
		$getrecipe = mysqli_fetch_row($searchrecipe);

		$name = $getrecipe[1];
		$ingredient = $getrecipe[2];
		$preparation = $getrecipe[3];
		$nbperson = $getrecipe[4];
		$cost = $getrecipe[5];
		$photo = $getrecipe[7];
		$date = $getrecipe[6];
		$author = $getrecipe[8];

		echo "<table class='detail'>
			<th></th>
			<th></th>
			<tr>
				<td width='20%'>Numero</td> <td>$id</td>
			</tr>
			<tr>
				<td>nom</td>				<td>$name</td>
			</tr>
			<tr>
				<td>Ingredient</td>			<td>$ingredient</rd>
			</tr>
			<tr>
				<td>Preparation</td>		<td>$preparation</rd>
			</tr>
			<tr>
				<td>Nombre Personne</td>	<td>$nbperson</rd>
			</tr>
			<tr>
				<td>Cout</td>				<td>$cost</rd>
			</tr>
			<tr>
				<td>Photo</td>				<td>$photo</rd>
			</tr>
			<tr>
				<td>Date Inscrite</td>		<td>$date</rd>
			</tr>
			<tr>
				<td>Autheur</td>			<td>$author</rd>
			</tr>
		</table>";
	?>
</body>
</html>