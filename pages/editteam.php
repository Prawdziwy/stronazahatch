<?PHP
	if(isset($_SESSION['access_token'])) {
		$actualname = "";
		$iddruzyna = 0;
		$readyteam = 0;
		$confirmedteam = 0;
		$invites = 0;
		$query5 = $conn->query("SELECT * FROM `players` WHERE `userid`='".$_SESSION['userid']."'");
		if($query5 && $query5->num_rows > 0) {
			$query5 = mysqli_fetch_array($query5);
			$query6 = $conn->query("SELECT * FROM `teams` WHERE `id`='".$query5["druzyna"]."'");
			if($query6 && $query6->num_rows > 0) {
				$query6 = mysqli_fetch_array($query6);
				$actualname = $query6["nazwa"];
				$iddruzyna = $query6["id"];
				$readyteam = $query6["gotowy"];
				$confirmedteam = $query6["potwierdzony"];
			} else {
				header("Refresh:0; url=?p=mainpage");
			}
		}
		$query10 = $conn->query("SELECT * FROM `invites` WHERE `druzyna`='".$iddruzyna."'");
		foreach($query10 as $invite10) {
			$invites += 1;
		}
		if(isset($_POST['teamname'])) { 
			if(Functions::isValidNameString($_POST['teamname'])) {
				$query4 = $conn->query("SELECT * FROM `teams` WHERE `nazwa`='".$_POST['teamname']."'");
				if($_POST["teamname"] != $actualname) {
					if($query4 && $query4->num_rows > 0) {
						echo 'Jest już drużyna z taką nazwą.';
						header("Refresh:2; url=?p=editteam");
						die;
					}
					$query = $conn->query("UPDATE `teams` SET `nazwa`='".$_POST['teamname']."' WHERE `id`='".$iddruzyna."'");
				}
			}
			header("Refresh:0; url=?p=editteam");
		}
		if(isset($_POST['invitedname'])) { 
			if(Functions::isValidNameString($_POST['invitedname'])) {
				$query4 = $conn->query("SELECT * FROM `players` WHERE `nazwa`='".$_POST['invitedname']."'");
				if($query4 && $query4->num_rows > 0) {
					$query4 = mysqli_fetch_array($query4);
					$query7 = $conn->query("SELECT * FROM `invites` WHERE `userid`='".$query4["userid"]."'");
					if($query7 && $query7->num_rows > 0) {
						echo $query4["nazwa"].' został już zaproszony.';
						header("Refresh:2; url=?p=editteam");
						die;
					}
					if($query4["druzyna"] > 0) {
						echo $query4["nazwa"].' ma już swoją drużyne.';
						header("Refresh:2; url=?p=editteam");
						die;
					}
					$query = $conn->query("INSERT INTO `invites` VALUES (NULL, '".$query4["userid"]."', '".$iddruzyna."')");
				}
			}
			header("Refresh:0; url=?p=editteam");
		}
		if(isset($_POST['deleteinvite'])) { 
			if(Functions::isValidNameString($_POST['deleteinvite'])) {
				$query24 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `invites` WHERE `id`='".$_POST['deleteinvite']."'"));
				if ($query24["druzyna"] == $iddruzyna) {
					mysqli_query($conn, "DELETE FROM `invites` WHERE `id`='".$_POST['deleteinvite']."'");
				}
			}
			header("Refresh:0; url=?p=editteam");
		}
		if(isset($_POST["ready"])) {
			if ($_POST["ready"] == 1) {
				mysqli_query($conn, "UPDATE `teams` SET `gotowy`=1 WHERE `id`='".$iddruzyna."'");
			}
		}
		foreach(Functions::$positions as $i => $value) {
			if(isset($_POST[$value])) { 
				if(Functions::isValidNameString($_POST[$value])) {
					$query4 = $conn->query("SELECT * FROM `players` WHERE `userid`='".$_POST[$value]."' AND `druzyna`='".$iddruzyna."'");
					if($query4 && $query4->num_rows > 0) {
						$query4 = mysqli_fetch_array($query4);
						$query = $conn->query("UPDATE `rosters` SET `".$value."`='".$query4["userid"]."' WHERE `druzyna`='".$iddruzyna."'");
					}
				}
			}
		}
echo '<br><style>.form-control {text-align: center;} .form-control-text {width: 300px;} select#selectDivision { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select {display: flex; align-items: center; justify-content: flex-start;}</style><center><div class="container">
<br><br><br><br><div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><center>Edytuj dane drużyny</center></h3>
	</div>
	<div class="panel-body">
		<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
			<center>Status drużyny: ';
			if ($confirmedteam == 0) {
				if ($readyteam == 0) {
					echo '<b><font color="red">Brak gotowości</font></b><br>
					<input type="hidden" name="ready" id="ready" value="1"/>
					<center><button type="submit" class="btn btn-primary btn-lg">Zgłoś gotowość</button></center>';
				} else {
					echo '<b><font color="orange">Drużyna gotowa</font></b>';
				}
			} else {
				echo '<b><font color="green">Drużyna potwierdzona</font></b>';
			}
			echo '</center>
		</form><br>
		<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
			<div class="form-group">
				<label for="nickname"><font size="3">Nazwa drużyny</font></label>
				<input class="form-control form-control-lg form-control-text" type="text" placeholder="Wpisz nową nazwę" name="teamname" value="'.$_SESSION['teamname'].'">
			</div>
			<center><button type="submit" class="btn btn-primary btn-lg">Edytuj</button></center>
		</form><br>
		<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
			<div class="form-group">
				<label for="nickname"><font size="3">Zaproś gracza</font></label>
				<input class="form-control form-control-lg form-control-text" type="text" placeholder="Nazwa gracza" name="invitedname" value="'.$_SESSION['invitedname'].'">
			</div>
			<center><button type="submit" class="btn btn-primary btn-lg">Zaproś</button></center>
		</form><br>
		<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
			<font size="5">Wybierz pozycję</font>';
			foreach(Functions::$positions as $i => $value) {
				echo '<div class="form-group">
				<label for="'.$value.'"><font size="3">'.$value.'</font></label>
				<select name="'.$value.'">';
					$query12 = $conn->query("SELECT * FROM `players` WHERE `druzyna`='".$iddruzyna."'");
					$k=0;
					foreach($query12 as $gracz) {
						$k++;
						$query13 = mysqli_fetch_array($conn->query("SELECT * FROM `rosters` WHERE `druzyna`='".$iddruzyna."'"));
						$selected = "";
						if($query13[$value] == $gracz["userid"]) {
							$selected = "selected";
						}
						echo '<option value="'.$gracz["userid"].'" '.$selected.'>'.$gracz["nazwa"].'</option>';
					}
				echo '</select></div>';
			}
			echo '<center><button type="submit" class="btn btn-primary btn-lg">Zapisz</button></center>
		</form>';
		if($invites > 0) {
		echo '<br><br><center> Osoby Zaproszone<br><table class="table table-striped">
		<thead>
			<tr>
				<th scope="col"><center>#</center></th>
				<th scope="col"><center>Nazwa</center></th>
				<th scope="col"><center>Usuń</center></th>
			</tr>
		</thead>
		<tbody><tr>';
			$query8 = $conn->query("SELECT * FROM `invites` WHERE `druzyna`='".$iddruzyna."'");
			$i=0;
			foreach($query8 as $invite) {
				$i++;
				$query9 = mysqli_fetch_array($conn->query("SELECT * FROM `players` WHERE `userid`='".$invite["userid"]."'"));
				echo '<th scope="row"><center>'.$i.'</center></th><td><center>'.$query9["nazwa"].'</center></td><td><form method="post" action="'.$_SERVER['REQUEST_URI'].'">
							<input type="hidden" name="deleteinvite" id="deleteinvite" value="'.$invite["id"].'"/>
							<center><button type="submit" class="btn btn-danger btn-lg">Usuń</button></center>
						</form></td>';
			}
		echo '</tr></tbody>
		</table>';
		}
			echo '</div></div></div>';
			
		} else {
			header("Refresh:0; url=?p=mainpage");
		}
?>