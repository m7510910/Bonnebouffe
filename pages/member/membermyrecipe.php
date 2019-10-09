<p class="hometext">Ajout de Recettes</p>

	<form method="post" enctype="multipart/form-data">
		<table class="createmember">
			<tr>
				<td>Nom:</td>
				<td><input type="text" name="firstname"></td>
			</tr>
			<tr>
				<td>ingredient:</td>
				<td><textarea class='areainput' name="ingredient"></textarea></td>
				<td>Preparation:</td>
				<td><textarea class='areainput' name="preparation"></textarea></td>
			</tr>
			<tr>
				<td>NB personne:</td>
				<td><input type="text" name="nb"></td>
				<td>cout:</td>
				<td><input type="text" name="cost"></td>
				<td>Photo:</td>
				<td><input type="file" name="fileToUpload" accept="image/*"></td>
			</tr>
			<tr>
				<td><input type="submit" name="createbtn" value="Creer"></td>
			</tr>
		</table>
	</form>

	<?php
		$recipeowner = $_SESSION['member'];

		if(isset($_POST['createbtn']))
		{				
			if(!empty($_FILES['fileToUpload']) && (!empty($_POST['firstname'])) && (!empty($_POST['ingredient'])) && (!empty($_POST['preparation'])) && (!empty($_POST['nb'])) && (!empty($_POST['cost'])))
			{
				$path = "../../images/";
				$path = $path . basename( $_FILES['fileToUpload']['name']);

				$name = $_POST['firstname'];
				$ing = $_POST['ingredient'];
				$prep = $_POST['preparation'];
				$nb = $_POST['nb'];
				$cost = $_POST['cost'];
				$photo = $_FILES['fileToUpload']['name'];

				$sql = "INSERT INTO recettes(`nom`, `ingredients`, `preparation`, `nombrepersonne`, `cout`, `dateinscrite`, `photo`, `idmembre`) VALUES('$name','$ing','$prep',$nb,$cost,now(),'$photo','$recipeowner');";

				$newrecipe = mysqli_query($con, $sql);

				if($newrecipe)
				{				
					if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $path)) 
					{
						//echo "The file ".  basename( $_FILES['fileToUpload']['name']). 
						//" has been uploaded";
						echo "<span class='uploadtext success'>Ajout reussi!</span>";
					} 
					else
					{
						//echo "There was an error uploading the file, please try again!";
						//echo $_FILES['fileToUpload']['error'];
						echo "<span class='uploadtext failure'>1 ou plusieur champ ne sont pas comforme!</span>";
					}
				}
			}
		}
	?>

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
					$recipeowner = $_SESSION['member'];
					$searchedrecipe = $_POST['recipesearch'];
					
					function showresult()
					{
						global $con, $offset, $recipeowner;

						$sql = "SELECT * FROM recettes WHERE idmembre='$recipeowner' LIMIT $offset,10;";

						$recipes = mysqli_query($con, $sql);

						showrecipes($recipes);			
					}

					function showrecipes($recipes)
					{
						while($recipe=mysqli_fetch_row($recipes))
						{
							showrecipe($recipe);
						}
					}

					function showrecipe($recipe)
					{
						$id = $recipe[0];
						$name = $recipe[1];
						$ingredient = $recipe[2];
						$preparation = $recipe[3];
						$nbperson = $recipe[4];
						$cost = $recipe[5];
						$photo = $recipe[7];
						$date = $recipe[6];
						$author = $recipe[8];

						echo "<tr>
						<td><input type='checkbox' name='recipelist[]' value='$id'></td>
						<td>$id <input type='hidden' name='idlist[]' value='$id'></td>
						<td><input class='tdinput' type='text' name='namelist[]' value='$name'></td>
						<td><input class='tdinput' type='text' name='ingredientlist[]' value='$ingredient'></td>
						<td><input class='tdinput' type='text' name='preparationlist[]' value='$preparation'></td>
						<td><input class='tdinput' type='text' name='nbpersonlist[]' value='$nbperson'></td>
						<td><input class='tdinput' type='text' name='costlist[]' value='$cost'></td>
						<td><img class='recipeimg' src='../../images/$photo'></td>
						<td><input class='tdinput' type='text' name='datelist[]' value='$date'></td>
						<td><input class='tdinput' type='text' name='authorlist[]' value='$author'></td>
						<td><a href='memberindex.php?links=recipedetail&id=$id'><input type='button' name='detail' value='detail'></a></td>
						</tr>";
					}

					$rowcount = mysqli_query($con, "SELECT COUNT(*) FROM recettes;");					
					$nbrows = mysqli_fetch_row($rowcount);
					$pagenumbers = ceil($nbrows[0] / 10);

					if (isset($_POST['searchbtn'])) 
					{		
						$searchedrecipe = $_POST['recipesearch'];
						$sql = "SELECT * FROM recettes WHERE idmembre='$recipeowner' AND (idrecette LIKE '%$searchedrecipe%' OR nom LIKE '%$searchedrecipe%' OR ingredients LIKE '%$searchedrecipe%');";
						$search = mysqli_query($con,$sql);
						$nbre = mysqli_num_rows($search);

						showrecipes($search);				
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
						echo "<a href='memberindex.php?links=myrecipe&pagenb=$i'>$i</a>";
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