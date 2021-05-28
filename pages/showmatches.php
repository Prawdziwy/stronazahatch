<br><br><br><br><br><br>
<?PHP
$admin = 0;
if(isset($_SESSION['access_token'])) {
	$query4 = $conn->query("SELECT * FROM `admins` WHERE `userid`='".$_SESSION['userid']."'");
	if($query4 && $query4->num_rows > 0) {
		$admin = 1;
	}
}
if ($admin == 1) {
	if (isset($_POST["idmatch"])) {
		$queryma = mysqli_query($conn, "DELETE FROM `matches` WHERE `id`='".$_POST["idmatch"]."'");
		header("Refresh:0; url=?p=showmatches");
		die();
	}
}
?>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><center>Lista Meczy</center></h3>
		</div>
		<div class="panel-body">
	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col"><center>#</center></th>
				<?PHP
				echo '<th scope="col"><center>Druzyna 1</center></th>
					<th scope="col"><center>Druzyna 2</center></th>
					<th scope="col"><center>Data</center></th>
					<th scope="col"><center>MVP</center></th>';
				if ($admin == 1) {
					echo '<th scope="col"><center>Edytuj</center></th>';
					echo '<th scope="col"><center>Usuń</center></th>';
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?PHP
			$querytoexecute = "";
			$querytoexecute .= "SELECT * FROM `matches` ";
			$querytoexecute .= ' ORDER BY DATE(`data`) ASC, `data` ASC ';
			if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
			$start_from = ($page-1) * Functions::$results_per_page;
			$querytoexecute .= "LIMIT ".$start_from.", ".Functions::$results_per_page;
			$query = mysqli_query($conn, $querytoexecute);
			if($query && $query->num_rows > 0) {
				$i = 0;
				foreach($query as $mecz) {
					$i++;
					$number = $i+(15*($page-1));
					$druzyna1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$mecz["druzyna1"]."' LIMIT 1"));
					$druzyna2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id` = '".$mecz["druzyna2"]."' LIMIT 1"));
					$disabled = "";
					if ($mecz["wygrany"] == 0) {
						$disabled = "disabled";
					}
					echo '<tr><th scope="row"><center>'.$number.'</center></th>
					<td><center><a href="./?p=showteam&id='.$mecz["druzyna1"].'">'.$druzyna1["nazwa"].'</a></center></td>
					<td><center><a href="./?p=showteam&id='.$mecz["druzyna2"].'">'.$druzyna2["nazwa"].'</a></center></td>
					<td><center>'.$mecz["data"].'</center></td>
					<td><center><form method="post" action="./?p=votemvp&id='.$mecz["id"].'"><button type="submit" class="btn btn-primary btn-sm" '.$disabled.'>Głosuj</button></form></center></td>';
					if ($admin == 1) {
						echo '<td><center><form method="post" action="./?p=editmatch&id='.$mecz["id"].'"><button type="submit" class="btn btn-primary btn-sm">Edytuj</button></form></center></td>';
						echo '<td><center><form method="post" action="'.$_SERVER['REQUEST_URI'].'"><input type="hidden" name="idmatch" id="idmatch" value="'.$mecz["id"].'"/><button type="submit" class="btn btn-primary btn-sm btn-danger">Usuń</button></form></center></td>';
					}
					echo '</tr>';
				}
			} else {
				echo '<tr><td colspan="5">Nie ma żadnych zaplanowanych meczy</td></tr>';
			}
			?>
		</tbody>
	</table>
	<?PHP
	$sql = "SELECT COUNT(ID) AS total FROM `matches`";
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
    echo '<li class="page-item"><a class="page-link" href="./?p='.$subtopic."&page=".$nextpage.'">Następna</a></li>
  </ul>
</nav>';
	?>
		</div>
	</div>
</div>