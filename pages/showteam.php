<style>
svg{width:30%;}
</style>
<script>
var count = $(('#count'));
$({ Counter: 0 }).animate({ Counter: count.text() }, {
  duration: 5000,
  easing: 'linear',
  step: function () {
    count.text(Math.ceil(this.Counter)+ "%");
  }
});

var s = Snap('#animated');
var progress = s.select('#progress');

progress.attr({strokeDasharray: '0, 251.2'});
Snap.animate(0,251.2, function( value ) {
    progress.attr({ 'stroke-dasharray':value+',251.2'});
}, 5000);
</script>
<?PHP
	$colorcircle = '3cff00';
	$iddruzyna = intval($_GET["id"]);
	$druzynapower = 0;
	$query2 = mysqli_query($conn, "SELECT * FROM `teams` WHERE `id`='".$iddruzyna."' LIMIT 1");
	if($query2 && $query2->num_rows > 0) {
		$query2 = mysqli_fetch_array($query2);
		$isinteam = 0;
		$leavinguserid = 0;
		if(isset($_SESSION['access_token'])) {
			$query4 = mysqli_query($conn, "SELECT * FROM `players` WHERE `userid`='".$_SESSION['userid']."'");
			if($query4 && $query4->num_rows > 0) {
				$query4 = mysqli_fetch_array($query4);
				if ($query4["druzyna"] == $query2["id"]) {
					$isinteam = 1;
				}
				if($_POST["leave"] == 1 and $isinteam == 1) {
					if ($query4["userid"] == $query2["lider"]) {
						mysqli_query($conn, "UPDATE `players` SET `druzyna`=0 WHERE `druzyna`='".$iddruzyna."'");
						mysqli_query($conn, "DELETE FROM `teams` WHERE `id`='".$iddruzyna."'");
						mysqli_query($conn, "DELETE FROM `rosters` WHERE `druzyna`='".$iddruzyna."'");
					} else {
						mysqli_query($conn, "UPDATE `players` SET `druzyna`=0 WHERE `id`='".$query4["id"]."'");
						$leavinguserid = $query4["userid"];
					}
				}
			}
		}
		foreach(Functions::$positions as $i => $value) {
			$query3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `rosters` WHERE `druzyna`='".$iddruzyna."' LIMIT 1"));
			if($query3[strtolower($value)] > 0) {
				$query4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `players` WHERE `userid`='".$query3[strtolower($value)]."' LIMIT 1"));
				if ($query3[strtolower($value)] == $leavinguserid) {
					$query4 = mysqli_fetch_array(mysqli_query($conn, "UPDATE `rosters` SET `".strtolower($value)."`=NULL WHERE `druzyna`='".$iddruzyna."'"));
				}
				$druzynapower += Functions::idToDivisionPower($query4["dywizja"]);
			}
		}
		
		echo '<br><style>.form-control {text-align: center;} .form-control-text {width: 300px;} select#selectDivision { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select {display: flex; align-items: center; justify-content: flex-start;}</style><div class="container">
			<br><br><br><br><div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><center>Drużyna '.$query2["nazwa"].'</center></h3>
				</div>
				<div class="panel-body">
					<style>
						.minimap {
							margin-left: auto;
							margin-right: auto;
							width: 600px;
							height: 590px;
							background-image: url("./images/minimap.jpg");
							color: white;
							font-size: 20px;
							font-family: Trebuchet MS;
						}
						.Top {
							margin-left: auto;
							margin-right: auto;
							width: 50%;
							padding-top: 40px;
						}
						.Jungle {
							margin-left: auto;
							margin-right: auto;
							width: 20%;
							padding-top: 85px;
						}
						.Mid {
							margin-left: auto;
							margin-right: auto;
							width: 5%;
							padding-top: 80px;
						}
						.ADCarry {
							margin-left: auto;
							margin-right: auto;
							text-align: right;
						    width: 95%;
							padding-top: 60px;
						}
						.Support {
							position: sticky;
							margin-left: auto;
							margin-right: auto;
							text-align: right;
						    width: 95%;
							padding-top: 30px;
						}
					</style>
					<div class="minimap">';
					foreach(Functions::$positions as $i => $value) {
						$query3 = mysqli_fetch_array($conn->query("SELECT * FROM `rosters` WHERE `druzyna`='".$iddruzyna."' LIMIT 1"));
						if($query3[strtolower($value)] > 0) {
							$query4 = mysqli_fetch_array($conn->query("SELECT * FROM `players` WHERE `userid`='".$query3[strtolower($value)]."' LIMIT 1"));
							echo '<div class="'.$value.'">'.$query4["nazwa"].'</div>';
						} else {
							echo '<div class="'.$value.'">????</div>';
						}
					}
					if($druzynapower > Functions::$maxteampower) {
						$colorcircle = "ff5900";
					}
					echo '</div><center><font size="6">Poziom drużyny</font><br>
					<svg id="svg" viewbox="0 0 100 100">
					  <circle cx="50" cy="50" r="45" fill="#'.$colorcircle.'"/>
					  <path fill="none" stroke-linecap="round" stroke-width="5" stroke="#fff"
							stroke-dasharray="'.($druzynapower*10).', 250"
							d="M50 10
							   a 40 40 0 0 1 0 80
							   a 40 40 0 0 1 0 -80"/>
					  <text x="50" y="50" text-anchor="middle" dy="7" font-size="20">'.$druzynapower.'</text>
					</svg>
					<br>
					Rozstawienie:</center><br>
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col">Pozycja</th>
								<th scope="col">Nazwa</th>
							</tr>
						</thead>
						<tbody>
							';
							foreach(Functions::$positions as $i => $value) {
								$query3 = mysqli_fetch_array($conn->query("SELECT * FROM `rosters` WHERE `druzyna`='".$iddruzyna."' LIMIT 1"));
								echo '<tr>';
								if($query3[strtolower($value)] > 0) {
									$query4 = mysqli_fetch_array($conn->query("SELECT * FROM `players` WHERE `userid`='".$query3[strtolower($value)]."' LIMIT 1"));
									echo '<td>'.$value.'</td><td><a href="./?p=playercard&id='.$query4["id"].'">'.$query4["nazwa"].'</a></td>';
								} else {
									echo '<td>'.$value.'</td><td>????</td>';
								}
								echo '</tr>';
							}
							echo '
						</tbody>
					</table>';
					if ($isinteam == 1) {
						echo '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
							<input type="hidden" name="leave" id="leave" value="1"/>
							<center><button type="submit" class="btn btn-danger btn-lg">Opuść drużynę</button></center>
						</form>';
					}
				echo '</div></div></div>';
	} else {
		header("Refresh:0; url=?p=mainpage");
	}
?>