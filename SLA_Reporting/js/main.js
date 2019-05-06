$(function() {
	function error(h, e) {
		var a = document.createElement('a');

		// a.className = 'a';

		a.innerHTML = e;
		document.getElementById('selectdiv').appendChild(a);
		console.log(e);
	}

	function sort_table(sortby) {
//		console.log(sort);
		if (typeof sort == 'undefined') {
			sort = "SORT_ASC";
		} else if (sort == "SORT_ASC") {
			sort = "SORT_DESC";
		} else if (sort == "SORT_DESC") {
			sort = "SORT_ASC";
		}
		var url = "table?report=" + project + "&fromdate=" + fromdate
				+ "&todate=" + todate + "&sortby=" + sortby + "&sort=" + sort;
		window.location = url;
	}

	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)), sURLVariables = sPageURL
				.split('&'), sParameterName, i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true
						: sParameterName[1];
			}
		}
	};
	var project = getUrlParameter('report');
	var fromdate = getUrlParameter('fromdate');
	var todate = getUrlParameter('todate');
	var sortby = getUrlParameter('sortby');
	var sort = getUrlParameter('sort');
	$("#sort0").click(
			function(event) {
				sortby = "ticket_name";
				sort_table(sortby);
			})
	$("#sort1").click(
			function(event) {
				sortby = "creator";
				sort_table(sortby);
			})
	$("#sort2").click(
			function(event) {
				sortby = "created_time";
				sort_table(sortby);
			})
	$("#sort3").click(
			function(event) {
				sortby = "time_to_respond";
				sort_table(sortby);
			})
	$("#sort4").click(
			function(event) {
				sortby = "time_to_resolved";
				sort_table(sortby);
			})
	$("#sort5").click(
			function(event) {
				sortby = "state";
				sort_table(sortby);
			})

//	var request;
//	$("#download").click(
//			function(event) {
//				var url = "download?report=" + project + "&fromdate=" + fromdate
//				+ "&todate=" + todate + "&sortby=" + sortby + "&sort=" + sort;
//				console.log(url);
//				window.location.replace("download");
//			});
				
//				event.preventDefault();
//				if (request) {
//					request.abort();
//				}
//				// setup some local variables
//				var $form = $(this);
//
//				// Let's select and cache all the fields
//				var $inputs = $form.find("input, select, button, textarea");
//
//				// Serialize the data in the form
//				var serializedData = $form.serialize();
//
//				// Let's disable the inputs for the duration of the
//				// Ajax request.
//				// Note: we disable elements AFTER the form data has
//				// been serialized.
//				// Disabled form elements will not be serialized.
//				$inputs.prop("disabled", true);
//
//				// Fire off the request to /form.php
//				var oTable = document.getElementById('report');
//				var oTable = document.getElementById('report');
//				rowLength = 3;
//				var myTableArray = [];
//				var JsonData = '{';
//				$("table#report tr").each(
//						function() {
//							var arrayOfThisRow = [];
//							var tableData = $(this).find('td');
//							console.log($(this).find('td'));
//							if (tableData.length > 0) {
//								tableData.each(function() {
//									arrayOfThisRow.push($(this).text());
//								});
//								myTableArray.push(arrayOfThisRow);
//								var muster = '{' + '"name" : "Raj",'
//										+ '"age" : 32,' + '"married" : false'
//										+ '}';
//								console.log(muster);
//
//								arrayOfThisRow.forEach(function(item) {
//									// console.log(item);
//									JsonData = JsonData + '"key":"';
//									JsonData = JsonData + item;
//									JsonData = JsonData + '",';
//								});
//								JsonData = JsonData.slice(0, -1);
//								JsonData = JsonData + '}';
//								// JsonData = JsonData.slice(10, 0);
////								console.log(1111111111111);
//
//							}
//						});
//				JsonData = JsonData.concat('}');
//				console.log(myTableArray);
//				var muster = {
//					"food" : "apple"
//				};
//				console.log(muster);
//				var myTableArray = JSON.stringify(myTableArray);
//				console.log(myTableArray);
//				// var res = <?php echo json_encode ?>
//				// console.log(myTableArray2);
//				TableData = null;
//				// $.ajax({
//				// type : "POST",
//				// url : "download.php",
//				// // dataType: "json",
//				// data : JsonData,
//				// // contentType: "application/json; charset=utf-8",
//				// success : function(result) {
//				// alert(result);
//				// // console.log(result);
//				// var page = "download.php";
//				// // window.location = page;
//				// },
//				// error : function(result) {
//				// alert('error');
//				// }
//				// });
//
//				var data = window.location.href;
//				var DataString = JSON.stringify(oTable);
//				var serializedData = 123;
//				request = $.ajax({
//					url : "download.php",
//					type : "post",
//					data : {
//						'data' : 123 
//					}
//				});
//
//				// Callback handler that will be called on success
//				request.done(function(response, textStatus, jqXHR) {
//					// Log a message to the console
//					console.log("Hooray, it worked!");
//					// alert(123);
//					var page = "download.php";
//					window.location.replace(page);
////					 window.location = page;
//
//				});
//
//				// Callback handler that will be called on failure
//				request.fail(function(jqXHR, textStatus, errorThrown) {
//					// Log the error to the console
//					console.log("The following error occurred: " + textStatus,
//							errorThrown);
//				});
//
//				// Callback handler that will be called regardless
//				// if the request failed or succeeded
//				request.always(function() {
//					// Reenable the inputs
//					$inputs.prop("disabled", false);
//				});
				//
//			});
});