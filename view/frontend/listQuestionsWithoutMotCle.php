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
                	Voici la liste des questions dont le mot clé est inexistant
            	</p>';
        	
            ?>
            
        </div>
      
		<table class="tabLicence">
			<tr>
				<th class="tabLicence">Id Question</th>
				<th class="tabLicence">Date question</th>
				<th class="tabLicence">Question</th>
				<th class="tabLicence">Ajouter mot clé</th>
			</tr>
			
			<?php
			while ($data = $list->fetch())
			{
			?>
				<tr>
					<td class="tabLicence" style="width: 130px; border-left: 1px solid #ddd; text-align: center;"> <?php echo $data['id_question']; ?></td>
					<td class="tabLicence"> <?php echo dateFormat($data['date_question']); ?></td>	
					<td class="tabLicence"> <?php echo $data['question']; ?></td>
					<td class="tabLicence" style="width: 150px; padding:5px;"> 
						<a href=<?php echo '"index.php?action=creerMotCle&idQuestion='.$data['id_question'].'"';?>> <img src="public/images/plus_36px.png" alt="Add_Response"> </a> </td>
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