<!DOCTYPE html>
<html lang="en">
<head>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/chosen.jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/main.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/jquery-ui.min.css">
<link rel="stylesheet" href="css/chosen.min.css">
<link rel="stylesheet" href="fontawesome-free-5.3.1-web/css/all.min.css">
<link rel="stylesheet" href="css/main.css">
</head>

<body>
	<div class="jumbotron titelline text-center"
		style="margin-bottom: auto">
		<h1>SLA Report</h1>
		<!-- 	<p>Resize this responsive page to see the effect!</p> -->
	</div>


	<nav class="navbar navbar-light navbar-expand-lg navbar-light"
		style="background-color: #e9ecef;">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse"
				data-target="#navbarTogglerDemo03"
				aria-controls="navbarTogglerDemo03" aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<!--   <a class="navbar-brand" href="#">Navbar</a> -->

			<div class="collapse navbar-collapse" id="navhome"
				style="margin_left: 200px;">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li
						class="nav-item <?php if($_SERVER['PHP_SELF'] == "/SLA_Reporting/index.php") {echo "active";}?>">
						<a
						class="nav-link <?php if($_SERVER['PHP_SELF'] !== "/SLA_Reporting/index.php") {echo "disabled";}?>"
						href="index.php">Home <span class="sr-only">(current)</span></a>

					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">