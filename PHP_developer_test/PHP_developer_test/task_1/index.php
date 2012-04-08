<?php
/*
* Start: 10:30pm
* End: 11:50pm
* Problem: Largest repeated subset. Find the longest repeated subset of array elements in given array. For 
* example, for array('b','r','o','w','n','f','o','x','h','u','n','t','e','r','n','f','o','x','r','y','h','u','n') the longest repeated 
* subset will be array('n','f','o','x').
*
* Solution: Exaughstive exploration of subset space... generate all subsets, count them, determine the longest set that is repeated
*/
$set = array('b','r','o','w','n','f','o','x','h','u','n','t','e','r','n','f','o','x','r','y','h','u','n');
$subsets = array();

//generate all subsets
for ($j=0; $j < count($set); $j++){
	for ($i=$j; $i < count($set); $i++){
		$subset = implode('',array_slice($set, $j, $i-$j+1));
		$subsets[] = $subset;
	}
}

//count subsets
$subsetCounts = array();
foreach($subsets as $subset){
	//to avoid notices... alternatively change error reporting to ignore notices depending on conventions
	$subsetCounts[$subset] = isset($subsetCounts[$subset])?$subsetCounts[$subset] + 1:1;
}

//determine the largest subset that is repeated
$largestRepeatingSubset = '';
foreach($subsetCounts as $subset =>$count){
	if ($count > 1){
		if (strlen($subset) > strlen($largestRepeatingSubset)){
			$largestRepeatingSubset = $subset;
		}
	}
}
echo('<pre>');
var_dump($largestRepeatingSubset);
echo('</pre>');