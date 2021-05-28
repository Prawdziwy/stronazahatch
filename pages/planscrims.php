<?PHP
	if(isset($_SESSION['access_token'])) {
		$query5 = mysqli_query($conn, "SELECT * FROM `teams` WHERE `lider`='".$_SESSION['userid']."' AND `potwierdzony`=1");
		if ( ($query5 && $query5->num_rows > 0) or ($_SESSION['userid'] == "326356340630880256") ) {
			$query5 = mysqli_fetch_array($query5);
			echo '<br><br><br>
			<style>
			.form-inline {
				display: inline-block;
			}
			.btn-inline {
				display: inline-block;
			}
			</style>
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><center>Skrimy</center></h3>
					</div>
					<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col"><center>Druzyna</center></th>
								<th scope="col"><center>Zakres godzin</center></th>
								<th scope="col"><center>Zakres dni</center></th>
								<th scope="col"><center>Zapytaj</center></th>
							</tr>
						</thead>
						<tbody>';
							$disabled2 = "";
							$query = mysqli_query($conn, "SELECT * FROM `scrims`");
							if($query && $query->num_rows > 0) {
								foreach($query as $skrim) {
									$druzyna = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$skrim["druzyna"]."' LIMIT 1"));
									$disabled = "";
									if ($query5["id"] == $druzyna["id"]) {
										$disabled = "disabled";
										$disabled2 = "disabled";
									}
									echo '<tr>
									<td><center><a href="./?p=showteam&id='.$skrim["druzyna"].'">'.$druzyna["nazwa"].'</a></center></td>
									<td><center>'.$skrim["godzina1"].'-'.$skrim["godzina2"].'</center></td>
									<td><center>'.Functions::idToDay($skrim["dni1"]).'-'.Functions::idToDay($skrim["dni2"]).'</center></td>
									<td><center><form method="post" action="./?p=askscrim&id='.$skrim["id"].'"><button type="submit" class="btn btn-primary btn-sm" '.$disabled.'>Zapytaj</button></form></center></td></tr>';
								}
							} else {
								echo '<tr><td colspan="5">Nie ma żadnych propozycji skrimow</td></tr>';
							}
						echo '</tbody>
					</table>
					<center>
					<form method="post" action="./?p=certainaskscrim" class="form-inline"><button type="submit" class="btn btn-primary btn-lg btn-inline">Zaproponuj danej drużynie</button></form>
					<form method="post" action="./?p=getscrim" class="form-inline"><button type="submit" class="btn btn-primary btn-lg btn-inline" '.$disabled2.'>Zaproponuj wszystkim</button></form>
					<form method="post" action="./?p=propsscrim" class="form-inline"><button type="submit" class="btn btn-primary btn-lg btn-inline">Propozycje skrimow</button></form>
					</center>
					</div>
				</div>
			</div>';
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
	} else {
		header("Refresh:0; url=?p=mainpage");
	}
?>