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
					<td class="tabLicence" style="width: 40%;"><textarea id="reponse" name="reponse" rows="1"></textarea></td>
					<td class="tabLicence" style="width: 40px; padding:5px;"> <input type="submit" name="submit" value="Ajouter"></td>
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