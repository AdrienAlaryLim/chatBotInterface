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
                	Voici la liste des questions
            	</p>';
        	
            ?>
            
        </div>
      
	<table class="tabLicence">
			<tr>
				<th class="tabLicence">IdReponse</th>
				<th class="tabLicence">Reponse</th>
			</tr>
			
			<?php 
			while ($data = $list->fetch())
			{
			?>
				<tr>
					<td class="tabLicence" style="width: 70px; border-left: 1px solid #ddd; text-align: center;"> <?php echo $data['id_reponse']; ?></td>
					<td class="tabLicence"> <?php echo $data['response']; ?></td>
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