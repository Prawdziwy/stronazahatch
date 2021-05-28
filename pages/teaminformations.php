<?PHP
		echo '<br><style>.form-control {text-align: center;} .form-control-text {width: 300px;} select#invite { text-align: center; display: inline-block; width: auto; vertical-align: middle; } select {display: flex; align-items: center; justify-content: flex-start;}</style><center><div class="container">
		<br><br><br><br><div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><center>Podstawowe informacje na temat drużyn</center></h3>
			</div>
			<div class="panel-body">
			Każda drużyna musi wystawić 5 graczy do swojej formacji, następnie zostać potwierdzona przez jednego z administratorów, żadna z drużyn nie może przekroczyć mocy <b>'.Functions::$maxteampower.'</b>, w przeciwnym wypadku nie zostanie potwierdzona. Każda zmiana w twoim składzie spowoduje że status jej potwierdzonej się cofa, więc uważaj na to!<br/><br/>
			Przy każdym graczu widnieje informacja na temat drużyny, brak drużyny oznacza że nie dołączył jeszcze do żadnej, brak potwierdzonej oznacza że dołączył ale jeszcze nie została ona potwierdzona. Potwierdzona oznacza że znalazł już on swoją formację w której będzie grał.</br></br>
			Moc jest obliczana bacząc na rangę każdej osoby z rosteru, każda ranga ma określoną wartość:
			<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col"><center>Dywizja</center></th>
					<th scope="col"><center>Wartość</center></th>
				</tr>
			</thead>
			<tbody>';
			foreach(Functions::$divisions as $i => $value) {
				echo '<tr><td width="40%"><center><img width="100" src="./images/divisions/'.strtolower($value).'.png"/></center></td><td width="40%"><center><font size="6">'.Functions::idToDivisionPower($i).'</font></center></td></tr>';
			}
			echo '</tbody>
		</table>
			</div></div></div>';
?>