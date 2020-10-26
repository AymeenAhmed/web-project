
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
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

			text-align: center;
		}
		.color{
	color: red ;

	}
	.couleur{
	color: blue;
	}

	</style>
<body>
<h1 class="color">
	<?php
	echo "Bonjour monsieur l'admin : ";
	?>
</h1>
<h2 class="couleur">Listes des fichiers : </h2>

<?php
$base= new PDO('mysql:host=localhost;dbname=classs','root','') ;
$reponse= $base->query("SELECT * FROM files where attent='0'") ;
while($donnees=$reponse->fetch()) 
{ 
	
	
    echo "<h4> Fichier n°  ".$donnees['id']."</h4>";
    echo "name: ".$donnees['name']."<br>";
    echo "titre: ".$donnees['titre']."<br>";	
    echo "genre: ".$donnees['genre']."<br>";
    echo "resumé: ".$donnees['resume']."<br>";
    echo "nombre de pages: ".$donnees['nombre_page']."<br>";
    echo "<form method='post'  >
    <input  type=hidden name='identité' value='".$donnees['id']."' > 
    <input  type='submit'  name='Confirmer' value='Postuler  le fichier' ><br>
    <input  type='submit'  name='delete'    value='Supprimer le fichier'><br>
    <input  type='submit'  name='rectifier' value='Réctifier le fichier'>
           </form><br>" ;
   
}
if(isset($_POST['Confirmer'])){
$var=$_POST['identité'] ;
$base= new PDO('mysql:host=localhost;dbname=classs','root','') ;
$reponse= $base->query(" UPDATE files SET attent='1'  where id=$var ") ;
echo "<script>alert('le Fichier est Postuler') ;</script>" ;
echo "<script>window.open('admin.php','_self')</script>";
}

if(isset($_POST['delete'])){
$var=$_POST['identité'] ;
$base= new PDO('mysql:host=localhost;dbname=classs','root','') ;
$reponse= $base->query(" DELETE FROM files   where id=$var ") ;
echo "<script>alert('le Fichier est bien Supprimer') ;</script>" ;
echo "<script>window.open('admin.php','_self')</script>";
}



if (isset($_POST['rectifier'])) {
session_start();
	$var=$_POST['identité'] ;
	$_SESSION['var']=$var ;
    $base= new PDO('mysql:host=localhost;dbname=classs','root','') ;
   
	$ok= "" ;


	echo "<script>var msg = prompt('veuillez declarer une rectification monsieur ladmin : ');     msg=window.location.href='admin.php?msg='+msg;</script>" ;}
if (isset($_GET["msg"])) {
//echo "<script>alert('1') ;</script>" ;
session_start();

$ok=$_GET["msg"] ;
//echo "<script>alert('".$ok."') ;</script>" ;
$var=$_SESSION['var'] ;


//echo "<script>alert('2') ;</script>" ;

$sql = "UPDATE files SET attent=?,resume=? where id=? ";
$stmt= $base->prepare($sql);
$stmt->execute(['2',$ok,$var]);


echo "<script>alert('la rectifications envoyée avec succeés') ;</script>" ;
echo "<script>window.open('admin.php','_self')</script>";

}
?>

</body>
</html>