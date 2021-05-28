<!DOCTYPE html>
<html lang="en">

<head>
	<script language="javascript">
	if( /Android|webOS|iPhone|iPod|iPad|BlackBerry/i.test(navigator.userAgent)) {document.write("<style>body{zoom:80%;}</style>");}
	</script>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Zahatch Cup - <?PHP echo ucfirst($subtopic); ?></title>
	<meta name="viewport" content="width=500px, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="<?PHP echo $template_name; ?>/css/style.css" rel="stylesheet" />
</head>

<body>
	<img id="background-img" class="bg" src="./zahatch_cup.jpg" alt="">
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="./?p=mainpage">Zahatch Cup</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
	   <?PHP
		$textdruzyna = '<a class="dropdown-item" href="./?p=teamslist">Lista</a>
		<a class="dropdown-item" href="./?p=teaminformations">Informacje</a>';
		$textmecze = '<a class="dropdown-item" href="./?p=showmatches">Lista</a>
		<a class="dropdown-item" href="./?p=showgroups">Grupy</a>';
		if(isset($_SESSION['access_token'])) {
			$query2 = $conn->query("SELECT * FROM `players` WHERE `userid`='".$_SESSION['userid']."'");
			if($query2 && $query2->num_rows > 0) {
				$query2 = mysqli_fetch_array($query2);
				if($query2["druzyna"] == 0) {
					$textdruzyna .= '<a class="dropdown-item" href="./?p=signupteam">Zapisz</a>';
					echo '<li class="nav-item"><a class="nav-link" href="./?p=yourinvites">Zaproszenia</a></li>';
				} else {
					$query3 = $conn->query("SELECT * FROM `teams` WHERE `id`='".$query2["druzyna"]."'");
					if($query3 && $query3->num_rows > 0) {
						$query3 = mysqli_fetch_array($query3);
						if($query3["lider"] == $query2["userid"]) {
							echo '<li class="nav-item"><a class="nav-link" href="./?p=editteam">Edytuj drużynę</a></li>';
							$textdruzyna .= '<a class="dropdown-item" href="./?p=editteam">Edytuj</a>';
							$textdruzyna .= '<a class="dropdown-item" href="./?p=planscrims">Skrimy</a>';
						}
						$textdruzyna .= '<a class="dropdown-item" href="./?p=showteam&id='.$query3["id"].'">Pokaż</a>';
					}
				}
				$query4 = $conn->query("SELECT * FROM `admins` WHERE `userid`='".$_SESSION['userid']."'");
				if($query4 && $query4->num_rows > 0) {
					$textmecze .= '<a class="dropdown-item" href="./?p=addmatch">Dodaj</a>';
					$textdruzyna .= '<a class="dropdown-item" href="./?p=confirmteams">Zatwierdź</a>';
				}
				echo '<li class="nav-item"><a class="nav-link" href="./?p=editprofile">Edytuj profil</a></li>';
			} else {
				echo '<li class="nav-item"><a class="nav-link" href="./?p=signupplayer">Zarejestruj się</a></li>';
			}
		}
		echo '<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  Drużyna
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				'.$textdruzyna.'
			</div>
		</li>';
			echo '<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Mecze
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					'.$textmecze.'
				</div>
			</li>';	
	  ?>
    </ul>
    <?PHP
		if(isset($_SESSION['access_token'])) {
			$query2 = $conn->query("SELECT * FROM `players` WHERE `userid`='".$_SESSION['userid']."'");
			if($query2 && $query2->num_rows > 0) {
				echo '<font color="green" size="5">Zapisany</font>';
			} else {
				echo '<font color="red" size="5">Nie zapisany</font>';
			}
		} else {
			echo '<li class="nav-item"><a class="nav-link" href="./?action=login">Zaloguj poprzez Discord</a></li>';
		}
	  ?>
  </div>
</nav>
    <?PHP 
	// DataBase
	echo $main_content; 
	?>
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<br>
</body>

</html>