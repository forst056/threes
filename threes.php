<head>
<link rel="stylesheet" href="/css/threes.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('.button').click(function(){
        var clickBtnValue = $(this).name(),
        val = $(this).value(),
        url = 'library.php',
        board = JSON.stringify('board'),
        data =  {
          'action': clickBtnValue,
          'board': board
          };

        $.post(url, data, function (response) {
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
// var_dump($board);

?>

<form action="threes.php" method="POST">
	<input type="submit" action="/threes.php" name="move" value="up" />
	<input type="submit" action="/threes.php" name="move" value="left" />
	<input type="submit" action="/threes.php" name="move" value="right" />
	<input type="submit" action="/threes.php" name="move" value="down" />
	<input type="submit" action="/threes.php" name="seedBoard" value="new game" />
</form>
</body>
