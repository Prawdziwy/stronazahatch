<?PHP
	if(isset($_SESSION['access_token'])) {
		if(isset($_POST['invite'])) {
			if(Functions::isValidNameString($_POST['invite'])) {
				$query6 = $conn->query("SELECT * FROM `players` WHERE `userid`='".$_SESSION['userid']."'");
				if($query6 && $query6->num_rows > 0) {
					$query6 = mysqli_fetch_array($query6);
					if($query6["druzyna"] == 0) {
						$query4 = $conn->query("SELECT * FROM `invites` WHERE `id`='".$_POST['invite']."'");
						if($query4 && $query4->num_rows > 0) {
							$query4 = mysqli_fetch_array($query4);
							if($query4["userid"] == $_SESSION['userid']) {
								$conn->query("DELETE FROM `invites` WHERE `id`='".$_POST['invite']."'");
								$conn->query("UPDATE `players` SET `druzyna`='".$query4["druzyna"]."' WHERE `userid`='".$_SESSION['userid']."'");
								
								$query9 = $conn->query("SELECT * FROM `invites` WHERE `userid`='".$_SESSION['userid']."'");
								while ($invite = mysqli_fetch_array($query9)) {
									$conn->query("DELETE FROM `invites` WHERE `id`='".$invite["id"]."'");
								}
								foreach(Functions::$positions as $i => $value) {
									$conn->query("UPDATE `rosters` SET `".$value."`=NULL WHERE `userid`='".$_SESSION['userid']."' AND `druzyna`!='".$query4["druzyna"]."'");
								}
							}
						}
					}
				}
			}
			header("Refresh:0; url=?p=yourinvites");
		}
		echo '<br><style>.form-control {text-align: center;} .form-control-text {width: 300px;} select#invite { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select {display: flex; align-items: center; justify-content: flex-start;}</style><center><div class="container">
		<br><br><br><br><div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><center>Edytuj dane gracza</center></h3>
			</div>
			<div class="panel-body">
				<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
	  <div class="form-group">';
		$query7 = $conn->query("SELECT * FROM `invites` WHERE `userid`='".$_SESSION['userid']."'");
		if($query7 && $query7->num_rows > 0) {
			echo '<label for="invite"><font size="3">Wybierz drużyne</font></label><br><select class="form-control form-control-lg selectdiv" id="invite" name="invite">';
			while ($invite = mysqli_fetch_array($query7)) {
				$query8 = $conn->query("SELECT * FROM `teams` WHERE `id`='".$invite["druzyna"]."'");
				if($query8 && $query8->num_rows > 0) {
					$query8 = mysqli_fetch_array($query8);
					echo '<option value="'.$invite["id"].'">'.$query8["nazwa"].'</option>';
				}
			}
			echo '</select><center><button type="submit" class="btn btn-primary btn-lg">Dołącz</button></center>';
		} else {
			echo 'Nie masz żadnych zaproszeń do drużyny.';
		}
	  echo '</div>
	</form>
			</div></div></div>';
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
?>