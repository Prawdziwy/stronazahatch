<?PHP
	if(isset($_SESSION['access_token'])) {
		$query2 = $conn->query("SELECT * FROM `players` WHERE `userid`='".$_SESSION['userid']."'");
		if($query2 && $query2->num_rows > 0) {
			$query2 = mysqli_fetch_array($query2);
			if($query2["druzyna"] == 0) {
				if(isset($_POST['teamname'])) {
					if(Functions::isValidNameString($_POST['teamname'])) {
						$query4 = $conn->query("SELECT * FROM `teams` WHERE `nazwa`='".$_POST['teamname']."'");
						if($query4 && $query4->num_rows > 0) {
							echo 'Jest już drużyna z taką nazwą.';
							header("Refresh:2; url=?p=mainpage");
							die;
						}
						$query = $conn->query("INSERT INTO `teams` VALUES (NULL, '".$_SESSION['userid']."', '".$_POST['teamname']."', '0', '0')");
						$query3 = $conn->query("SELECT * FROM `teams` WHERE `lider`='".$_SESSION['userid']."'");
						if($query3 && $query3->num_rows > 0) {
							$query3 = mysqli_fetch_array($query3);
							$query7 = $conn->query("UPDATE `players` SET `druzyna`=".$query3['id']." WHERE `userid`='".$_SESSION['userid']."'");
							$query6 = $conn->query("INSERT INTO `rosters` VALUES (NULL, '".$query3['id']."', NULL, NULL, NULL, NULL, NULL)");
							
							$query9 = $conn->query("SELECT * FROM `invites` WHERE `userid`='".$_SESSION['userid']."'");
							while ($invite = mysqli_fetch_array($query9)) {
								$conn->query("DELETE FROM `invites` WHERE `id`='".$invite["id"]."'");
							}
							foreach(Functions::$positions as $i => $value) {
								$conn->query("UPDATE `rosters` SET `".$value."`=NULL WHERE `userid`='".$_SESSION['userid']."' AND `druzyna`!='".$query3['id']."'");
							}
						}
					}
					header("Refresh:0; url=?p=mainpage");
				}
				echo '<br><style>.form-control {text-align: center;} .form-control-text {width: 300px;}</style><center><div class="container">
				<br><br><br><br><div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><center>Zapisz swoją drużynę</center></h3>
				</div>
				<div class="panel-body">
					<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
			  <div class="form-group">
				<label for="nickname"><font size="3">Nazwa drużyny</font></label>
				<input class="form-control form-control-lg form-control-text" type="text" placeholder="Wpisz nazwę drużyny" name="teamname">
			  </div>
			  <center><button type="submit" class="btn btn-primary btn-lg">Zapisz</button></center>
			</form>
				</div></div></div>';
			} else {
				header("Refresh:0; url=?p=mainpage");
			}
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
	} else {
		header("Refresh:0; url=?p=mainpage");
	}
?>