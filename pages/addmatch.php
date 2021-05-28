<?PHP
	if(isset($_SESSION['access_token'])) {
		$query4 = $conn->query("SELECT * FROM `admins` WHERE `userid`='".$_SESSION['userid']."'");
		if($query4 && $query4->num_rows > 0) {
			echo '<br><br><br><div class="container"><div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><center>Dodaj mecz</center></h3>
				</div>
				<div class="panel-body">';
					if (isset($_POST["druzyna1"]) and isset($_POST["druzyna2"]) and isset($_POST["date"])) {
						if ($_POST["druzyna1"] > 0 and $_POST["druzyna2"] > 0 and !empty($_POST["date"])) {
							if ($_POST["druzyna1"] != $_POST["druzyna2"]) {
								mysqli_query($conn, "INSERT INTO `matches` VALUES (NULL, '".$_POST["druzyna1"]."', '".$_POST["druzyna2"]."', '".$_POST["date"]."', 0, 0)");
								echo '<center>Gratulację, udało ci się dodać mecz.</center>';
								header("Refresh:1; url=?p=showmatches");
							} else {
								header("Refresh:3; url=?p=mainpage");
								die("Druzyna 1 nie może być tą samą drużyną co drużyna 2");
							}
						} else {
							header("Refresh:0; url=?p=mainpage");
						}
					} else {
					echo '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
						<div class="form-group">
							<label for="druzyna1">Drużyna 1</label>
							<select class="form-control" id="druzyna1" name="druzyna1">';
								$druzyny = mysqli_query($conn, "SELECT * FROM `teams` WHERE `potwierdzony`=1");
								foreach ($druzyny as $druzyna) {
									echo '<option value="'.$druzyna["id"].'">'.$druzyna["nazwa"].'</option>';
								}
							echo '</select>
						</div>
						<div class="form-group">
							<label for="druzyna2">Drużyna 2</label>
							<select class="form-control" id="druzyna2" name="druzyna2">';
								foreach ($druzyny as $druzyna) {
									echo '<option value="'.$druzyna["id"].'">'.$druzyna["nazwa"].'</option>';
								}
							echo '</select>
						</div>
						<div class="form-group">
							<label for="date">Data</label>
							<input class="form-control" type="datetime-local" id="date" name="date">
						</div>
						<center><button type="submit" class="btn btn-primary btn-lg">Dodaj</button></center>
						</form>
						';
					}
				echo '</div></div></div>';
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
	} else {
		header("Refresh:0; url=?p=mainpage");
	}
?>