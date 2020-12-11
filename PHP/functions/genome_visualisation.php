<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="css_page_de_garde.css">

<html>
	<?php
		include_once('functions/connection.php');
		session_start();

		echo "<div style = 'position:fixed;'>" . $_SESSION['visualisation_genome'] . "</div><br><br>";

		# Variable session visualisation génome : nom du génome à visualiser
		$query_genome = "SELECT * FROM db_genome.genome as genome WHERE genome.nom_genome = '" . $_SESSION['visualisation_genome'] . "';";

		connect_db();

		$genome_answer = pg_fetch_array(pg_query($GLOBALS['db_conn'], $query_genome), null, PGSQL_ASSOC);

		$start = 500;
		$stop = 1500;

		if(isset($_POST['start'])){
			$start = $_POST['start'];
		}

		if(isset($_POST['stop'])){
			$stop = $_POST['stop'];
		}


		echo "<table border='0' style = 'font-size:0.5em;font-weight:bold;'>";

		#Première ligne : graduation du génome 25 par 25
		echo "<tr>";

		for($i = $start; $i < $stop; $i++){
			if($i % 25 == 0){
				echo "<td>" . $i . "<td>";
			} else {
			echo "<td></td>";
			}
		}
		echo "</tr>";

		#Deuxième ligne : génome
		echo "<tr>";
		echo "<td></td>";

		for($i = $start; $i < $stop; $i++){
			echo "<td>"; echo array_values($genome_answer)[1][$i]; echo "</td>";
		}
		echo "</tr>";

		#Troisième ligne : gènes
		echo "<tr>";
		for($i = $start; $i < $stop; $i++){
			$query_gene = "SELECT cds_sequence, seq_end, seq_start, gene FROM db_genome.cds as cds WHERE cds.nom_genome = '". $_SESSION['visualisation_genome'] . "' AND cds.seq_start = " . $i . ";";
			$temp = pg_fetch_array(pg_query($GLOBALS['db_conn'], $query_gene), 0, PGSQL_ASSOC);

			#Pour chaque position sur le génome, on vérifie s'il existe un gène à cette position

			#si oui
			if($temp != ""){
				#on stock le nom du gène dans une table de hash avec la position du nucléotide comme clef
				$gene_subscript[$i] = array_values($temp)[3];

				#On print la séquence du gène
				for($j = $i; $j < array_values($temp)[1]; $j++){
					echo "<td style = 'color: red;'>";
					echo array_values($temp)[0][$j - $i] . "&nbsp";
					echo "</td>";
					if($j == $stop){break;}
				}
				echo "<td> </td>";

				#on repart à la position du nucléotide de stop
				$i = $j;
			} else {echo "<td> </td>";}
		}
		echo "</tr>";

		echo "<tr>";
		
		#Pour chaque position, on regarde si un nom de gène est associé dans la table de hash
		for($i = $start; $i < $stop; $i++){
			if(isset($gene_subscript[$i])){
				echo "<td>";
					#si oui, on affiche le nom du gène dans la case
					echo $gene_subscript[$i];
				echo "</td>";				
			} else {
					#si non, case vide
				echo "<td> </td>";
			}
		}
		echo "</tr>";

		echo "</table>";
		echo "<br>";

		close_db();

		pg_free_result($gene_answer);
		pg_free_result($genome_answer);
	?>

</html>
<br>

<?php #Menu de sélection de la zone à visualiser ?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" style = "position: fixed;">
	<label class = "text_query_form">Start</label>
	<input name="start" value = <?php echo $_POST['start'] ?>></textarea>
	<br>
	<label class = "text_query_form">Stop</label>
	<input name="stop" value = <?php echo $_POST['stop'] ?>></textarea>

	<button name = "query_gene" type="submit" style ="float:right; margin-right:-10%;">Redéfinir la taille de la fenêtre</button>
</form>
