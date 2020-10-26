<?php
$base= new PDO('mysql:host=localhost;dbname=classs','root','') ;
if(isset($_POST["login"])){$numrow=0;
	if ($_POST["nom"]=="admin" && $_POST["password"]=="admin") {
		echo "<script>window.open('admin.php','_self')</script>";
		
	} 
	else{
	$reponse= $base->prepare('SELECT * FROM etudiant  where ( nom=? and password=? )   ') ;
    $reponse->execute(array($_POST['nom'] , $_POST['password']  )) ;
                   
        while($donnees=$reponse->fetch())
          {$numrow+=1;
           
          }
                if($numrow==0){ 
                	echo "<script>alert('ERREUR :Il faut faire une inscription');</script>"; 
		echo "<script>window.open('login.html','_self')</script>";
                }
                	else {
		          echo "<script>window.open('user.php','_self')</script>";

                	} 
                }

	}
	
   
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bonjour user</title>
	<meta charset="utf-8" />
</head>
<style >

		body{
			box-shadow: 1px 6px 17px green ;
			margin-left: 25% ;
			margin-right: 35% ;
			margin-top: 20px ;
			padding-top: 10px ;
			padding-bottom: 15px ;
			
		    font-family: 'Times New Roman','Lucida Sans', 'Lucida Sans Regular', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

			text-align: center; }
	.color{
	color: red ;

	}
	.couleur{
	color: blue;
	}

	</style>
<body >
	<h1 class="couleur"> Bonjour Monsieur l'utilisateur : </h1>
	<h2 class="color">Pour uploader un fichier il faut remplir le formulaire ci-dessous : </h2>
	<form action="" method="POST" enctype="multipart/form-data" class="couleur" >
		<tr>
			<td> Titre :</td>
			<td><input type="text" name="titre"  id="titre" placeholder="Titre de fichier" size="40" required><br/></td>	
		</tr>
		<tr><br>
			<td> Genre :</td>
			<td><input type="text" name="genre"  id="genre" placeholder="Genre de fichier" size="40" required><br/></td>	
		</tr>
		<tr><br>
			<td> Resumé :</td>
			<td><input type="text" name="resume"  id="resume" placeholder="Resumé de fichier" size="40" required><br/></td>	
		</tr>
		<tr><br>
			<td> Nombres des pages :</td>
			<td><input type="number" name="number_page"  id="number_page" placeholder="Nombre des pages" size="40" required><br/></td>	
		</tr>
		<td><br> <input type="file" name="fichier"  / > <br> </td>
		<td><br><input type="submit" name="submit" value="Deposer le fichier"> </td>		
	</form>
	<?php 
	if (isset($_POST['submit'])){
	$base= new PDO('mysql:host=localhost;dbname=classs','root','') ;
	$file_name = $_FILES['fichier']['name'];
	
	$file_tmp_name =  $_FILES['fichier']['tmp_name'];
	$file_destination = 'files/'.$file_name ;
    $attent=0;
	


	
	   if (move_uploaded_file($file_tmp_name,$file_destination )) {
	//echo "<script>alert('Fichier envoyé avec succés') ;</script>" ;

		$requete = $base->prepare("INSERT INTO files(titre,genre,resume,nombre_page,attent,name,destination) VALUES(?,?,?,?,?,?,?)") ;
        $requete->execute(array($_POST['titre'],$_POST['genre'],$_POST['resume'],$_POST['number_page'],$attent,$file_name,$file_destination) );
		echo "<script>window.alert('Fichier envoyé avec succés')</script>";
		echo "<script>window.open('user.php','_self')</script>";

		//echo "Fichier envoyé avec succés";
	   } else{
		echo "<script>window.alert('ilya une erreur lors de l'envoi de fichier')</script>";
		echo "<script>window.open('user.php','_self')</script>";
		

	    //echo "ilya une erreur lors de l'envoi de fichier";
		}
	}
	?>
<h2 class="color">Listes des fichiers : </h2>

<?php
$base= new PDO('mysql:host=localhost;dbname=classs','root','') ;
$reponse= $base->query("SELECT * FROM files where attent='1'") ;
while($donnees=$reponse->fetch()) 
{ 
	//echo $donnees['Titre'].' : '.'<a href="'.$donnees['file_destination'].'">Télecharger '.$donnees['name'].'</a>';
	
    echo "<h4> Fichier n°  ".$donnees['id']."</h4>";
    echo "name: ".$donnees['name']."<br>";
    echo "titre: ".$donnees['titre']."<br>";	
    echo "genre: ".$donnees['genre']."<br>";
    echo "resumé: ".$donnees['resume']."<br>";
    echo "nombre de pages: ".$donnees['nombre_page']."<br>";
    echo "<form method='post' action='".$donnees['destination']."' ><input  type='submit'  name='Confirmer' value='Telecharger'></form><br>" ;
   
}
?>
<h2 class="color" >Listes des fichiers Réclamés :</h2>
<?php

$base= new PDO('mysql:host=localhost;dbname=classs','root','') ;
$reponse= $base->query("SELECT * FROM files where attent='2'") ;
while($donnees=$reponse->fetch()){
    

    echo "<h4> fichier n°  ".$donnees['id']."</h4><br> " ;
    echo "ilya une rectification dans ce fichier : Réctufication: ".$donnees['resume']."<br>";
}
?>

<h1 align="center" >
	<?php 
     echo "<a href='login.html'> Déconnectez-vous</a>";
	?>
</h1>
</body>
</html>