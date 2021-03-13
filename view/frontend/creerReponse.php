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
                	Ajouter une réponse pour la question '. $_GET['idQuestion'].'
            	</p>';
        	
            ?>
            
        </div>
    
	    <form action="#" method="post" name="formulaire">  
			<table class="tabLicence">
				<tr>
					<th class="tabLicence">Question</th>
					<th class="tabLicence">Moteur de recherche de réponses</th>
				</tr>
				
				<?php 
				while ($data = $question->fetch())
				{
				?>
				<tr>
					<td class="tabLicence" style="width: 40%;"> <?php echo $data['question']; ?></td>
					<td class="tabLicence" style="width: 40%;">Séparation par un slash "/": <textarea id="searchReponse" name="searchReponse" rows="1"></textarea></td>
					<td class="tabLicence" style="width: 40px; padding:5px;"> <input type="submit" name="submitSearch" value="Rechercher"></td>
				</tr>
				<?php
				}
				$question->closeCursor();
				?>
			</table>

			<p>Associer une réponse trouvée dans la recherche </p>
			<table class="tabLicence">
				<tr>
					<th class="tabLicence">Associer une réponse</th>
				</tr>
				<tr>
					<td class="tabLicence" style="width: 70%;">	
						<select name="selectReponse" id="selectReponse">
						<?php
							while ($dataReponse = $listReponses->fetch())
							{
								echo '<option value="'.$dataReponse['id_reponse'].'">'.$dataReponse['response']."</option>";
							}
							$listReponses->closeCursor();
						?>
						</select>
					</td>
					<td class="tabLicence" style="width: 40px; padding:5px;"> <input type="submit" name="submitAssociate" value="Associer"></td>
				</tr>
			</table>

			<p>Créer une nouvelle réponse : </p>
			<table class="tabLicence">
				<tr>
					<th class="tabLicence">Créer réponse</th>
				</tr>
				<tr>
					<td class="tabLicence" style="width: 70%;"><textarea id="createReponse" name="createReponse" rows="1"></textarea></td>
					<td class="tabLicence" style="width: 40px; padding:5px;"> <input type="submit" name="submitCreate" value="Créer"></td>
				</tr>
				
			</table>
		</form>
	</div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>