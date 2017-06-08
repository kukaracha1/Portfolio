<?php

	function equate($x)
	{
		return $x*$x*$x-12*$x*$x+5;
	}

	function derivative($a, $accuracy=0.5, $degree=1)
	{
		if($degree == 1)
			return (equate($a+$accuracy)-equate($a))/$accuracy;
		
		return (derivative($a+$accuracy, $accuracy, $degree-1)-derivative($a, $accuracy, $degree-1))/$accuracy;
	}


	// example
	$x=1;
	for($i=0 ; $i<3 ; $i++)
	{
		echo $i+1 . ": ".derivative($x,0.001,$i+1) . " | ";
	}

	//	f(x)	= x^3 + 5x		f(1) = 1 + 5 = 6
	//-------------------------------------------------
	//	f'(x)	= 3x^2 + 5		f'(1) = 3*1 + 5 = 8
	//	f''(x)	= 6x			f''(1) = 6
	//	f'''(x)	= 6				f'''(1) = 6

?>