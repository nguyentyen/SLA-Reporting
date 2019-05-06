<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>change demo</title>
  <style>
  div {
    color: red;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
<p>Select a any value in list.</p>

<select id="mySelect" onchange="myFunction()">
  <option value="1">A
  <option value="2">B
  <option value="3">Ccccc
  <option value="4">D
</select>

<button id="btn">Show selected</button>

<div id="display"></div>

 
<script>
$( "#display" ).attr('selected', 'selected');
$( "option[value='3']" ).attr('selected', 'selected');
function myFunction() {
//     var x = document.getElementById("mySelect").value;
    $( "option" ).attr('selected', 'selected');
}
</script>
 
</body>
</html>