<?PHP
	if(isset($_GET["id"]) and isset($_SESSION['access_token'])) {
		$query5 = $conn->query("SELECT * FROM `admins` WHERE `userid`='".$_SESSION['userid']."'");
		if($query5 && $query5->num_rows > 0) {

			$mecz = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `matches` WHERE `id`='".$_GET["id"]."' LIMIT 1"));
			$druzyna1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id`='".$mecz["druzyna1"]."' LIMIT 1"));
			$druzyna2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id`='".$mecz["druzyna2"]."' LIMIT 1"));
			
			if( ( isset($_POST["druzyna1"]) and isset($_POST["druzyna2"]) and isset($_POST['date']) ) or isset($_POST["wygrany"]) ) { 
				if ( ($_POST["druzyna1"] != $_POST["druzyna2"]) ) {
					mysqli_query($conn, "UPDATE `matches` SET `druzyna1`='".$_POST["druzyna1"]."' WHERE `id` = '".$mecz["id"]."' ");
					mysqli_query($conn, "UPDATE `matches` SET `druzyna2`='".$_POST["druzyna2"]."' WHERE `id` = '".$mecz["id"]."' ");
				}
				if (!empty($_POST["date"])) {
					mysqli_query($conn, "UPDATE `matches` SET `data`='".$_POST["date"]."' WHERE `id`='".$mecz["id"]."'");
				}
				if ($_POST["wygrany"] != 0) {
					mysqli_query($conn, "UPDATE `matches` SET `wygrany`='".$_POST["wygrany"]."' WHERE `id`='".$mecz["id"]."'");
				}
				header("Refresh:0; url=?p=showmatches");
			}
			
			echo '<br>
			<style>
			.form-data {
				width: 200px;
			}
			.form-select {
				width: 200px;
			}
			</style>
			<center><div class="container">
			<br><br><br><br><div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><center>Edytuj mecz '.$druzyna1["nazwa"].' VS '.$druzyna2["nazwa"].'</center></h3>
				</div>
				<div class="panel-body">
					<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
					  <div class="form-group">
						<label for="data"><font size="3">Zmień drużyne 1</font></label>
						<select class="form-control form-select" id="druzyna1" name="druzyna1">';
							$druzyny = mysqli_query($conn, "SELECT * FROM `teams` WHERE `potwierdzony`=1");
							if ($druzyny and $druzyny->num_rows > 0) {
								foreach ($druzyny as $druzyna) {
									$selected = "";
									if ($druzyna["id"] == $mecz["druzyna1"]) {
										$selected = "selected";
									}
									echo '<option value="'.$druzyna["id"].'" '.$selected.'>'.$druzyna["nazwa"].'</option>';
								}
							} else {
								echo '<option value="0">Nie ma żadnych drużyn</option>';
							}
						echo '</select>
					  </div>
					  <div class="form-group">
						<label for="data"><font size="3">Zmień drużyne 2</font></label>
						<select class="form-control form-select" id="druzyna2" name="druzyna2">';
							$druzyny = mysqli_query($conn, "SELECT * FROM `teams` WHERE `potwierdzony`=1");
							if ($druzyny and $druzyny->num_rows > 0) {
								foreach ($druzyny as $druzyna) {
									$selected = "";
									if ($druzyna["id"] == $mecz["druzyna2"]) {
										$selected = "selected";
									}
									echo '<option value="'.$druzyna["id"].'" '.$selected.'>'.$druzyna["nazwa"].'</option>';
								}
							} else {
								echo '<option value="0">Nie ma żadnych drużyn</option>';
							}
						echo '</select>
					  </div>
					  <div class="form-group">
						<label for="data"><font size="3">Zmień datę</font></label>
						<input class="form-control form-data" type="datetime-local" id="date" name="date">
					  </div>
					  <div class="form-group">
						<label for="data"><font size="3">Ustal wygranego</font></label>
						<select class="form-control form-select" id="wygrany" name="wygrany">
							<option value="0">Nie ustalaj</option>
							<option value="'.$druzyna1["id"].'">'.$druzyna1["nazwa"].'</option>
							<option value="'.$druzyna2["id"].'">'.$druzyna2["nazwa"].'</option>
						</select>
					  </div>
					  <center><button type="submit" class="btn btn-primary btn-lg">Edytuj</button></center>
					</form>
				</div></div></div>';
		} else {
			header("Refresh:0; url=?p=showmatches");
		}
	} else {
		header("Refresh:0; url=?p=showmatches");
	}
?>