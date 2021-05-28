<?PHP
	if(isset($_SESSION['access_token'])) {
		$actualname = "";
		$actualeune = "";
		$actualdivision = 1;
		$actualpposition = 1;
		$actualsposition = 1;
		$query5 = $conn->query("SELECT * FROM `players` WHERE `userid`='".$_SESSION['userid']."'");
		if($query5 && $query5->num_rows > 0) {
			$query5 = mysqli_fetch_array($query5);
			$actualname = $query5["nazwa"];
			$actualeune = $query5["nickeune"];
			$actualdivision = $query5["dywizja"];
			$actualpposition = $query5["pozycja"];
			$actualsposition = $query5["pozycjadruga"];
		}
		if(isset($_POST['selectDivision']) and isset($_POST['selectPosition']) and isset($_POST['selectPositionSecond']) and isset($_POST['eunenick']) and isset($_POST['username'])) { 
			if(Functions::isValidNameString($_POST['selectDivision']) && Functions::isValidNameString($_POST['eunenick']) && Functions::isValidNameString($_POST['username'])
				&& Functions::isValidNameString($_POST['selectPosition']) && Functions::isValidNameString($_POST['selectPositionSecond'])) {
				$query4 = mysqli_query($conn, "SELECT * FROM `players` WHERE `nazwa`='".$_POST['username']."'");
				if($_POST["username"] != $actualname) {
					if($query4 && $query4->num_rows > 0) {
						echo 'Jest już gracz z taką nazwą.';
						header("Refresh:2; url=?p=editprofile");
						die;
					}
					$query = $conn->query("UPDATE `players` SET `nazwa`='".$_POST['username']."' WHERE `userid`='".$_SESSION['userid']."'");
					$_SESSION["username"] = $_POST['username'];
				}
				if($_POST["eunenick"] != $actualeune) {
					$query = $conn->query("UPDATE `players` SET `nickeune`='".$_POST["eunenick"]."' WHERE `userid`='".$_SESSION['userid']."'");
				}
				if($_POST["selectDivision"] != $actualdivision) {
					$query = $conn->query("UPDATE `players` SET `dywizja`='".$_POST["selectDivision"]."' WHERE `userid`='".$_SESSION['userid']."'");
				}
				if($_POST["selectPosition"] != $actualpposition) {
					$query = $conn->query("UPDATE `players` SET `pozycja`='".$_POST["selectPosition"]."' WHERE `userid`='".$_SESSION['userid']."'");
				}
				if($_POST["selectPositionSecond"] != $actualsposition) {
					$query = $conn->query("UPDATE `players` SET `pozycjadruga`='".$_POST["selectPositionSecond"]."' WHERE `userid`='".$_SESSION['userid']."'");
				}
			}
			header("Refresh:0; url=?p=editprofile");
		}
		echo '<br><style>.form-control {text-align: center;} .form-control-text {width: 300px;} select#selectDivision { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select#selectPosition { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select#selectPositionSecond { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select {display: flex; align-items: center; justify-content: flex-start;}</style><center><div class="container">
		<br><br><br><br><div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><center>Edytuj dane gracza</center></h3>
			</div>
			<div class="panel-body">
				<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
	  <div class="form-group">
		<label for="nickname"><font size="3">Twój nick</font></label>
		<input class="form-control form-control-lg form-control-text" type="text" placeholder="Wpisz swój nick" name="username" value="'.$_SESSION['username'].'">
	  </div>
	  <div class="form-group">
		<label for="nickname"><font size="3">Twój nick na serwerze eune</font></label>
		<input class="form-control form-control-lg form-control-text" type="text" placeholder="Nick na serwerze eune" name="eunenick" value="'.$actualeune.'">
	  </div>
	  <div class="form-group">
		<label for="selectDivision"><font size="3">Dywizja</font></label><br>
		<select class="form-control form-control-lg selectdiv" id="selectDivision" name="selectDivision">';
		foreach(Functions::$divisions as $i => $value) {
			if($actualdivision == $i) {
				echo '<option value="'.$i.'" selected>'.$value.'</option>';
			} else {
				echo '<option value="'.$i.'">'.$value.'</option>';
			}
		}
		echo '</select>
	  </div>
	   <div class="form-group">
		<label for="selectPosition"><font size="3">Podstawowa pozycja</font></label><br>
		<select class="form-control form-control-lg selectdiv" id="selectPosition" name="selectPosition">';
		foreach(Functions::$positionsvisible as $i => $value) {
			if($actualpposition == $i) {
				echo '<option value="'.$i.'" selected>'.$value.'</option>';
			} else {
				echo '<option value="'.$i.'">'.$value.'</option>';
			}
		}
		echo '</select>
	  </div>
	   <div class="form-group">
		<label for="selectPositionSecond"><font size="3">Druga pozycja</font></label><br>
		<select class="form-control form-control-lg selectdiv" id="selectPositionSecond" name="selectPositionSecond">';
		foreach(Functions::$positionsvisible as $i => $value) {
			if($actualsposition == $i) {
				echo '<option value="'.$i.'" selected>'.$value.'</option>';
			} else {
				echo '<option value="'.$i.'">'.$value.'</option>';
			}
		}
		echo '</select>
	  </div>
	  <center><button type="submit" class="btn btn-primary btn-lg">Edytuj</button></center>
	</form>
			</div></div></div>';
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
?>