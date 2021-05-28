<?PHP
if(isset($_SESSION['access_token'])) {
	if (isset($_GET["id"]) and is_numeric($_GET["id"])) {
		$mecz = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `matches` WHERE `id`='".$_GET["id"]."' LIMIT 1"));
		if ($mecz) {
			if ($mecz["wygrany"] == 0) {
				header("Refresh:3; url=?p=mainpage");
				die("Ten mecz jeszcze się nie odbył!");
			}
			$druzyna1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$mecz["druzyna1"]."' LIMIT 1"));
			$druzyna2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$mecz["druzyna2"]."' LIMIT 1"));
			echo '<br><br><br>
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><center>Głosuj na MVP meczu <b>'.$druzyna1["nazwa"].'</b> VS <b>'.$druzyna2["nazwa"].'</b></center></h3>
					</div>
					<div class="panel-body">';
					$votesmvp = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `votemvp` WHERE `mecz`='".$mecz["id"]."' LIMIT 1"));
					$overallvotes = 0;
					if ($votesmvp) {
						foreach(Functions::$positions as $v => $value) {
							$overallvotes += $votesmvp[strtolower($value)];
						}
					} else {
						mysqli_query($conn, "INSERT INTO `votemvp` VALUES ('".$mecz["id"]."', '0', '0', '0', '0', '0')");
					}
					if (isset($_POST["vote"]) and $_POST["vote"] == 1) {
						echo '<form method="post" action="'.$_SERVER['REQUEST_URI'].'"><select class="form-control" id="vote" name="vote">';
						foreach(Functions::$positions as $j => $value) {
							$userid = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `rosters` WHERE `druzyna`='".$mecz["wygrany"]."' LIMIT 1"));
							if ($userid) {
								$username = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `players` WHERE `userid` = '".$userid[strtolower($value)]."'"));
								if ($username) {
									echo '
										<option value="'.($j+1).'">'.$username["nazwa"].'</option>
									';
								}
							}
						}
						echo '
						</select><br>
						<center><button type="submit" class="btn btn-primary btn-lg">Zagłosuj</button></center>
						</form>';
					} elseif (isset($_POST["vote"]) and $_POST["vote"] > 1) {
						$userid = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `players` WHERE `userid` = '".$_SESSION["userid"]."'"));
						if ($userid) {
							$votes = mysqli_query($conn, "SELECT * FROM `votes` WHERE `userid`='".$userid['id']."' AND `mecz`='".$mecz["id"]."'");
							if (!$votes or mysqli_num_rows($votes) <= 0) {
								mysqli_query($conn, "INSERT INTO `votes` VALUES (NULL, '".$userid["id"]."', '".$mecz["id"]."')");
								$pos = Functions::idToPosition($_POST["vote"]-1);
								mysqli_query($conn, "UPDATE `votemvp` SET `".$pos."`=`".$pos."`+1 WHERE `mecz`=".$mecz["id"]."");
								echo '<center>Gratulacje, zagłosowałeś na zawodnika który twoim zdaniem jest graczem meczu!</center>'; 
								header("Refresh:3; url=?p=votemvp&id=".$mecz["id"]);
							} else {
								echo '<center>Zagłosowałeś już w tym meczu na swojego MVP!</center>';
								header("Refresh:3; url=?p=votemvp&id=".$mecz["id"]);
							}
						}
					} else {
						echo '<center><b>Łączna ilość głosów: '.$overallvotes.'</b></center>';
						foreach(Functions::$positions as $j => $value) {
							$userid = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `rosters` WHERE `druzyna`='".$mecz["wygrany"]."' LIMIT 1"));
							
							if ($userid) {
								$username = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `players` WHERE `userid` = '".$userid[strtolower($value)]."'"));
								if ($username) {
									$votesofthisplayer = 0;
									$votesofthisplayer += $votesmvp[strtolower($value)];
									$width = round((($votesofthisplayer * 100) / $overallvotes));
									if ($votesofthisplayer == 0) {
										$width = 0;
									}
									echo '
									<div class="progress" style="margin-top: 10px; height: 30px;">
										<div class="progress-bar bg-info" role="progressbar" style="width: '.$width.'%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><b><font color="black">'.$username["nazwa"].'</font></b></div>
									</div>
									';
								}
							}
						}
					echo '<br>
					<center><form method="post" action="'.$_SERVER['REQUEST_URI'].'"><input type="hidden" name="vote" id="vote" value="1"/><button type="submit" class="btn btn-primary btn-lg">Głosuj</button></form></center>
					';
					}
					echo '</div>
				</div>';
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
	} else {
		header("Refresh:0; url=?p=mainpage");
	}
} else {
	header("Refresh:3; url=?p=mainpage");
	die("Musisz być zalogowany!");
}
?>