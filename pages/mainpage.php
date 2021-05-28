<br>
	<?PHP
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

	error_reporting(E_ALL);

	define('OAUTH2_CLIENT_ID', 'oauthclientid');
	define('OAUTH2_CLIENT_SECRET', 'F6MPT9O0qYjyKyC4wztmGaYvfcQ44O9B');

	$authorizeURL = 'https://discord.com/api/oauth2/authorize';
	$tokenURL = 'https://discord.com/api/oauth2/token';
	$apiURLBase = 'https://discord.com/api/users/@me';

	// Start the login process by sending the user to Discord's authorization page
	if(get('action') == 'login') {

	  $params = array(
		'client_id' => OAUTH2_CLIENT_ID,
		'redirect_uri' => 'sitename',
		'response_type' => 'code',
		'scope' => 'identify guilds'
	  );

	  // Redirect the user to Discord's authorization page
	  header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params));
	  die();
	}


	// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
	if(get('code')) {
		// Exchange the auth code for a token
		$token = apiRequest($tokenURL, array(
		"grant_type" => "authorization_code",
		'client_id' => OAUTH2_CLIENT_ID,
		'client_secret' => OAUTH2_CLIENT_SECRET,
		'redirect_uri' => 'sitename',
		'code' => get('code')
		));
		$logout_token = $token->access_token;
		$_SESSION['access_token'] = $token->access_token;
	  
		header('Location: ' . $_SERVER['PHP_SELF']);
	}
	if(session('access_token')) {
	  $user = apiRequest($apiURLBase);
	  $_SESSION['userid'] = $user->id;
	  $_SESSION['username'] = $user->username;
	}


	if(get('action') == 'logout') {
	  // This must to logout you, but it didn't worked(

	  $params = array(
		'access_token' => $logout_token
	  );

	  // Redirect the user to Discord's revoke page
	  header('Location: https://discordapp.com/api/oauth2/token/revoke' . '?' . http_build_query($params));
	  die();
	}

	function apiRequest($url, $post=FALSE, $headers=array()) {
	  $ch = curl_init($url);
	  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	  $response = curl_exec($ch);


	  if($post)
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

	  $headers[] = 'Accept: application/json';

	  if(session('access_token'))
		$headers[] = 'Authorization: Bearer ' . session('access_token');

	  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	  $response = curl_exec($ch);
	  return json_decode($response);
	}

	function get($key, $default=NULL) {
	  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
	}

	function session($key, $default=NULL) {
	  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
	}
	?>
