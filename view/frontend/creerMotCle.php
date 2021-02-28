<?php 
$styleMenu = '""';
ob_start();
?>

<section class="main style3">
    <div class="container">
    <!--<div class="row gtr-150"> !-->
        <div class="col-6 col-12-medium"> 
        	<?php 
        		echo '<p class="fondGris">
                	Association de mots cles pour la question '. $_GET['idQuestion'].'
            	</p>';
        	
            ?>
            
        </div>
    
	    <form action="#" method="post" name="formulaire">  
			<table class="tabLicence">
				<tr>
					<th class="tabLicence">Question</th>
					<th class="tabLicence">Moteur de recherche mots cles</th>
				</tr>
				
				<?php 
				while ($data = $question->fetch())
				{
				?>
				<tr>
					<td class="tabLicence" style="width: 40%;"> <?php echo $data['question']; ?></td>
					<td class="tabLicence" style="width: 40%;">Séparation par un slash "/": <textarea id="searchMotCle" name="searchMotCle" rows="1"></textarea></td>
					<td class="tabLicence" style="width: 40px; padding:5px;"> <input type="submit" name="submitSearch" value="Rechercher"></td>
				</tr>
				<?php
				}
				$question->closeCursor();
				?>
			</table>

			<p>Associer un mot clé trouvé dans la recherche </p>
			<table class="tabLicence">
				<tr>
					<th class="tabLicence">Associer un mot clé trouvé</th>
				</tr>
				<tr>
					<td class="tabLicence" style="width: 70%;">	
						<select name="selectMotCle" id="selectMotCle">
						<?php
							
							while ($dataMotCle = $listMotsCles->fetch())
							{
								echo '<option value="'.$dataMotCle['mot'].'">'.$dataMotCle['mot']."</option>";
							}
							echo '';
							$listMotsCles->closeCursor();
						?>
						</select>
					</td>
					<td class="tabLicence" style="width: 40px; padding:5px;"> <input type="submit" name="submitAssociate" value="Associer"></td>
				</tr>
			</table>

			<p>Créer un nouveau mot clé : </p>
			<table class="tabLicence">
				<tr>
					<th class="tabLicence">Créer mot clé</th>
				</tr>
				<tr>
					<td class="tabLicence" style="width: 70%;">Mots séparés par des slash "/":<textarea id="createMotCle" name="createMotCle" rows="1"></textarea></td>
					<td class="tabLicence" style="width: 40px; padding:5px;"> <input type="submit" name="submitCreate" value="Créer"></td>
				</tr>
				
			</table>
		</form>
	</div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>