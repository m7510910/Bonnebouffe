<!DOCTYPE html>
<html>
<head>
	<title>Recettes</title>
</head>
<body>

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

		/*$startdir = getcwd();
		$uploaddir = '/Bonnebouffe/images/';

		$fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

	    if(isset($_POST['createbtn']))
	    {
	    	$fileName = $_FILES['photo']['name'];
	    	$fileSize = $_FILES['photo']['size'];
	    	$fileTmpName  = $_FILES['photo']['tmp_name'];
	    	$fileType = $_FILES['photo']['type'];
	    	$fileExtension = strtolower(end(explode('.',$fileName)));

	    	$uploadPath = $startdir . '/'. basename($fileName); 

	    	echo "$uploadPath";

	    	if (! in_array($fileExtension,$fileExtensions)) 
	    	{
	            echo "Extension non autorisser";
	        }
	    	elseif($fileSize > 2000000)
	    	{
	    		echo "Taille de fichier trop grand, 2MB max";
	    	}
	    	else
	    	{
	    		$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

	    		if ($didUpload) 
	    		{
	                echo "Le fichier " . basename($fileName) . " has been uploaded";
	            } 
	            else 
	            {
	                echo "Une erreur est survenue veuillez ressayez plustard ou contactez un admin";
	            }
	    	}


	    }*/
	    if(isset($_POST['createbtn']))
	    {


		    $target_dir = getcwd();
		    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		    $uploadOk = 1;
		    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		    // Check if image file is a actual image or fake image
		    if(isset($_POST["submit"])) {
		        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		        if($check !== false) {
		            echo "File is an image - " . $check["mime"] . ".";
		            $uploadOk = 1;
		        } else {
		            echo "File is not an image.";
		            $uploadOk = 0;
		        }
		    }
		    // Check if file already exists
		    if (file_exists($target_file)) {
		        echo "Sorry, file already exists.";
		        $uploadOk = 0;
		    }
		    // Check file size
		    if ($_FILES["fileToUpload"]["size"] > 500000) {
		        echo "Sorry, your file is too large.";
		        $uploadOk = 0;
		    }
		    // Allow certain file formats
		    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		    && $imageFileType != "gif" ) {
		        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		        $uploadOk = 0;
		    }
		    // Check if $uploadOk is set to 0 by an error
		    if ($uploadOk == 0) {
		        echo "Sorry, your file was not uploaded.";
		    // if everything is ok, try to upload file
		    } else {
		        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		        } else {
		            echo "Sorry, there was an error uploading your file.";
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
							<td><input class='tdinput' type='text' name='namelist[]' value='$name'></td>
							<td><input class='tdinput' type='text' name='ingredientlist[]' value='$ingredient'></td>
							<td><input class='tdinput' type='text' name='preparationlist[]' value='$preparation'></td>
							<td><input class='tdinput' type='text' name='nbpersonlist[]' value='$nbperson'></td>
							<td><input class='tdinput' type='text' name='costlist[]' value='$cost $'></td>
							<td><img class='recipeimg' src='./images/$photo'></td>
							<td><input class='tdinput' type='text' name='datelist[]' value='$date'></td>
							<td><input class='tdinput' type='text' name='authorlist[]' value='$author'></td>
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
							<td><input class='tdinput' type='text' name='namelist[]' value='$name'></td>
							<td><input class='tdinput' type='text' name='ingredientlist[]' value='$ingredient'></td>
							<td><input class='tdinput' type='text' name='preparationlist[]' value='$preparation'></td>
							<td><input class='tdinput' type='text' name='nbpersonlist[]' value='$nbperson'></td>
							<td><input class='tdinput' type='text' name='costlist[]' value='$cost $'></td>
							<td><img class='recipeimg' src='./images/$photo'></td>
							<td><input class='tdinput' type='text' name='datelist[]' value='$date'></td>
							<td><input class='tdinput' type='text' name='authorlist[]' value='$author'></td>
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