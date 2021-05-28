<?PHP
	$playerid = $_GET['id'];
	if(isset($playerid) and is_numeric($playerid)) {
		$playerinformations = mysqli_query($conn, "SELECT * FROM `players` WHERE `id`=".$playerid);
		if ($playerinformations) {
			$playerinformations = mysqli_fetch_array($playerinformations);
			if ($playerinformations) {
				echo '<br><style>.form-control {text-align: center;} .form-control-text {width: 300px;} select#invite { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select {display: flex; align-items: center; justify-content: flex-start;}</style><center><div class="container">
				<br><br><br><br><div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><center>Gracz '.$playerinformations["nazwa"].'</center></h3>
					</div>
					<div class="panel-body">
					<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col" colspan="2">Informacje o graczu</center></th>
						</tr>
					</thead>
					<tbody>
					<tr><td><b>Nazwa:</b></td><td>'.$playerinformations["nazwa"].'</td></tr>
					<tr><td><b>Dywizja:</b></td><td>'.Functions::idToDivision($playerinformations["dywizja"]).'</td></tr>';
					$druzyna = $playerinformations["druzyna"];
					$druzynatext = "Brak drużyny";
					if($druzyna > 0) {
						$query2 = mysqli_query($conn, "SELECT * FROM `teams` WHERE `id`= '".$druzyna."' LIMIT 1");
						if($query2) {
							$query2 = mysqli_fetch_array($query2);
							if($query2["potwierdzony"] == 1) {
								$druzynatext = '<a href="./?p=showteam&id='.$query2["id"].'">'.$query2["nazwa"].'</a>';
							} else {
								$druzynatext = 'Brak potwierdzonej drużyny';
							}
						}
					}
					echo '
					<tr><td><b>Druzyna:</b></td><td>'.$druzynatext.'</td></tr>
					<tr><td><b>Nazwa EUNE:</b></td><td>'.$playerinformations["nickeune"].'</td></tr>
					<tr><td><b>Główna pozycja:</b></td><td>'.Functions::idToPosition($playerinformations["pozycja"]).'</td></tr>
					<tr><td><b>Druga pozycja:</b></td><td>'.Functions::idToPosition($playerinformations["pozycjadruga"]).'</td></tr>
					</tbody>
					</table>
					</div></div></div>';
			}
		}
	} else {
		header("Refresh:0; url=?p=mainpage");
	}
?>