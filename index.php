



<?php

function base()
 {
 $dbhost = "localhost";
 $dbuser = "me";
 $dbpass = "mdp";
 $db = "todo_list";
 $indice = 0; 
    
    try
	{
		$bdd = new PDO('mysql:host=localhost;dbname='.$db.';charset=utf8', $dbuser, $dbpass);
        $bdd ->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
    
    
	if (isset($_GET["id"])){
             
        
        $stmt = $bdd->prepare("DELETE FROM liste WHERE id=?");
        $stmt->execute(array($_GET['id']));

        echo "<p>test</p>";
		//$bdd->query("DELETE FROM liste WHERE id=".$_GET["id"]."");
	}
	
	if (isset($_POST["tache"])){
        
                echo "<p>test</p>";

		$message = $_POST['tache'];
        
        if($message != ""){
            $stmt = $bdd->prepare("INSERT INTO liste (tache) VALUES (?)");
            $stmt->execute(array($message));
        }
        
		//$bdd->query("INSERT INTO liste (tache) VALUES ('".sanitize_string($message)."')");
	}
	
	$reponse = $bdd->query('SELECT id, tache FROM liste');
	
	while ($donnees = $reponse->fetch())
	{
		echo "<li id=croix".$indice."><a id=\"croix\" href=\"#\" onclick=\"supprimer(".$donnees['id'].",".$indice.")\"> x </a>".$donnees['tache']."</li>";
        $indice++;
	}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>
    <meta charset="utf-8">
   
    <style>
			#croix{
				color:white;
				text-decoration:none;
				right:5%;
				background-color:red;
                margin-right: 2vw;
				padding-right:5px;
				padding-left:5px;
			}
			ul{
				list-style:none;
			}
		</style>
    </head>
		
	<body> 
        <script>

            function supprimer(id, id_liste){
                const xhr_object = new XMLHttpRequest();
                xhr_object.open('DELETE', `http://localhost/DIP/todoo/index.php?id=${id}`);
                xhr_object.send();
                var list = document.getElementById("todoliste");
                list.removeChild(list.childNodes[id_liste]);
            }

        </script>
	
	    
	
		<h1>TODOO</h1>
		<form action="index.php" method="post">
					 <input type="text" name="tache"/>
					 <input type="submit" value="Ajouter">
		</form>

        <ul id="todoliste">
            <?php
                base();
            ?>
        </ul>
                
	</body>
</html>

