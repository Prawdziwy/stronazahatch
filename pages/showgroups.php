<br><br><br><br>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><center>Grupy</center></h3>
		</div>
		<div class="panel-body mw-body">
		<style>
		@media (min-width: 601px)
		.template-box {
			display: block;
			vertical-align: top;
			margin: 0 0 0 0;
			box-sizing: content-box;
			max-width: 100%;
		}
		.mw-content-ltr {
			direction: ltr;
		}
		.table-responsive {
			overflow-x: unset;
		}
		@media (min-width: 601px)
		.template-box > * {
			box-sizing: border-box;
		}
		table.wikitable {
			background-color: #f8f9fa;
			color: #222;
			margin: 1em 0;
			border: 1px solid #a2a9b1;
			border-collapse: collapse;
		}
		.wikitable {
			margin-bottom: 1rem;
			background-color: #ffffff !important;
			border: 1px solid #bbbbbb !important;
		}
		.wikitable {
			margin-bottom: 1rem;
			background-color: #ffffff !important;
			border: 1px solid #bbbbbb !important;
		}
		table {
			border-collapse: collapse;
		}
		.wikitable.wikitable-bordered > thead > tr > th, .wikitable.wikitable-bordered > thead > tr > td, .wikitable.wikitable-bordered > thead > tr > th:not(:first-child), .wikitable.wikitable-bordered > thead > tr > td:not(:first-child), .wikitable.wikitable-bordered > thead > tr > th:not(:last-child), .wikitable.wikitable-bordered > thead > tr > td:not(:last-child), .wikitable.wikitable-bordered > tbody > tr > th, .wikitable.wikitable-bordered > tbody > tr > td, .wikitable.wikitable-bordered > tbody > tr > th:not(:first-child), .wikitable.wikitable-bordered > tbody > tr > td:not(:first-child), .wikitable.wikitable-bordered > tbody > tr > th:not(:last-child), .wikitable.wikitable-bordered > tbody > tr > td:not(:last-child), .wikitable.wikitable-bordered > tr > th, .wikitable.wikitable-bordered > tr > td, .wikitable.wikitable-bordered > tr > th:not(:first-child), .wikitable.wikitable-bordered > tr > td:not(:first-child), .wikitable.wikitable-bordered > tr > th:not(:last-child), .wikitable.wikitable-bordered > tr > td:not(:last-child) {
			border-left: 1px solid #bbbbbb !important;
			border-right: 1px solid #bbbbbb !important;
		}
		.wikitable > tr > th, .wikitable > thead > tr > th, .wikitable > tbody > tr > th, .wikitable > tr > td, .wikitable > thead > tr > td, .wikitable > tbody > tr > td {
			padding: 5px;
			vertical-align: middle;
			border: 1px solid #bbbbbb !important;
		}
		.wikitable > tr > th, .wikitable > tr > td, .wikitable > thead > tr > th, .wikitable > thead > tr > td, .wikitable > tbody > tr > th, .wikitable > tbody > tr > td {
			padding: 5px;
			vertical-align: middle;
			border: 1px solid #bbbbbb !important;
		}
		table.wikitable > tr > th, table.wikitable > tr > td, table.wikitable > * > tr > th, table.wikitable > * > tr > td {
			border: 1px solid #a2a9b1;
			padding: 0.2em 0.4em;
		}
		.match-row, .bracket-hover, .grouptableslot, .matchlistslot, .bracket-team-top, .bracket-team-bottom, .bracket-team-middle, .bracket-team-inner, .bracket-player-top, .bracket-player-bottom, .bracket-player-middle, .bracket-player-inner {
			transition: 0.5s;
		}
		*, *::before, *::after {
			box-sizing: border-box;
		}
		td[Attributes Style] {
			text-align: -webkit-left;
		}
		table.wikitable > tr > th, table.wikitable > * > tr > th {
			background-color: #eaecf0;
			text-align: center;
		}
		.template-box {
			display: block;
			margin-left: auto;
			margin-right: auto;
			width: 60%;
		}

		</style><br>
		<div id="mw-content-text">
		<div>
		<div class="template-box" style="">
		<div><div class="template-box" style="">
		<?PHP
			$teamsgroups = array(
				"A" => array(
					29,
					17,
					22,
					31,
					21
				),
				"B" => array(
					16,
					20,
					18,
					14,
					19
				)
			);
		?>
		<div class="table-responsive toggle-area toggle-area-1" data-toggle-area="1" style="padding-bottom:27px;margin-bottom:-27px"><table class="wikitable wikitable-bordered grouptable" style="width:350px;margin:0px"><tbody><tr><th colspan="7"><span>Grupa A</span></th></tr>
			<?PHP
			$druzyny = array();
			foreach ($teamsgroups["A"] as $groupateam) {
				$mecze = 0;
				$wygrane = 0;
				$query1 = mysqli_query($conn, "SELECT * FROM `matches` WHERE `druzyna1`='".$groupateam."' OR `druzyna2`='".$groupateam."'");
				foreach ($query1 as $mecz) {
					if ($mecz["wygrany"] != 0) {
						$mecze += 1;
						if ($mecz["wygrany"] == $groupateam) {
							$wygrane += 1;
						}
					}
				}
				$przegrane = $mecze-$wygrane;
				$druzyna = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id`='".$groupateam."' LIMIT 1"));
				array_push($druzyny, array($druzyna["id"], $druzyna["nazwa"], $wygrane, $przegrane));
			}
			usort($druzyny, function ($item1, $item2) {
				return $item2[2] <=> $item1[2];
			});
			$i=0;
			foreach ($druzyny as $druzyna) {
				$i++;
				$color = "219,237,237";
				if ($i == 2) {
					$color = "221,244,221";
				} elseif ($i == 3 or $i == 4) {
					$color = "229,244,198";
				} elseif ($i == 5) {
					$color = "251,223,223";
				}
				echo '
				<tr>
					<th style="width:28px;background-color:rgb('.$color.')">'.$i.'.</th>
					<td class="grouptableslot" colspan="5" align="center" style="background-color:rgb('.$color.')">'.$druzyna[1].'</td>
					<td width="35px" align="center" style="white-space:pre;background-color:rgb('.$color.')"><b>'.$druzyna[2].'-'.$druzyna[3].'</b></td>
				</tr>
				';
			}
			?>
		</tbody></table></div>
		<p><br>
		</p>
		</div>
		<div class="template-box" style=""> 
		<div class="table-responsive toggle-area toggle-area-1" style="padding-bottom:27px;margin-bottom:-27px"><table class="wikitable wikitable-bordered grouptable" style="width:350px;margin:0px"><tbody><tr><th colspan="7"><span>Grupa B</span></div></th></tr>
			<?PHP
			$druzyny = array();
			foreach ($teamsgroups["B"] as $groupbteam) {
				$mecze = 0;
				$wygrane = 0;
				$query1 = mysqli_query($conn, "SELECT * FROM `matches` WHERE `druzyna1`='".$groupbteam."' OR `druzyna2`='".$groupbteam."'");
				foreach ($query1 as $mecz) {
					if ($mecz["wygrany"] != 0) {
						$mecze += 1;
						if ($mecz["wygrany"] == $groupbteam) {
							$wygrane += 1;
						}
					}
				}
				$przegrane = $mecze-$wygrane;
				$druzyna = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `teams` WHERE `id`='".$groupbteam."' LIMIT 1"));
				array_push($druzyny, array($druzyna["id"], $druzyna["nazwa"], $wygrane, $przegrane));
			}
			usort($druzyny, function ($item1, $item2) {
				return $item2[2] <=> $item1[2];
			});
			$i=0;
			foreach ($druzyny as $druzyna) {
				$i++;
				$color = "219,237,237";
				if ($i == 2) {
					$color = "221,244,221";
				} elseif ($i == 3 or $i == 4) {
					$color = "229,244,198";
				} elseif ($i == 5) {
					$color = "251,223,223";
				}
				echo '
				<tr>
					<th style="width:28px;background-color:rgb('.$color.')">'.$i.'.</th>
					<td class="grouptableslot" colspan="5" align="center" style="background-color:rgb('.$color.')">'.$druzyna[1].'</td>
					<td width="35px" align="center" style="white-space:pre;background-color:rgb('.$color.')"><b>'.$druzyna[2].'-'.$druzyna[3].'</b></td>
				</tr>
				';
			}
			?>
		</tbody></table></div>
		<p><br>
		</p>
		</div></div>
		</div>
		</div>
		</div>
		</div>
	</div>
</div>
