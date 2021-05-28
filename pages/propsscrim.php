<?PHP
	if(isset($_SESSION['access_token'])) {
		$query5 = mysqli_query($conn, "SELECT * FROM `teams` WHERE `lider`='".$_SESSION['userid']."' AND `potwierdzony`=1");
		if ( ($query5 && $query5->num_rows > 0) or ($_SESSION['userid'] == "326356340630880256") ) {
			if (isset($_POST["certain"]) and isset($_POST["idteam"])) {
				$query61 = mysqli_query($conn, "SELECT * FROM `teams` WHERE `id`='".$_POST["idteam"]."' AND `potwierdzony`=1");
				if ($query61 && $query61->num_rows > 0) {
					if ($_POST["certain"] == 0) {
						$skrimdruzyny = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `scrims` WHERE `druzyna`='".$query5["id"]."' LIMIT 1"));
						mysqli_query($conn, "UPDATE `scrimsasks` SET `akceptowany`=1 WHERE `skrim` = '".$skrimdruzyny["id"]."'");
					} else {
						mysqli_query($conn, "UPDATE `scrimscertainasks` SET `akceptowany`=1 WHERE `druzynapytana`='".$query5["id"]."' AND `druzynapytajaca`='".$_POST["idteam"]."'");
					}
					header("Refresh:1; url=?p=propsscrim");
				} else {
					header("Refresh:1; url=?p=planscrims");
				}
			}
			$query5 = mysqli_fetch_array($query5);
			echo '<br><br><br>
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><center>Skrimy</center></h3>
					</div>
					<div class="panel-body">
					<center>Zaproponowane dla ciebie:</center>
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col"><center>Druzyna</center></th>
								<th scope="col"><center>Pierwsza data</center></th>
								<th scope="col"><center>Druga data</center></th>
								<th scope="col"><center>Trzecia data</center></th>
								<th scope="col"><center>Akceptuj</center></th>
							</tr>
						</thead>
						<tbody>';
							$skrimdruzyny = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `scrims` WHERE `druzyna`='".$query5["id"]."' LIMIT 1"));
							$query = mysqli_query($conn, "SELECT * FROM `scrimsasks` WHERE `skrim` = '".$skrimdruzyny["id"]."'");
							$query21 = mysqli_query($conn, "SELECT * FROM `certainaskscrim` WHERE `druzynapytana` = '".$query5["id"]."'");
							if(($query && $query->num_rows > 0) || ($query21 && $query21->num_rows > 0)) {
								foreach($query as $skrim) {
									$druzyna = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$skrim["druzyna"]."' LIMIT 1"));
									$disabled = "";
									if ($skrim["akceptowany"] == 1) {
										$disabled = "disabled";
									}
									echo '<tr>
									<td><center><a href="./?p=showteam&id='.$skrim["druzyna"].'">'.$druzyna["nazwa"].'</a></center></td>
									<td><center>'.$skrim["data1"].'</center></td>
									<td><center>'.$skrim["data2"].'</center></td>
									<td><center>'.$skrim["data3"].'</center></td>
									<td><center><form method="post" action="'.$_SERVER['REQUEST_URI'].'"><input type="hidden" name="certain" id="certain" value="0"/><input type="hidden" name="idteam" id="idteam" value="'.$skrim["druzyna"].'"/><button type="submit" class="btn btn-primary btn-sm" '.$disabled.'>Akceptuj</button></form></center></td></tr>';
								}
								foreach($query21 as $skrimc) {
									$druzyna = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$skrimc["druzyna"]."' LIMIT 1"));
									$disabled = "";
									if ($skrimc["akceptowany"] == 1) {
										$disabled = "disabled";
									}
									echo '<tr>
									<td><center><a href="./?p=showteam&id='.$skrimc["druzyna"].'">'.$druzyna["nazwa"].'</a></center></td>
									<td><center>'.$skrimc["data1"].'</center></td>
									<td><center>'.$skrimc["data2"].'</center></td>
									<td><center>'.$skrimc["data3"].'</center></td>
									<td><center><form method="post" action="'.$_SERVER['REQUEST_URI'].'"><input type="hidden" name="certain" id="certain" value="1"/><input type="hidden" name="idteam" id="idteam" value="'.$skrimc["druzyna"].'"/><button type="submit" class="btn btn-primary btn-sm" '.$disabled.'>Akceptuj</button></form></center></td></tr>';
								}
							} else {
								echo '<tr><td colspan="5">Nie ma żadnych propozycji skrimow</td></tr>';
							}
						echo '</tbody>
					</table>
					<center>Zaproponowane przez ciebie::</center>
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col"><center>Druzyna</center></th>
								<th scope="col"><center>Pierwsza data</center></th>
								<th scope="col"><center>Druga data</center></th>
								<th scope="col"><center>Trzecia data</center></th>
								<th scope="col"><center>Status</center></th>
							</tr>
						</thead>
						<tbody>';
							$query = mysqli_query($conn, "SELECT * FROM `scrimsasks` WHERE `druzyna` = '".$query5["id"]."'");
							$query31 = mysqli_query($conn, "SELECT * FROM `certainaskscrim` WHERE `druzynapytajaca` = '".$query5["id"]."'");
							if(($query && $query->num_rows > 0) || ($query31 && $query31->num_rows > 0)) {
								foreach($query as $skrim) {
									$skrimek = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `scrims` WHERE `id` = '".$skrim["skrim"]."' LIMIT 1"));
									$skrimdruzyna = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$skrimek["druzyna"]."' LIMIT 1"));
									$druzyna = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$skrim["druzyna"]."' LIMIT 1"));
									$status = '<font color="red">Odrzucony</font>';
									if ($skrim["akceptowany"] == 1) {
										$status = '<font color="green">Akceptowany</font>';
									}
									echo '<tr>
									<td><center><a href="./?p=showteam&id='.$skrimdruzyna["id"].'">'.$skrimdruzyna["nazwa"].'</a></center></td>
									<td><center>'.$skrim["data1"].'</center></td>
									<td><center>'.$skrim["data2"].'</center></td>
									<td><center>'.$skrim["data3"].'</center></td>
									<td><center>'.$status.'</center></td></tr>';
								}
								
								foreach($query31 as $skrimc) {
									$druzynacs = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$skrimc["druzynapytana"]."' LIMIT 1"));
									$status = '<font color="red">Odrzucony</font>';
									if ($skrim["akceptowany"] == 1) {
										$status = '<font color="green">Akceptowany</font>';
									}
									echo '<tr>
									<td><center><a href="./?p=showteam&id='.$druzynacs["id"].'">'.$druzynacs["nazwa"].'</a></center></td>
									<td><center>'.$skrimc["data1"].'</center></td>
									<td><center>'.$skrimc["data2"].'</center></td>
									<td><center>'.$skrimc["data3"].'</center></td>
									<td><center>'.$status.'</center></td></tr>';
								}
							} else {
								echo '<tr><td colspan="5">Nie zaproponowałeś skrimów żadnej drużynie</td></tr>';
							}
						echo '</tbody>
					</table>
					</div>
				</div>
			</div>';
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
	} else {
		header("Refresh:0; url=?p=mainpage");
	}
?>	}
?>