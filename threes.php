<?php
session_start();
?>

<link rel="stylesheet" href="/css/threes.css">

<?php


$board = ( isset($board) ? $board : array(1,12,0,6,2,3,24,12,96,12,0,0,0,0,3,48));
$board = $_SESSION['board'];

$input = $_GET["input"];

generateNextNum($board);
move($board, $input);

$nextNum = 0;
$boardSize = count($board);

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

function generateNextNum ($array) {

	global $nextNum;
	
	$value = $nextNum;

	#
	## Create an array...
	#
	
	$boardValues = array(1, 2, 3);

	#...and get the quarter value of the largest number on the board...

	$maxVal = max($array)/4;

	#...then use that value to add all the possible values to the array

	$addVal = 1;

	while (($addVal < $maxVal) && ($maxVal > 3)) {
		$addVal = max($boardValues)*2;
		array_push($boardValues, $addVal);
	}

	#
	## Get a random number in the array...
	#

	#...by first creating a random val between 0 and the array length

	$chance = rand(0,100);

	if ($chance <= 50) {
		$randVal = rand(0, 1);
	}
	
	else if ($chance <= 90) {
		$randVal = 2;
	}
	
	else {
		$randVal = rand ( 0, count($boardValues)-1 );
	}

	#...and then getting the value at that random number's key in array

	$getRandArrVal = $boardValues[$randVal];

	# -------- please fill me in -------- #

	#
	## !!!IMPORTANT!!!
	##
	## Weight the random value so that it pulls 1s and 2s
	## most often, followed by 3s, and finally the rest
	## of the values in the array
	##
	#

	# -------- please fill me in -------- #

	#
	## Write the data for the next number
	#

	$nextNum = $getRandArrVal;

}

function move ($board, $input) {

	global $board;
	global $nextNum;

	$canMove = false;

	#
	## Make a working clone of board
	#

	$array = $board;

	#
	## Make an array for TILE ENTRY
	#

	$tileEntryOptions = array();

	#================
	# START THE LOOP
	#/\/\/\/\/\/\/\/\

	foreach ($array as $key=>$value) {

		#
		## Set the ORIGINAL POSITION and REFERENCE POSITION to be used
		#

		switch ($input) {
			case 'right':
				$originPos = 15 - $key;
				$refPos = $originPos - 1;
				$wallCheck = (($originPos) % 4 === 0 ? true : false);
				break;

			case 'down':
				$originPos = 15 - $key;
				$refPos = $originPos - 4;
				$wallCheck = (($originPos > 11) ? true : false);
				break;

			case 'left':
				$originPos = $key;
				$refPos = $originPos + 1;
				$wallCheck = (($originPos+1) % 4 === 0 ? true : false);
				break;
			
			case 'up':
				$originPos = $key;
				$refPos = $originPos + 4;
				$wallCheck = (($originPos > 11) ? true : false);
				break;

			default:
				break;
		}

		#
		## Set the ORIGINAL VALUE to be used
		#

		$originVal = $array[$originPos];

		#
		## Set the REFERENCE VALUE to be used (unless invalid and then set to 0)
		## This check is only applicable for 'up' or 'down' input
		#

		$refVal = ( array_key_exists($refPos, $array) ? $array[$refPos] : 0);

		#=============
		# CHECK DATA
		#=============

		#
		## Check if ORIGINAL VALUE is blank and REFERENCE VALUE is not blank
		#

		$blankCheck = ($originVal < 1 && $refVal > 0 ? true : false);

		#
		## Check if ORIGINAL VALUE and REFERENCE VALUE are both blank
		#

		$doubleBlankCheck = ($originVal < 1 && ($refVal === 0 || $wallCheck) ? true : false);		

		#
		## Combine? Check if ORIGINAL VALUE and REFERENCE VALUE can be combined
		#

		$comboCheck = ( ($originVal === $refVal && $originVal > 2) || (($originVal + $refVal === 3 && $originVal !== 3) && !$wallCheck) ? true : false);

		#
		## Move check? Check if movement occurs
		#

		$moveCheck = (($blankCheck && !$doubleBlankCheck) || $comboCheck ? true : false);

		#
		## If movement occurs, allow for it
		#

		$canMove = ($moveCheck ? true : $canMove);

		#===============
		# SET NEW VALUE
		#===============

		#
		## Set NEW VALUE equal to REFERENCE VALUE if space is unoccupied
		#

		if ($blankCheck) {
			$newVal = $refVal;
		} 

		#...otherwise if it can combine, combine it

		else if ($comboCheck) {
			$newVal = $originVal + $refVal;
		}

		#...otherwise if it can combine, combine it

		else if ($doubleBlankCheck) {
			$newVal = 0;
		}

		#...otherwise keep it the same

		else {
			$newVal = $originVal;
		}

		#===============
		#WRITE TO ARRAY
		#===============

		# If there are two blanks in a row, don't move

		if ($doubleBlankCheck && !$wallCheck) {
			$array[$refPos] = $originVal;
			$array[$originPos] = 0;
		}

		#...otherwise, If a number does move and it's not at the end of the line...

		else if ($moveCheck && !$wallCheck) {

			#...enter its new value into the array...

			$array[$originPos] = $newVal;

			#...and clear out room before it so others can cascade

			$array[$refPos] = -1;
		}

		#...but if it is at the end of the line...
		
		else if ($moveCheck && $wallCheck) {

			#...just bring in a blank space for now

			$array[$originPos] = 0;

		}

		#...otherwise don't fuck with it!
		
		else {
			$array[$originPos] = $originVal;
		}

		#========================
		# CHECK FOR ENTRY POINTS
		#========================

		if ($originVal === -1 && $wallCheck) {
			array_push($tileEntryOptions, $originPos);
		}

	}

	#/\/\/\/\/\/\/\
	# END THE LOOP
	#==============

	#===================
	# CHECK IF CAN MOVE
	#===================

	if (!$canMove) {
		echo "<br/>You can't make that move!";
		return;
	}

	#==============
	# ADD NEW TILE
	#==============

	#
	## Generate the next tile number
	#

	generateNextNum($array);

	#...then make a random choice from available options

	$tileSelect = rand (0, count($tileEntryOptions)-1);

	#...choose that tile on the board

	$tile = $tileEntryOptions[$tileSelect];

	#...put that tile on the board

	$array[$tile] = $nextNum;

	#...and clear board of markers

	foreach ($array as $key => $value) {
		$array[$key] = ($value === -1 ? 0 : $value);
	}

	#===============
	# FINISH HIM!!!
	#===============
	
	printArray($array, $input);
	
	$board = $array;

	return $board;

}

$_SESSION['board'] = $board;

?>

<form action="threes.php" method="GET">
	<input type="submit" action="/threes.php" name="input" value="up" />
	<input type="submit" action="/threes.php" name="input" value="left" />
	<input type="submit" action="/threes.php" name="input" value="right" />
	<input type="submit" action="/threes.php" name="input" value="down" />
</form>