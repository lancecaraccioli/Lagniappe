<?php
require_once ('SudokuVerifier.php');
require_once ('SudokuRenderer.php');
$sudokuVerifier = new SudokuVerifier();
$sudokuRenderer = new SudokuRenderer();
$validModel = array(
	array(6,7,2,1,4,5,3,9,8),
	array(1,4,5,9,8,3,6,7,2),
	array(3,8,9,7,6,2,4,5,1),
	array(2,6,3,5,7,4,8,1,9),
	array(9,5,8,6,2,1,7,4,3),
	array(7,1,4,3,9,8,5,2,6),
	array(5,9,7,2,3,6,1,8,4),
	array(4,2,6,8,1,7,9,3,5),
	array(8,3,1,4,5,9,2,6,7)
);

$isValid = $sudokuVerifier
	->setModel($validModel)
	->verify();
	
?>
<fieldset>
	<legend>"Valid Sudoku" Test Results</legend>
	<?=$sudokuRenderer->setModel($validModel)->render();?>
	<?if($isValid):?>
		<p>Valid</p>
	<?else:?>
		<p>Invalid</p>
	<?endif;?>
</fieldset>

<?
$invalidModel = array(
	array(6,7,2,1,4,5,3,9,8),
	array(1,4,5,9,8,3,6,7,2),
	array(3,8,9,7,6,2,4,5,1),
	array(2,6,3,5,7,4,8,1,9),
	array(9,5,8,6,2,1,7,4,3),
	array(7,1,4,3,9,8,5,2,6),
	array(5,9,7,2,3,6,1,8,4),
	array(4,2,6,8,1,7,9,3,5),
	array(8,3,1,4,5,9,2,6,6)
);

$isValid = $sudokuVerifier
	->setModel($invalidModel)
	->verify();
	
?>
<fieldset>
	<legend>"Invalid Sudoku" Test Results</legend>
	<?=$sudokuRenderer->setModel($invalidModel)->render();?>
	<?if($isValid):?>
		<p>Valid</p>
	<?else:?>
		<p>Invalid</p>
	<?endif;?>
</fieldset>

<?
$exceptionModel = array(
	array(7,2,1,4,5,3,9,8),
	array(1,4,5,9,8,3,6,7,2),
	array(3,8,9,7,6,2,4,5,1),
	array(2,6,3,5,7,4,8,1,9),
	array(9,5,8,6,2,1,7,4,3),
	array(7,1,4,3,9,8,5,2,6),
	array(5,9,7,2,3,6,1,8,4),
	array(4,2,6,8,1,7,9,3,5),
	array(8,3,1,4,5,9,2,6,7)
);

$message = "No exception was caught";
try {
	$isValid = $sudokuVerifier
		->setModel($exceptionModel)
		->verify();
}
catch(Exception $e){
	$message = $e->getMessage();
}
	
?>
<fieldset>
	<legend>"Exception Sudoku" Test Results</legend>
	<?=$sudokuRenderer->setModel($exceptionModel)->render();?>
	<?if($isValid):?>
		<p>Valid</p>
	<?else:?>
		<p>Invalid</p>
	<?endif;?>
	<p><?=$message;?></p>
</fieldset>