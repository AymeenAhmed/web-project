<?php 
$base= new PDO('mysql:host=localhost;dbname=classs','root','') ;


if(isset($_POST["inscription"])){$numrow=0;
 $reponse= $base->prepare('SELECT * FROM etudiant  where nom=?  ') ;
   $reponse->execute(array($_POST['nom'])) ;
                   
        while($donnees=$reponse->fetch())
          {$numrow+=1;
            echo "<script>alert('ERREUR :Ce pseudo est déja utilisé');</script>";
		    echo "<script>window.open('login.html','_self')</script>";}

                if($numrow==0){
                $requete = $base->prepare('INSERT INTO etudiant(nom,password,email) VALUES(?,?,?)') ;
                $requete->execute(array($_POST['nom'],$_POST['password'],$_POST['email'])) ;
                    echo "<h5>votre compte a éte crée avec succee</h5>" ;}
                    }


?>

<!DOCTYPE html>
<html>
<head>
	<title>insciption</title>
</head>
<style >
		body{
			box-shadow: 1px 6px 17px green ;
			margin-left: 25% ;
			margin-right: 35% ;
			margin-top: 20px ;
			padding-top: 10px ;
			padding-bottom: 15px ;
			text-decoration-line: underline;
			font-family: 'Times New Roman','Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

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
<form class="couleur">
	<table align="center">
		<tr>
			<td for="nom" id="nom" align="right" class="color"> Nom et prenom : </td> <br>
			<td>
			<?php echo ($_POST['nom']) ?> </td>
						
        </tr>
        
        <tr>
	        <td for="Email" id="Email" align="right" class="color" >Adresse Email :</td> 
	        <td>
	     <?php  echo ($_POST['email']) ?>
	        </td>			
        </tr>
	</table>

        <p><a href="login.html"> Retourner a la page de Login vous pouvez connecter maintenant </a></p>

    </form>
</body>
</html>