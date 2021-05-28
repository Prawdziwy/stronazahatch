<?PHP
	if(isset($_SESSION['access_token'])) {
		$query5 = mysqli_query($conn, "SELECT * FROM `teams` WHERE `lider`='".$_SESSION['userid']."' AND `potwierdzony`=1");
		if ($query5 && $query5->num_rows > 0) {
			$query5 = mysqli_fetch_array($query5);

			$query4 = $conn->query("SELECT * FROM `scrims` WHERE `druzyna`='".$query5["id"]."'");
			if($query4 && $query4->num_rows > 0) {
				header("Refresh:0; url=?p=mainpage");
				die();
			}

			if(isset($_POST["godzina1"]) and isset($_POST["godzina2"]) and isset($_POST["day1"]) and isset($_POST["day2"])) {
				if ( ($_POST["godzina1"] >= 0 and $_POST["godzina1"] <= 24) and ($_POST["godzina2"] >= 0 and $_POST["godzina2"] <= 24) and ($_POST["day1"] >= 1 and $_POST["day1"] <= 7) and ($_POST["day2"] >= 1 and $_POST["day2"] <= 7) ) {
					mysqli_query($conn, "INSERT INTO `scrims` VALUES (NULL, '".$query5["id"]."', '".$_POST["godzina1"]."', '".$_POST["godzina2"]."', '".$_POST["day1"]."', '".$_POST["day2"]."')");
					header("Refresh:1; url=?p=planscrims");
				} else {
					header("Refresh:0; url=?p=mainpage");
				}
			}
			echo '<br><br><br>
			<style>
			.form-number {
				display: inline-block;
				width: 75px;
			}
			.form-day {
				display: inline-block;
				width: 200px;
			}
			</style>
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><center>Skrimy</center></h3>
					</div>
					<div class="panel-body">
						<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
							<div class="form-group">
								<center>
									<label>Zakres godzin</label><br>
									<input type="number" class="form-control form-number" id="godzina1" name="godzina1" min="0" max="24" value="14">
									-
									<input type="number" class="form-control form-number" id="godzina2" name="godzina2" min="0" max="24" value="18">
								</center>
							</div>
							<div class="form-group">
								<center>
									<label>Zakres dni</label><br>
									<select class="form-control form-day" id="day1" name="day1">';
										foreach(Functions::$days as $i => $value) {
											echo '
											<option value="'.$i.'">'.$value.'</option>
											';
										}
									echo '</select>
									-
									<select class="form-control form-day" id="day2" name="day2">';
										foreach(Functions::$days as $i => $value) {
											echo '
											<option value="'.$i.'">'.$value.'</option>
											';
										}
									echo '</select>
								</center>
							</div>
							<center>
								<button type="submit" class="btn btn-primary btn-lg">Wyślij</button>
							</center>
						</form>
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