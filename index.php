<?php
	$erreurs = "";
	// connect to database
	$bdd = mysqli_connect("localhost", "me", "mdp", "todo_list");

	// insert a quote if submit button is clicked
	if (isset($_POST['ajouter'])) {
		if (empty($_POST['message'])) {
			$erreurs = "Y'a un p'tit problème pendant l'insertion, pourquoi ça n'ajoute pas";
		}else{
			$message = $_POST['message'];
			$sql = "INSERT INTO todo_list (message) VALUES ('$message')";
			mysqli_query($bdd, $sql);
			header('location: index.php');
		}
	}	

  if (isset($_GET['supprimer'])) {
	$indice = $_GET['supprimer'];

	mysqli_query($bdd, "DELETE FROM todo_list WHERE id=".$indice);
	header('location: index.php');
  }   
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>
    <meta charset="utf-8">
    
</head>

<body>
    
    <div>
		<h2>TODO LIST</h2>
	</div>
	<form method="post" action="index.php">
		<input type="text" name="message">
		<button type="submit" name="ajouter" id="ajout_btn">Add Task</button>
	</form>
    
    <table>
	<thead>
		<tr>
			<th>N</th>
			<th style="width: 60px;">Tasks</th>
			<th style="width: 60px;">Action</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$message = mysqli_query($bdd, "SELECT * FROM todo_list");

		$numero = 1; while ($msg = mysqli_fetch_array($message)) { ?>
			<tr>
				<td> <?php echo $numero; ?> </td>
				<td> <?php echo $msg['message']; ?> </td>
				<td> 
					<a href="index.php?supprimer=<?php echo $msg['id'] ?>">x</a> 
				</td>
			</tr>
		<?php $numero++; } ?>	
	</tbody>
</table>

    
</body>

</html>