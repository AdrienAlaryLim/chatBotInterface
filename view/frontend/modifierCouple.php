<?php 
$styleMenu = '""';
ob_start();
?>

<section class="main style3">
    <div class="container">
        <div class="col-6 col-12-medium"> 
        	<?php 
        		echo '<p class="fondGris">
                	Ajouter une réponse pour la question '. $_GET['idQuestion'].', cette nouvelle réponse sera associée à la question
            	</p>';
        	
            ?>
        </div>
    
	    <form action="#" method="post" name="formulaire">  
			<table class="tabLicence">
				<tr>
					<th class="tabLicence">IdQuestion</th>
					<th class="tabLicence">Question</th>
					<th class="tabLicence">Reponse</th>
				</tr>
				
				<?php 
				while ($data = $list->fetch())
				{
				?>
				<tr>
					<td class="tabLicence" style="width: 70px; border-left: 1px solid #ddd; text-align: center;"> <?php echo $data['id_question']; ?></td>
					<td class="tabLicence" style="width: 40%;"> <?php echo $data['question']; ?></td>
					<td class="tabLicence" style="width: 40%;"><p id="reponse" name="reponse" rows="5"><?php echo $data['response']; ?></p></td>
					<table class="tabLicence">
						<tr> 
							<th class="tabLicence">Confirmer cette réponse</th>
							<th class="tabLicence">Choisir une autre phrase</th>
						</tr>
						<tr>
							<td class="tabLicence"> <input type="submit" name="submitConfirm" value="Confirmer"> </br> </td>
							<td class="tabLicence"> <input type="submit" name="submitModify" value="Modifier"></td>
							<input type="hidden" name="conflicts" value=<?php echo $data['mots_cles_associes']; ?>> 
						</tr>
					</table>
				</tr>
				<?php
				}
				$list->closeCursor();
				?>
			</table>
		</form>
	</div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>