<?PHP
?><br><br><br>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><center>Lista Graczy</center></h3>
		</div>
		<div class="panel-body">
	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col">#</th>
				<?PHP
				$nazwasorttype = "desc";
				$dywizjasorttype = "desc";
				$podstawowapozycjasorttype = "desc";
				$drugapozycjasorttype = "desc";
				$druzynasorttype = "desc";
				if (isset($_GET['sortby'])) {
					$sorttypeget = $_GET['sortby'];
					if (isset($_GET['type'])) {
						$sorttype = $_GET["type"];
						if ($sorttypeget == "nazwa" && $sorttype == "desc") {
							$nazwasorttype = "asc";
						} elseif ($sorttypeget == "dywizja" && $sorttype == "desc") {
							$dywizjasorttype = "asc";
						} elseif ($sorttypeget == "podstawowapozycja" && $sorttype == "desc") {
							$podstawowapozycjasorttype = "asc";
						} elseif ($sorttypeget == "drugapozycja" && $sorttype == "desc") {
							$drugapozycjasorttype = "asc";
						} elseif ($sorttypeget == "druzyna" && $sorttype == "desc") {
							$druzynasorttype = "asc";
						}
					}
				}
				echo '<th scope="col"><a href="./?p=mainpage&sortby=nazwa&type='.$nazwasorttype.'">Nazwa</a></th>';
				echo '<th scope="col"><a href="./?p=mainpage&sortby=dywizja&type='.$dywizjasorttype.'">Dywizja</a></th>';
				echo '<th scope="col"><a href="./?p=mainpage&sortby=podstawowapozycja&type='.$podstawowapozycjasorttype.'">Podstawowa pozycja</a></th>';
				echo '<th scope="col"><a href="./?p=mainpage&sortby=drugapozycja&type='.$drugapozycjasorttype.'">Druga pozycja</a></th>';
				echo '<th scope="col"><a href="./?p=mainpage&sortby=druzyna&type='.$druzynasorttype.'">Druzyna</a></th>';
				?>
			</tr>
		</thead>
		<tbody>
			<?PHP
			$querytoexecute = "";
			$querytoexecute .= "SELECT * FROM `players` ";
			if (isset($_GET['sortby'])) {
				$sort = $_GET['sortby'];
				if (isset($_GET['type'])) {
					$sorttype = $_GET['type'];
					if ($sorttype == "desc") {
						$sorttype = "DESC";
					} elseif ($sorttype == "asc") {
						$sorttype = "ASC";
					} else {
						$sorttype = "DESC";
					}
				} else {
					$sorttype = "DESC";
				}
				if($sort == "dywizja") {
					$querytoexecute .= "ORDER BY `dywizja` ";
				} elseif($sort == "druzyna") {
					$querytoexecute .= "ORDER BY `druzyna` ";
				} elseif($sort == "podstawowapozycja") {
					$querytoexecute .= "ORDER BY `pozycja` ";
				} elseif($sort == "drugapozycja") {
					$querytoexecute .= "ORDER BY `pozycjadruga` ";
				} elseif($sort == "nazwa") {
					$querytoexecute .= "ORDER BY `nazwa` ";
				}
				$querytoexecute .= $sorttype.' ';
			}
			if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
			$start_from = ($page-1) * Functions::$results_per_page;
			$querytoexecute .= "LIMIT ".$start_from.", ".Functions::$results_per_page;
			$query = $conn->query($querytoexecute);
			if($query && $query->num_rows > 0) {
				$i=0;
				foreach($query as $gracz) {
					$i++;
					$druzyna = $gracz["druzyna"];
					$druzynatext = "Brak drużyny";
					if($druzyna > 0) {
						$query2 = $conn->query("SELECT * FROM `teams` WHERE `id`= '".$druzyna."' LIMIT 1");
						if($query2 && $query2->num_rows > 0) {
							$query2 = mysqli_fetch_array($query2);
							if($query2["potwierdzony"] == 1) {
								$druzynatext = '<a href="./?p=showteam&id='.$query2["id"].'">'.$query2["nazwa"].'</a>';
							} else {
								$druzynatext = 'Brak potwierdzonej drużyny';
							}
						}
					}
					$number = $i+(15*($page-1));
					echo '<tr><th scope="row">'.$number.'</th><td><a href="./?p=playercard&id='.$gracz["id"].'">'.$gracz["nazwa"].'</a></td><td>'.Functions::idToDivision($gracz["dywizja"]).'</td><td>'.Functions::idToPosition($gracz["pozycja"]).'</td><td>'.Functions::idToPosition($gracz["pozycjadruga"]).'</td><td>'.$druzynatext.'</td><td></td></tr>';
				}
			}
			?>
		</tbody>
	</table>
	<?PHP
	$sql = "SELECT COUNT(ID) AS total FROM `players`";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$total_pages = ceil($row["total"] / Functions::$results_per_page); // calculate total pages with results
	
	$previouspage = 1;
	if ($page > 1) { $previouspage = $page-1; }; 
	$nextpage = $total_pages;
	if ($page < $total_pages) { $nextpage = $page+1; }; 
	
	echo '<nav aria-label="Page navigation example">
  <ul class="pagination">';
	if ((!empty($sort)) and (!empty($sorttype))) {
		echo '<li class="page-item"><a class="page-link" href="./?p='.$subtopic.'&page='.$previouspage.'&sortby='.$_GET['sortby'].'&type='.$_GET['type'].'">Poprzednia</a></li>';
	} else {
		echo '<li class="page-item"><a class="page-link" href="./?p='.$subtopic.'&page='.$previouspage.'">Poprzednia</a></li>';
	}
	for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
		$active = "";
		if ($i == $page) {
			$active = "active";
		}
		if ((!empty($sort)) and (!empty($sorttype))) {
			echo '<li class="page-item '.$active.'"><a class="page-link" href="./?p='.$subtopic.'&page='.$i.'&sortby='.$_GET['sortby'].'&type='.$_GET['type'].'">'.$i.'</a></li>';
		} else {
			echo '<li class="page-item '.$active.'"><a class="page-link" href="./?p='.$subtopic.'&page='.$i.'">'.$i.'</a></li>';
		}
	}; 
	if ((!empty($sort)) and (!empty($sorttype))) {
		echo '<li class="page-item"><a class="page-link" href="./?p='.$subtopic.'&page='.$nextpage.'&sortby='.$_GET['sortby'].'&type='.$_GET['type'].'">Następna</a></li>';
	} else {
		echo '<li class="page-item"><a class="page-link" href="./?p='.$subtopic.'&page='.$nextpage.'">Następna</a></li>';
	}
	echo '</ul>
</nav>';
	?>
		</div>
	</div>
</div>
