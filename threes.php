<head>
<link rel="stylesheet" href="/css/threes.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('.button').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'library.php',
        data =  {'action': clickBtnValue};

        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            alert("action performed successfully");
        });
    });

});
</script>
</head>

<body>

<?php

// generateNextNum($board);

// move($board, $input);

// $nextNum = 0;
// $boardSize = count($board);
var_dump($board);

?>

<form action="threes.php" method="GET">
	<input type="submit" action="/threes.php" name="input" value="up" />
	<input type="submit" action="/threes.php" name="input" value="left" />
	<input type="submit" action="/threes.php" name="input" value="right" />
	<input type="submit" action="/threes.php" name="input" value="down" />
	<input type="submit" action="/threes.php" name="seedBoard" value="new game" />
	<input type="submit" action="/threes.php" name="json_decode" value="test" />
</form>
</body>
