<br><br><br><br>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><center>Lista Druzyn</center></h3>
		</div>
		<div class="panel-body">
	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col">#</th>
				<?PHP
				echo '<th scope="col">Nazwa</th>
					<th scope="col">Moc</th>';
				?>
			</tr>
		</thead>
		<tbody>
			<?PHP
			$querytoexecute = "";
			$querytoexecute .= "SELECT * FROM `teams` WHERE `potwierdzony`=1 ";
			if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
			$start_from = ($page-1) * Functions::$results_per_page;
			$querytoexecute .= "LIMIT ".$start_from.", ".Functions::$results_per_page;
			$query = $conn->query($querytoexecute);
			if($query && $query->num_rows > 0) {
				$druzyny = array();
				foreach($query as $druzyna) {
					$mocdruzyna = 0;
					foreach(Functions::$positions as $j => $value) {
						$query3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `rosters` WHERE `druzyna`='".$druzyna["id"]."' LIMIT 1"));
						if($query3[strtolower($value)] > 0) {
							$query4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `players` WHERE `userid`='".$query3[strtolower($value)]."' LIMIT 1"));
							$mocdruzyna += Functions::idToDivisionPower($query4["dywizja"]);
						}
					}
					array_push($druzyny, array($druzyna["id"], $druzyna["nazwa"], $mocdruzyna));
				}
				usort($druzyny, function ($item1, $item2) {
					return $item2[2] <=> $item1[2];
				});
				$k = 0;
				foreach ($druzyny as $druzynau) {
					$k++;
					$number = $k+(15*($page-1));
					echo '<tr><th scope="row">'.$number.'</th><td><a href="./?p=showteam&id='.$druzynau[0].'">'.$druzynau[1].'</a></td><td>'.$druzynau[2].'</td></tr>';
				}
			}
			?>
		</tbody>
	</table>
	<?PHP
	$sql = "SELECT COUNT(ID) AS total FROM `teams` WHERE `potwierdzony`=1";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$total_pages = ceil($row["total"] / Functions::$results_per_page); // calculate total pages with results
	
	$previouspage = 1;
	if ($page > 1) { $previouspage = $page-1; }; 
	$nextpage = $total_pages;
	if ($page < $total_pages) { $nextpage = $page+1; }; 
	
	echo '<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="./?p='.$subtopic."&page=".$previouspage.'">Poprzednia</a></li>';
	for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
		$active = "";
		if ($i == $page) {
			$active = "active";
		}
        echo '<li class="page-item '.$active.'"><a class="page-link" href="./?p='.$subtopic."&page=".$i.'">'.$i.'</a></li>';
	}; 
    echo '<li class="page-item"><a class="page-link" href="./?p='.$subtopic."&page=".$nextpage.'">Nastepna</a></li>
  </ul>
</nav>';
	?>
		</div>
	</div>
</div>