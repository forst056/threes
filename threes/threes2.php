<link rel="stylesheet" href="/css/threes.css">

<?php

$nextNum = 0;

$board = array(1,1,0,6,2,0,0,12,0,12,3,24,0,48,0,48);
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
		## Echo the array value
		#

		echo "<td class= " . $class . ">$array[$i]</td>";

		if ((($i+1)%4 === 0) && ($i>1)) {
			echo "</tr><tr>";
		}
		
		$class = "";
	}

	#
	## Let the user know what her next number will be
	#

	echo "<p>Your next number will be: <strong>" . ($nextNum < 4 ? $nextNum : "x") . "</strong>";
}

function generateNextNum ($array) {

	global $nextNum;
	
	$value = $nextNum;

	#
	## Create an array for the unique board values
	#
	
	$boardValues = array_unique($array);

	#...make sure 1, 2, and 3 are in there

	array_push($boardValues, 1, 2, 3);

	#...and then strip it of duplicates

	$boardValues = array_unique($boardValues);

	#...sort it ascending to ensure proper key/val

	sort ($boardValues);

	#...and then get rid of that pesky 0

	array_shift($boardValues);

	#
	## Get a random number in the array
	#

	#...by first creating a random val between 0 and the array length

	$randVal = rand ( 0, count($boardValues)-1 );

	#...and then getting the value at that random numbers key in array

	$getRandArrVal = $boardValues[$randVal];

	

	### \/ for testing only \/ ###

	# print_r($getRandArrVal);
	# var_dump($boardValues);

	### /\ for testing only /\ ###


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

	$array = $board;

	generateNextNum($array);

	foreach ($array as $key=>$value) {

		#
		## Set the ORIGINAL POSITION and REFERENCE POSITION to be used
		#

		switch ($input) {
			case 'right':
				$originPos = 15 - $key;
				$refPos = $originPos - 1;
				
				break;

			case 'down':
				$originPos = 15-$key;
				$refPos = $originPos - 4;
				break;

			case 'left':
				$originPos = $key;
				$refPos = $originPos + 1;
				break;
			
			case 'up':
				$originPos = $key;
				$refPos = $originPos + 4;
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
		#

		$refVal = ( array_key_exists($refPos, $array) ? $array[$refPos] : 0);

		#=============
		# CHECK DATA
		#=============

		#
		## Check if ORIGINAL VALUE is blank
		#

		$blankCheck = ($originVal === 0 ? true : false);

		#
		## Combine? Check if ORIGINAL VALUE and REFERENCE VALUE can be combined
		#

		$comboCheck = ( ($originVal === $refVal && $originVal > 2) || ($originVal + $refVal) === 3 ? true : false);

		#
		## Move check? Check if movement occurs
		#

		$moveCheck = ($blankCheck || $comboCheck ? true : false);

		#
		## Check if last in column/row
		#

		$wallCheck = ( ($key + 1) % 4 === 0 ? true : false);

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

		#...otherwise keep it the same

		else {
			$newVal = $originVal;
		}

		#===============
		#WRITE TO ARRAY
		#===============

		#
		## If a number does move and it's not at the end of the line...
		#

		if ($moveCheck && !$wallCheck) {

			#...enter its new value into the array

			$array[$originPos] = $newVal;

			#...and clear out room before it for others to cascade

			$array[$refPos] = 0;
		}

		#
		## But if it is at the end of the line
		#

		else if ($moveCheck && $wallCheck) {

			#...just bring in a blank space for now

			#------fill me in-------

			$array[$originPos] = 0;

		}

		#
		## Otherwise don't fuck with it!
		#

		else {
			$array[$originPos] = $originVal;
		}
	}

	printArray($array, $input);
	$board = $array;
	return $board;

}

generateNextNum($board);
printArray($board);
move($board, 'left');
generateNextNum($board);
move($board, 'right');
move($board, 'up');


?>