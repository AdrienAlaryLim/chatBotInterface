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
        			<br> <br>
                	Voici la liste des couples de questions / réponses dont le bot est peu confiant
            	</p>';
        	
            ?>
            
        </div>
      
	<table class="tabLicence">
			<tr>
				<th class="tabLicence">Question</th>
				<th class="tabLicence">Reponse</th>
				<th class="tabLicence">Confiance</th>
				<th class="tabLicence">Modifier réponse</th>
			</tr>
			
			<?php 
			while ($data = $list->fetch())
			{
			?>
				<tr>
					<td class="tabLicence" style="width: 40%;"> <?php echo $data['question']; ?></td>
					<td class="tabLicence" style="width: 40%;"> <?php echo $data['response']; ?></td>
					<td class="tabLicence" style="width: 70px; border-right: 1px solid #ddd; text-align: center;"> <?php echo $data['confiance']; ?></td>
					<td class="tabLicence" style="width: 110px;"> <a href=<?php echo '"index.php?action=modifierCouple&idReponse='.$data['id_reponse'].'&idQuestion='.$data['id_question'].'&conflicts='.$data['mots_cles_associes'].'"';?>> <img src="public/images/plus_36px.png" alt="Add_Response"> </a> </td>
				</tr>
			<?php
			}				
			$list->closeCursor();
			?>
		</table>
		
	</div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>