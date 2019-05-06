<?php
$report = "";
$fromdate = "";
$todate = "";
$sortby = "";
$sort = "";
if(array_key_exists('report', $_GET)) {$report = $_GET['report'];}
if(array_key_exists('fromdate', $_GET)) {$fromdate = $_GET['fromdate'];}
if(array_key_exists('todate', $_GET)) {$todate = $_GET['todate'];}
if(array_key_exists('sortby', $_GET)) {$sortby = $_GET['sortby'];}
if(array_key_exists('sort', $_GET)) {$sort = $_GET['sort'];}
$download_url = "download?report=$report&fromdate=$fromdate&todate=$todate&sortby=$sortby&sort=$sort";

if(isset($_GET)) {
    $tickets = $con->get_tickets($_GET);    
}
?>
<script>
</script>
<h2><?php echo $_GET["report"];?></h2>
<p>
	Business Hours: Describes the time period declared as the most critical
	to your business and configured while setting up your SLA. The
	availability SLA will then be applicable for the time frame defined
	within the Business Hours. <br>
</p>
<p>
	This time period is from Monday to Friday, everyday between 08:00 to
	17:00 hours. This time frame is applicable everyday except <a
		href="https://publicholidays.de/bavaria/2018-dates/">holidays</a>
</p><table class="table" id="report">
	<?php
$table = "<thead><tr>";
$titels = [
    "Ticket name",
    "Created by",
    "Created date",
    "Time to respond",
    "Time to resolved",
    "Current state"
];
foreach ($titels as $key => $titel) {
    $table .= "<th>" . $titel . "<i id=\"sort" . $key . "\" class=\"fa fa-sort float-right\"></i></th>";
}

$table .= "</tr></thead><tbody>";
$sort = null;
$sortby = null;
if(array_key_exists('sortby', $_GET) && array_key_exists('sort', $_GET)) {
    $sort = $_GET['sort'];
    $sortby = $_GET['sortby'];
    if($sort == "SORT_DESC") {
        $tickets = $con->tickets_sort($tickets, $sortby, SORT_DESC);
    } else {
        $tickets = $con->tickets_sort($tickets, $sortby, SORT_ASC);
    }
}

foreach($tickets as $ticket) {
    $table .= "<tr>";
    $table .= "<td>".$ticket['ticket_name']."</td>";
    $table .= "<td>".$ticket['creator']."</td>";
    $table .= "<td>".$ticket['created_time']."</td>";
    $table .= "<td>".$ticket['time_to_respond']."</td>";
    $table .= "<td>".$ticket['time_to_resolved']."</td>";
    $table .= "<td>".$ticket['state']."</td>";
    $table .= "</tr>";
}

$table .= "</tbody></table>";
if(count($tickets) == 0) {
    echo "<p style='color: red'>no ticket was found in the selected time period<p>";
} else {
    echo $table;
}
?>
		
	<form>
		<div class="row button_line">
			<button type="submit" class="btn btn-info"
				formaction="<?php echo "$url_prefix/index.php"; ?>">Start Site</button>
			<a href="<?php echo $download_url;?>" class="btn btn-info">Download</a>
		</div>
	</form>
	</div>