<?php
/**
* Verfies that a particular sudoku model contains a correct solution to a sudoku puzzle
*
* @author Lance Caraccioli
* @copyright 2012
*/
class SudokuVerifier{
	protected $_model = null;
	
	/**
	* This sets the model which sould be a 9X9 2d array.  First we verify that it is in fact 9X9 then we massage the arrays to insure they are numerically indexed and that theire indexes are sequential
	* Doing this allows us to illiminate messy checks later in the methods that retrieve the rows, columns, and squares
	*
	* @param $model array 9X9  array representing a sudoku board
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
	
	/**
	* Get the model previously set with {@link setModel()}.  If no model was previously set then throws an exception indicating that a model must first be set before trying to retrieve it.
	* 
	* @throws Exception
	* @return array the sudoku board model
	* 
	*/
	public function getModel(){
		if (!$this->_model){
			throw new Exception('You must first specify a 9X9 2d array that represents a board configuration of a sudoku board by passing that array to setModel');
		}
		return $this->_model;
	}
	
	/**
	* Verify a sudoku model contains a valid solution to the sudoku puzzle.
	*
	* @return bool true if the model is valid false otherwise
	*/
	public function verify(){
		//rows, columns, and squares can all be indexed 0-8 because there are 9 of each... 
		for($i=0;$i<9; $i++){
			if(!$this->verifyList($this->getRow($i))){
				return false;
			}
			if (!$this->verifyList($this->getColumn($i))){
				return false;
			}
			if(!$this->verifyList($this->getSquare($i))){
				return false;
			}
		}
		return true;
	}
	
	/**
	* Verify that a list of values contains the number 1 thru 9
	*
	* This method is nieve and used carelessly by extending classes will return true on lists that contain all the correct values and additional values as well.
	* This argues that the method should be at least protected and that any extensions must be aware of it's nature.
	* 
	* @TODO add sanity checks; to check if $list is an array, to check if $list is the correct size
	* @param $list array is intended to be a list of 9 elements each representing the value of a single cell.  These cells squares theoretically came from a row, column, or square
	*/
	protected function verifyList($list){
		$checklist = array_fill_keys(array(1,2,3,4,5,6,7,8,9), false);
		foreach($list as $key=>$value){
			$checklist[$value]=true;
		}
		return !in_array(false, $checklist);		
	}
	
	/**
	* Method used to retrieve a row specified by it's index
	*
	* @TODO based on the Elance request a single class should be build to verify a suduko board.  Because of this I make the model a simple php array, however refactoring would necessarily move this method into a new class which represents the sudoku board's model as a decoupled entity.
	* @param $index the index of the row which we are trying to retrieve.  From the top to the bottom of the sudoku board is indexed 0-8
	* @return $row array 9 elements representing the values stored in the row specified by $index 
	*/
	public function getRow($index){
		$model = $this->getModel();
		$row = $model[$index];
		return $row;
	} 

	/**
	* Method used to retrieve a column specified by it's index
	*
	* @TODO based on the Elance request a single class should be build to verify a suduko board.  Because of this I make the model a simple php array, however refactoring would necessarily move this method into a new class which represents the sudoku board's model as a decoupled entity.
	* @param $index the index of the column which we are trying to retrieve.  From the left to the right of the sudoku board is indexed 0-8
	* @return $column array 9 elements representing the values stored in the column specified by $index 
	*/	
	public function getColumn($index){
		$model = $this->getModel();
		$column = array();
		foreach ($model as $row){
			$column[]=$row[$index];
		}
		return $column;
	}

	/**
	* Method used to retrieve a square (3X3 grouping of cells) specified by it's index
	*
	* @TODO based on the Elance request a single class should be build to verify a suduko board.  Because of this I make the model a simple php array, however refactoring would necessarily move this method into a new class which represents the sudoku board's model as a decoupled entity.
	* @param $index the index of the square which we are trying to retrieve.  From the left to the right of the sudoku board is indexed 0-8
	* @return $column array 9 elements representing the values stored in the column specified by $index 
	*/	
	public function getSquare($index){
		$model = $this->getModel();
		$rowMultiplier = floor(($index)/3) ;
		$columnOffset = (($index)%3)*3;
		$square = array();
		for($row=0;$row<3;$row++){
			$segment = array_slice($model[(3*$rowMultiplier)+$row], $columnOffset, 3);
			$square = array_merge($square, $segment);
		}
		return $square;
	}
}