<?php
class SudokuVerifier{
	protected $_model = null;
	
	/*
	* This sets the model which sould be a 9X9 2d array.  First we verify that it is in fact 9X9 then we massage the arrays to insure they are numerically indexed and that theire indexes are sequential
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
				throw new Exception("The row being verified is not an array");
			}
			if (count($row) != 9 ){
				throw new Exception("The row being verified (row ".($key+1).") does not contain 9 columns");
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
	
	public function verify(){
		//rows, columns, and cells can all be indexed 0-8 because there are 9 of each... 
		for($i=0;$i<9; $i++){
			if(!$this->verifyList($this->getRow($i))){
				return false;
			}
			if (!$this->verifyList($this->getColumn($i))){
				return false;
			}
			if(!$this->verifyList($this->getCell($i))){
				return false;
			}
		}
		return true;
	}
	
	public function verifyList($list){
		$checklist = array_fill_keys(array(1,2,3,4,5,6,7,8,9), false);
		foreach($list as $key=>$value){
			$checklist[$value]=true;
		}
		return !in_array(false, $checklist);		
	}
	
	public function getRow($index){
		$model = $this->getModel();
		$row = $model[$index];
		return $row;
	} 
	
	public function getColumn($index){
		$model = $this->getModel();
		$column = array();
		foreach ($model as $row){
			$column[]=$row[$index];
		}
		return $column;
	}
	
	public function getCell($index){
		$model = $this->getModel();
		$rowMultiplier = floor(($index)/3) ;
		$columnOffset = (($index)%3)*3;
		$cell = array();
		for($row=0;$row<3;$row++){
			$segment = array_slice($model[(3*$rowMultiplier)+$row], $columnOffset, 3);
			$cell = array_merge($cell, $segment);
		}
		return $cell;
	}
}