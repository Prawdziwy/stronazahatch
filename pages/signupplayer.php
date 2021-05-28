<?PHP
	if(isset($_SESSION['access_token'])) {
		$query2 = $conn->query("SELECT * FROM `players` WHERE `userid`='".$_SESSION['userid']."'");
		if($query2 && $query2->num_rows > 0) {
			header("Refresh:0; url=?p=mainpage");
		} else {
			if(isset($_POST['selectDivision']) and isset($_POST['selectPosition']) and isset($_POST['selectPositionSecond']) and isset($_POST['eunenick']) and isset($_POST['username'])) { 
				if(Functions::isValidNameString($_POST['selectDivision']) && Functions::isValidNameString($_POST['selectPosition']) && Functions::isValidNameString($_POST['selectPositionSecond']) && 
				Functions::isValidNameString($_POST['eunenick']) && Functions::isValidNameString($_POST['username'])) {
					$query4 = $conn->query("SELECT * FROM `players` WHERE `nazwa`='".$_POST['username']."'");
					if($query4 && $query4->num_rows > 0) {
						echo 'Jest już gracz z taką nazwą.';
						header("Refresh:2; url=?p=mainpage");
						die;
					}
					$query = $conn->query("INSERT INTO `players` VALUES (NULL, '".$_POST['username']."', '".$_SESSION['userid']."', '".$_POST['selectDivision']."', '0', '".$_POST['eunenick']."', '".$_POST['selectPosition']."', '".$_POST['selectPositionSecond']."')");
				}
				header("Refresh:0; url=?p=mainpage");
			}
			echo '<br><style>.form-control {text-align: center;} .form-control-text {width: 300px;} select#selectDivision { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select#selectPosition { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select#selectPositionSecond { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select {display: flex; align-items: center; justify-content: flex-start;}</style><center><div class="container">
		<br><br><br><br><div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><center>Zapisz się jako gracz</center></h3>
			</div>
			<div class="panel-body">
				<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
	  <div class="form-group">
		<label for="nickname"><font size="3">Twój nick</font></label>
		<input class="form-control form-control-lg form-control-text" type="text" placeholder="Wpisz swój nick" name="username" value="'.$_SESSION['username'].'">
	  </div>
	  <div class="form-group">
		<label for="nickname"><font size="3">Twój nick na serwerze eune</font></label>
		<input class="form-control form-control-lg form-control-text" type="text" placeholder="Nick na serwerze eune" name="eunenick">
	  </div>
	  <div class="form-group">
		<label for="selectDivision"><font size="3">Dywizja</font></label><br>
		<select class="form-control form-control-lg selectdiv" id="selectDivision" name="selectDivision">';
		foreach(Functions::$divisions as $i => $value) {
			echo '<option value="'.$i.'">'.$value.'</option>';
		}
		echo '</select>
	  </div>
	  <div class="form-group">
		<label for="selectPosition"><font size="3">Podstawowa pozycja</font></label><br>
		<select class="form-control form-control-lg selectdiv" id="selectPosition" name="selectPosition">';
		foreach(Functions::$positionsvisible as $i => $value) {
			echo '<option value="'.$i.'">'.$value.'</option>';
		}
		echo '</select>
	  </div>
	  <div class="form-group">
		<label for="selectPositionSecond"><font size="3">Druga pozycja</font></label><br>
		<select class="form-control form-control-lg selectdiv" id="selectPositionSecond" name="selectPositionSecond">';
		foreach(Functions::$positionsvisible as $i => $value) {
			echo '<option value="'.$i.'">'.$value.'</option>';
		}
		echo '</select>
	  </div>
	  <center><button type="submit" class="btn btn-primary btn-lg">Zapisz się</button></center>
	</form>
			</div></div></div>';
		}
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
?>
