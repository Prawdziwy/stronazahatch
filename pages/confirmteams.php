<?PHP
	if(isset($_SESSION['access_token'])) {
		$query4 = $conn->query("SELECT * FROM `admins` WHERE `userid`='".$_SESSION['userid']."'");
		if($query4 && $query4->num_rows > 0) {
			if(Functions::isValidNameString($_POST['druzyna'])) {
				if(isset($_POST["druzyna"])) {
					$conn->query("UPDATE `teams` SET `potwierdzony`=1 WHERE `id`='".$_POST["druzyna"]."'");
					header("Refresh:0; url=?p=mainpage");
				}
			}
			echo '<br><style>.form-control {text-align: center;} .form-control-text {width: 300px;} select#invite { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select {display: flex; align-items: center; justify-content: flex-start;}</style><center><div class="container">
			<br><br><br><br><div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><center>Zatwierdź drużyny</center></h3>
				</div>
				<div class="panel-body">
			';
			$query7 = $conn->query("SELECT * FROM `teams` WHERE `potwierdzony`=0 AND `gotowy`=1");
			if($query7 && $query7->num_rows > 0) {
				echo '<div class="row">';
				while ($team = mysqli_fetch_array($query7)) {
					$druzynapower = 0;
					$query2 = mysqli_fetch_array($query2);
					foreach(Functions::$positions as $i => $value) {
						$query3 = mysqli_fetch_array($conn->query("SELECT * FROM `rosters` WHERE `druzyna`='".$team["id"]."' LIMIT 1"));
						if($query3[strtolower($value)] > 0) {
							$query5 = mysqli_fetch_array($conn->query("SELECT * FROM `players` WHERE `userid`='".$query3[strtolower($value)]."' LIMIT 1"));
							$druzynapower += Functions::idToDivisionPower($query5["dywizja"]);
						}
					}
					echo '<div class="col-sm-4">
								<form method="post" action="'.$_SERVER['REQUEST_URI'].'"><div class="card" style="width: 18rem; margin-top: 15px;">
									<div class="card-body">
										<h5 class="card-title">'.$team["nazwa"].'</h5>
										<p class="card-text">Poziom drużyny: '.$druzynapower.'<br><a href="./?p=showteam&id='.$team["id"].'">Zobacz drużyne</a></p>
										<input type="hidden" name="druzyna" value="'.$team["id"].'"/>
										<button type="submit" class="btn btn-primary btn-lg">Zatwierdź</button>
									</div>
								</div>
							</form></div>';
				}
				echo '</div>';
			} else {
				echo 'Nie ma żadnych drużyn do zatwierdzenia.';
			}
		  echo '
		  <center>
				</div></div></div>';
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
?>