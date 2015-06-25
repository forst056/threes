<link rel="stylesheet" href="/css/threes.css">

<?php

$board = seedBoard(24);
printArray($board);

function seedBoard ($maxVal) {
  $board = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

	// Create an empty array with 15 values...

	$emptySeedSet = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14);

	//...then get 8 random keys from the array

	$seedPositions = array_rand( $emptySeedSet, 8);

	for ($i=0; $i<8; $i++) {

		$seedVal = $seedPositions[$i];

		$board[$seedVal] = rand(1,3);
	}

	// Set the last tile on the board to the max value

	$board[15] = $maxVal;

	//...then return the board

	return $board;

}

function printArray($array){
	$class = "";

	echo "<table><tbody><tr>";

	for ($i=0; $i<16; $i++) {

		// Set the colors

		if ($array[$i] === 1) {
			$class = "one";
		}

		else if ($array[$i] === 2) {
			$class = "two";
		}

		// Turn array into 4x4 grid in browser

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
}

?>
