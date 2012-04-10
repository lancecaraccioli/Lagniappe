<?php
class SudokuRenderer{
	protected $_model = null;
	
	/*
	* This sets the model which sould be a 9X9 2d array.  First we verify that it is in fact 9X9 then we massage the arrays to insure they are numerically indexed and that there indexes are sequential
	* Doing this allows us to illiminate messy checks later in the methods that retrieve the rows, columns, and cells
	*/
	public function setModel($model){
		if (!is_array($model)){
			throw new Exception("The sudoku board being verified must be a 2 dimensional php array with 9 columns and 9 rows");
		}
		if (count($model) != 9 ){
			throw new Exception("The sudoku board being verified does not contain 9 rows");
		}
		//ensure numerically sequential indexing
		$model = array_values($model);
		foreach ($model as $key=>$row){
			if (!is_array($row)){
				throw new Exception("The row being verified is not a php array");
			}
			if (count($model) != 9 ){
				throw new Exception("The row being verified does not contain 9 columns");
			}
			//insure numerically sequential indexing
			$model[$key]=array_values($row);
		}
		$this->_model = $model;
		return $this;
	}
	
	public function getModel(){
		if (!$this->_model){
			throw new Exception('You must first specify a 9X9 2d array that represents a board configuration of a sudoku board by passing that array to setModel');
		}
		return $this->_model;
	}
	
	public function render(){
		ob_start();
		?><table><?
		foreach ($this->getModel() as $row){
			?><tr><?
				foreach ($row as $value){
					?><td><?=$value;?></td><?
				}
			?></tr><?
		}
		?></table><?
		return ob_get_clean();
	}
}