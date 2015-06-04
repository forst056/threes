<?php
session_start();
?>

<link rel="stylesheet" href="/css/threes.css">

<?php

$board = array(1,12,0,6,2,3,24,12,96,12,0,0,0,0,3,48);

function printArray($array){

	global $nextNum;

	$class = "";
	
	echo "<table><tbody><tr>";
	
	for ($i=0; $i<16; $i++) {

		#
		## Set the colors
		#

		if ($array[$i] === 1) {
			$class = "one";
		}
		
		else if ($array[$i] === 2) {
			$class = "two";
		}

		#
		## Turn array into 4x4 grid in browser
		#

		if ($array[$i] === 0) {
			echo "<td> </td>";
		}
		else {
			echo "<td class= " . $class . ">$array[$i]</td>";
		}

		if ((($i+1)%4 === 0) && ($i>1)) {
			echo "</tr><tr>";
		}
		
		$class = "";
	}

	#
	## Let the user know what her next number will be
	#

	echo "<p>Your next number will be: <strong>" . ($nextNum < 4 ? $nextNum : $nextNum) . "</strong>";
}

printArray($board);

$_SESSION['board'] = $board;

?>

<form action="threes.php" method="GET">
	<input type="submit" action="/threes.php" name="move" value="up" />
	<input type="submit" action="/threes.php" name="move" value="left" />
	<input type="submit" action="/threes.php" name="move" value="right" />
	<input type="submit" action="/threes.php" name="move" value="down" />
</form>