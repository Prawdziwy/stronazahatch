<?PHP
	if(isset($_SESSION['access_token'])) {
		$query5 = mysqli_query($conn, "SELECT * FROM `teams` WHERE `lider`='".$_SESSION['userid']."' AND `potwierdzony`=1");
		if (isset($_GET["id"]) && ($query5 && $query5->num_rows > 0) or ($_SESSION['userid'] == "326356340630880256")) {
			$query5 = mysqli_fetch_array($query5);

			$query4 = mysqli_query($conn, "SELECT * FROM `scrimsasks` WHERE `druzyna`='".$query5["id"]."' AND `skrim`='".$_GET["id"]."'");
			if($query4 && $query4->num_rows > 0) {
				header("Refresh:0; url=?p=mainpage");
			}
			
			$query3 = mysqli_query($conn, "SELECT * FROM `scrims` WHERE `skrim`='".$_GET["id"]."'");
			if($query3 && $query3->num_rows <= 0) {
				header("Refresh:0; url=?p=mainpage");
			}

			if(isset($_POST["date1"]) and isset($_POST["date2"]) and isset($_POST["date3"])) {
				if (!empty($_POST["date1"]) and !empty($_POST["date2"]) and !empty($_POST["date3"])) {
					mysqli_query($conn, "INSERT INTO `scrimsasks` VALUES (NULL, '".$_GET["id"]."', '".$query5["id"]."', '".$_POST["date1"]."', '".$_POST["date2"]."', '".$_POST["date3"]."', 0)");
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
			.form-select {
				width: 200px;
			}
			.form-data {
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
									<label>Daty ktore ci odpowiadaja(zaznacz 3)</label><br>
									<input class="form-control form-data" type="datetime-local" id="date1" name="date1"><br>
									<input class="form-control form-data" type="datetime-local" id="date2" name="date2"><br>
									<input class="form-control form-data" type="datetime-local" id="date3" name="date3">
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