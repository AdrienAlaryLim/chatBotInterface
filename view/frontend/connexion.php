<?php 
$styleMenu = '"main style2"';
ob_start();
?>


<section class="main style3">
    <div class="container">
    <!--<div class="row gtr-150"> !-->
        <div class="col-6 col-12-medium"> 
        	<?php if($inscription){
        		echo '<p class="fondGris">
                	Veuillez renseigner ces champs afin de vous inscrire. Après ceci vous pourrez effectuer votre achat.
            	</p>';
        	}else{
        		echo '<p class="fondGris">
                	Veuillez vous connecter afin d\'effectuer votre achat.
            	</p>';
            } 
            ?>
            
        </div>
      
		<form action="#" method="post" name="formulaire">  
			<p class="fondGris"> 
				Adresse mail <br /><input class="champFormulaire" type="text" name="mailUtilisateur" placeholder="exemple@mail.com" required/>
				Mot de passe <br /><input class="champFormulaire" type="password" name="mdpUtilisateur" value="" placeholder="MotPa$$e" required/>
				<?php if($inscription)
				{
	        		echo 'Confirmez le mot de passe <br /><input class="champFormulaire" type="password" name="verifMdp" value="" placeholder="MotPa$$e" required/>
	        		Adresse client<br /><input class="champFormulaire" type="text" name="adresseUtilisateur" placeholder="13 rue de Poitoux" required/>
					Entreprise <br /><input class="champFormulaire" type="text" name="nomUtilisateur" value="" placeholder="Limayrac" required/>';
				}?>
				
				
			</p>
			<input type="submit" name="submit" value="Se connecter"></br></br>
		</form>

		
	</div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>