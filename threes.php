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
var_dump($board);

?>

<form action="threes.php" method="GET">
	<input type="submit" action="/threes.php" name="input" value="up" />
	<input type="submit" action="/threes.php" name="input" value="left" />
	<input type="submit" action="/threes.php" name="input" value="right" />
	<input type="submit" action="/threes.php" name="input" value="down" />
	<input type="submit" action="/threes.php" name="seedBoard" value="seedBoard" />
	<input type="submit" action="/threes.php" name="json_decode" value="json_decode" />
</form>
</body>

<?php
// move($board, $input);
// testing

// $board = array(1,12,0,6,2,0,0,12,0,12,3,24,0,48,0,48);

$board = json_decode($_POST['board']);

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'up':
        	echo "success";
            move($board, 'up');
            break;
        case 'right':
            move($board, 'right');
            break;
        case 'left':
            move($board, 'left');
            break;
        case 'down':
            move($board, 'down');
            break;
        default:
        	break;
    }
}



$boardSize = count($board);

// $nextNum = 0;
// $boardSize = count($board);
// var_dump($board);

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

	$canMove = false;

	#
	## Make a working clone of board
	#

	$array = $board;

	#
	## Make an array for TILE ENTRY
	#

	$tileEntryOptions = array();

	foreach ($array as $key=>$value) {

		#
		## Set the ORIGINAL POSITION and REFERENCE POSITION to be used
		#

		switch ($input) {
			case 'right':
				$originPos = 15 - $key;
				$refPos = $originPos - 1;
				$wallCheck = ($originPos % 4 === 0 ? true : false);
				break;

			case 'down':
				$originPos = 15 - $key;
				$refPos = $originPos - 4;
				$wallCheck = (($originPos > 11) ? true : false);
				break;

			case 'left':
				$originPos = $key;
				$refPos = $originPos + 1;
				$wallCheck = ($originPos % 4 === 0 ? true : false);
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
		#

		$refVal = ( array_key_exists($refPos, $array) ? $array[$refPos] : -1);

		#=============
		# CHECK DATA
		#=============

		#
		## Check if ORIGINAL VALUE is blank
		#

		$blankCheck = ($originVal === 0 && $refVal !==0 ? true : false);

		#
		## Combine? Check if ORIGINAL VALUE and REFERENCE VALUE can be combined
		#

		$comboCheck = ( ($originVal === $refVal && $originVal > 2) || ($originVal + $refVal) === 3 ? true : false);

		#
		## Move check? Check if movement occurs
		#

		$moveCheck = ($blankCheck || $comboCheck ? true : false);

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

		#...otherwise keep it the same

		else {
			$newVal = $originVal;
		}

		#================
		# SET TILE ENTRY
		#================

		if ($moveCheck && $wallCheck) {
			array_push($tileEntryOptions, $originPos);
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

			$array[$originPos] = 0;

		}

		#
		## Otherwise don't fuck with it!
		#

		else {
			$array[$originPos] = $originVal;
		}

	}

	#
	## If move is invalid, tell user
	#

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

	$tileSelect = rand (0, count($tileEntryOptions)-1);
	$tile = $tileEntryOptions[$tileSelect];
	$array[$tile] = $nextNum;


	#===============
	# FINISH HIM!!!
	#===============
	
	printArray($array, $input);
	
	$board = json_encode($array);
	
	return $board;

}

?>

<form action="threes.php" method="POST">
	<input type="submit" action="/threes.php" name="move" value="up" />
	<input type="submit" action="/threes.php" name="move" value="left" />
	<input type="submit" action="/threes.php" name="move" value="right" />
	<input type="submit" action="/threes.php" name="move" value="down" />
	<input type="submit" action="/threes.php" name="seedBoard" value="new game" />
</form>
</body>
