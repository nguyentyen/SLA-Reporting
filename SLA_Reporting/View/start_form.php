<?php
$projects = $con->get_projects();
?>

<form>
	<div class="form-group selectdiv">
		<label for="project">Project</label> <select
			class="custom-select selectproject"
			id="inputGroupSelect01 selectproject">
			<option selected>Choose a report</option>
				<?php
    foreach ($projects as $project) {
        echo "<option value=\"" . $project . "\">" . $project . "</option>";
    }
    ?>
			</select>

		<p>
			<small id="projectmessage" class="projectmessage form-text">Choose a
				project to export SLA-report.</small>
		</p>
	</div>
	<div class="row">
		<div class="col">
		<?php
// Standard Datum berechnen
$now = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''));
$local = $now->setTimeZone(new DateTimeZone('Europe/Berlin'));
$d = $local->format("d");
$m = $local->format("m");
$Y = $local->format("Y");
$H = $local->format("H");
$i = $local->format("i");
$s = $local->format("s");
$from_m = ($m - 3); // da Monat immer einstellig, bei negativen Wert fällt 0 später weg
if($m < 3) {
    $from_m = $m - 3 + 12;
}
if($from_m<10) {$from_m = "0".$from_m;}
$to_date = "$m/$d/$Y";
$from_date = "$from_m/$d/$Y";
?>
			<label for="">from</label> <input type="text" id="fromdate"
				class="form-control datepicker" placeholder="form date"
				value="<?php echo $from_date;?>
				">
		</div>
		<div class="col">
			<label for="">to</label> <input type="text" id="todate"
				class="form-control datepicker" placeholder="to date"
				value="<?php echo $to_date;?>
				">
		</div>
	</div>
</form>
<div class="row button_line">
	<button type="submit" class="btn btn-info" id="show_report">Show Report</button>
	<button type="download" class="btn btn-info"  id="download">download</button>
</div>
<!-- 	<p>If you click the "Show Report" button, the form-data will be sent to -->
<!-- 		a page called "/action_page.php".</p> -->
</div>

<script>
$("#download").click(function(event){
	var x = $( "option[selected='selected'" ).val();
	if(typeof x !== 'undefined') {
		reset_input_error();
		var fromdate = $("input#fromdate").val();
		var todate = $("input#todate").val();
		var postdata = x+","+fromdate+","+todate; 
		window.location = "download?report="+x+"&fromdate="+fromdate+"&todate="+todate;
		} else { input_error(); }
	})

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) { dd = '0'+dd } 
if(mm<10) { mm = '0'+mm } 
today = mm + '/' + dd + '/' + yyyy;
// document.write(today);
$("#fromdate").datepicker({
// 	 yearRange: "2014:2015",
	maxDate: "+0y",
// 	 minDate: todate,
// 	 dateFormat: 'mm/dd/yyyy',
});
var todate_from = mm - 3 + '/' + dd + '/' + yyyy;
$("#todate").datepicker({
	maxDate: "+0y",
	minDate: todate_from,
});

$("#fromdate").change(function() {
	todate_from = $("input#fromdate").val();
	console.log(todate_from);
	$('#todate').datepicker('destroy');
	$("#todate").datepicker({
		maxDate: "+0y",
		minDate: todate_from,	
	});
});

$("select#selectproject").css('border-color', 'red');
var project = '';
$('select').on('change', function() {
	$( "option" ).removeAttr('selected');
	$( "option[value='"+this.value+"']" ).attr('selected', 'selected');
});
var fromdate = $("#fromdate").text();
var todate = $("#todate").text();

function error(h, e) {
	h.append( "<p>"+e+"</p>" );
	console.log(h);
	}
var request;
$("#show_report").click(function(event){
	var x = $( "option[selected='selected'" ).val();
	if(typeof x !== 'undefined') {
		reset_input_error();
		var fromdate = $("input#fromdate").val();
		var todate = $("input#todate").val();
		var postdata = x+","+fromdate+","+todate; 
		window.location = "table?report="+x+"&fromdate="+fromdate+"&todate="+todate;
		} else { input_error(); }
	})
function input_error() {
	$(".selectproject").css('border', 'solid 1px red');
	$("select#selectproject").css('border-color', 'red');
	$("option[name='place-holder']").css('text-color', 'red');
	$(".projectmessage").css('text-color', 'red');
	$(".selectdiv").css('color', 'red');
}

function reset_input_error() {
	$(".selectproject").css('border', '');
	$("select#selectproject").css('border-color', '');
	$("option[name='place-holder']").css('text-color', '');
	$(".projectmessage").css('text-color', '');
	$(".selectdiv").css('color', '');
}
</script>