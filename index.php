<!DOCTYPE html>
<html>
<head>
	<title></title>
<link rel="stylesheet" href="/css/threes.css">
<script type="text/javascript">var board = new Array(1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)</script>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.button').click(function() {
			var clickBtnValue = $(this).val();
			var ajaxurl = 'threes.php',
			data = {
				'action': clickBtnValue,
				'board' : JSON.stringify(board);
			};
			$.post(ajaxurl, data, function(response) {
				alert("action performed successfully");
			});
		});
	});
</script>
</head>
<body>

<table>
<tbody>
<tr>
<script language="javascript" type="text/javascript">

for (i=0; i<16; i++) {
	if (i%4 == 0 && i > 1) {document.write("</tr><tr>")};
	document.write("<td>" + board[i] + "</td>");
}

</script>
<tr>
</tbody>
</table>

<form action="/threes.php" method="POST">
<input type="submit" class="button" name="up" value="up" />
<input type="submit" class="button" name="right" value="right" />
<input type="submit" class="button" name="down" value="down" />
<input type="submit" class="button" name="left" value="left" />
</form>
</body>
</html>



<?php

?>