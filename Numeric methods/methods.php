<?php

// the list of error in json file
// $errorList = file_get_contents('error_list.json');
// $errorList = json_decode($errorList);

// класс метода
class Method
{
    public $name;
    public $x;
	public $y;
    public $iterations;
    public $workTime;
	public $comment = "Success";
    private $startTime;
    private $endTime;
	private $errorList;
	private $overload = 10000;
    

    public function __construct($name)
    {
		$this->errorList = file_get_contents('error_list.json');
		$this->errorList = json_decode($this->errorList);
        $this->name = $name;
    }
    public function getAnswer()
    {    
        global $Data;				
        $f = $this->name;
		$this->iterations = 0;
        $this->startTime = microtime(true);

		$format = "%." . $this->format($Data->accuracy) . "f";

        $this->x =  $this->$f($Data->a, $Data->b, $Data->accuracy);

		if($this->x === "Error")
        	$this->y = "Error";
		else
		{
			$this->y = sprintf( $format ,  equate($this->x));
			$this->x =  sprintf( $format  , $this->x);
		}



        $this->endTime = microtime(true);
        $this->workTime = ($this->endTime - $this->startTime)/60 ;
		$this->workTime = sprintf( "%." . $this->format($this->workTime) . "f" , $this->workTime);
		
        return $this->x;
    }




// DIHOTOMY
	// function dichotomyMethod($a, $b, $accuracy)
	// {
	// 	while (abs($b - $a)> $accuracy)
	// 	{
		

	// 		$c = ($a + $b) / 2;
	// 		if(equate($b) * equate($c) <= 0)
	// 			$a = $c;
	// 		else
	// 			$b = $c;
	// 		$this->iterations++;
			
	// 		if($this->iterations > $this->overload)
	// 		{					
	// 				$this->comment = $this->errorList[2]->text;//1- функция не определена	
	// 				return "Error";				
	// 		}

	// 		if (is_nan( $c)==1 )
	// 		{					
	// 				$this->comment = $this->errorList[0]->text;//1- функция не определена	
	// 				return "Error";				
	// 		}
	// 	}	
	// 		if (is_nan( equate($c))==1 )
	// 		{					
	// 				$this->comment = $this->errorList[0]->text;//1- функция не определена	
	// 				return "Error";				
	// 		}





	// 	return $c;


	// }

// HORD
	// function hordMethod($a, $b, $accuracy)
		// {
		// 	while(abs($b-$a)>$accuracy)
		// 	{
		// 		if ( is_nan( equate($b)*equate($a)) == 0)
		// 		{
		// 			if  ((equate($b) - equate($a)) != 0 ) 
		// 			{					
		// 				$a = $b - ($b - $a) * equate($b)/(equate($b) - equate($a));
		// 				if ((equate($a) - equate($b)) !=0)
		// 				{
		// 					$b = $a - ($a - $b) * equate($a)/(equate($a) - equate($b));
		// 					$this->iterations++;
		// 				}	
						
		// 				else
		// 				{
		// 					$this->comment = $this->errorList[1]->text;//1- функция не определена				
		// 					return "Error";	
		// 				}
		// 			}
		// 			else
		// 			{
		// 				$this->comment = $this->errorList[1]->text;//1- функция не определена				
		// 				return "Error";			
		// 			}
		// 		}
		// 		else
		// 			{
		// 				$this->comment = $this->errorList[0]->text;//1- функция не определена				
		// 				return "Error";			

		// 			}
		// 		if($this->iterations > $this->overload)
		// 		{					
		// 				$this->comment = $this->errorList[2]->text;//1- функция не определена	
		// 				return "Error";				
		// 		}
		// 	}
				
		// 	if (is_nan( $b)==1 )
		// 	{					
		// 			$this->comment = $this->errorList[0]->text;//1- функция не определена	
		// 			return "Error";				
		// 	}
			

		// 	return $b;
		// }

	function hordMethod($a, $b, $accuracy)
	{
		$a = $a;
		$b = $b;
		$c = 0;
		$f_a = equate($a);
		$f_b = equate($b);
		$f_c = 0;
		
		if( $f_a * $f_b > 0)
		{
			$this->comment = $this->errorList[3]->text;// нет корней или четные
			return "Error";	
		}
		else
		{
			$c1 = 0;
			do
			{
				$this->iterations++;
				$c1 = $c;
				$f_a = equate($a);

				if ($f_b - $f_a == 0)
				{
					$this->comment = $this->errorList[1]->text;
					return "Error";	
				}

				$c = $a - ($f_a * ($b - $a) / ($f_b - $f_a));

				if (($b-$a) < 2 * $accuracy)
				{
					return $c;
				}
				else if(abs($c1 - $c) < 0.0000000001 * $accuracy)
				{
					return $c;
				}
				else
				{
					$f_c = equate($c);
					if($f_c == 0)
					{
						return $c;
					}
					else if ($f_a * $f_c < 0)
						$b = $c;
					else if ($f_a * $f_c > 0)
						$a = $c;
				}
				if($this->iterations > $this->overload)
				{					
					$this->comment = $this->errorList[2]->text;//1- функция не определена	
					// $this->comment = $a . " | " . $b;
					return "Error";				
				}	
			} while (($b-$a) > 2* $accuracy);
		}

		
	}


// NEWTON
	// function methodOfTangents($a, $b, $accuracy)
	// {
	// 	if (equate($b) * $this->derivative($b,$accuracy,2) <0) 
	// 	{
	// 		$c = $a;
	// 		//$x=$b;
	// 	}
	// 	else 
	// 	{
	// 		$c = $b;
	// 		//$x=$a;
	// 	}
	// 	do
	// 	{	
	// 		$f1=equate($c);
	// 		$f2=$this->derivative($c);
	// 		// echo "$f2";
	// 		if(is_nan($f1*$f2)==0)
	// 		{
	// 			if($f2==0)
	// 			{
	// 				$this->comment = $this->errorList[1]->text;//1- функция не определена
	// 				return "Error";	
	// 			}
	// 			$c = $c - $f1/ $f2;
	// 			$this->iterations++;
	// 		}
	// 		else
	// 		{
	// 			$this->comment = $this->errorList[0]->text;//1- функция не определена
	// 			return "Error";			
	// 		}
	// 		if($this->iterations > $this->overload)
	// 		{					
	// 				$this->comment = $this->errorList[2]->text;//1- функция не определена	
	// 				return "Error";				
	// 		}

	// 		if (is_nan( $c)==1 )
	// 		{					
	// 				$this->comment = $this->errorList[0]->text;//1- функция не определена	
	// 				return "Error";				
	// 		}

	// 	}while (abs(equate($c))>$accuracy);

	// 	return $c;
	// }

// SECANT
	// function secantMethod($a, $b, $accuracy)
	// {
	// 	$c = null;
	// 	while(abs($a-$b)>$accuracy)
	// 	{
	// 		$f1= equate($a);
	// 		$f2= equate($b);
	// 		$r= is_nan($f2-$f1);
	// 		if($r == 0 )
	// 		{
	// 			if($f2-$f1!=0)
	// 			{
	// 			$c=($a*$f2-$b*$f1)/($f2-$f1);

	// 		// echo " c is: $c";

	// 			// a equate(b) - b equate(a)
	// 			//-----------------
	// 			//	equate(b) - equate(a)

	// 			if (is_nan( $c)==1 )
	// 			{					
	// 				$this->comment = $this->errorList[0]->text;//1- функция не определена	
	// 				return "Error";				
	// 			}
	// 			$a=$b;
	// 			$b=$c;
	// 			$this->iterations++;
	// 			}
	// 			else
	// 			{
	// 				$this->comment = $this->errorList[1]->text;//1- функция не определена			
	// 				return "Error";	
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$this->comment = $this->errorList[0]->text;//1- функция не определена			
	// 			return "Error";	
	// 		}
	// 		if($this->iterations > $this->overload)
	// 		{					
	// 			$this->comment = $this->errorList[2]->text;//1- функция не определена	
	// 			return "Error";				
	// 		}
	// 	}
	// 	return $c;
	// }



// HYBRID

		function hybridMethod($a, $b, $accuracy)
			{
				$f_a = equate($a);
				$f_b = equate($b);
				if( $f_a * $f_b > 0)
				{
					$this->comment = $this->errorList[3]->text;// нет корней или четные
					return "Error";	
				}
				else
				{
					$startInterval = $a;
					$endInterval = $b;
					$xs = [];
					$flag = false;
					$i = 0;
			//step 1
					for ($i=0; $i < 2; $i++) { 
			//step 2
						$xs[$i] = ($a + $b)/2;
						$this->iterations++;
			//step 3
						if (equate($xs[$i]) < $accuracy)
						{
							$flag = true;
							$i++;
							break;
						}
						else
						{
			// step 4
							if ( equate($a)*equate($xs[$i]) < 0)
								$b = $xs[$i];
			// step 5
							else
								$a = $xs[$i];
						}
					}
			// step 6 - end for
					$i--;
			// step 7
					$der = $this->derivative($xs[$i], $accuracy);
					if ($der == 0)
					{
						$this->comment = $this->errorList[1]->text;//1- функция не определена	
						return "Error";				
					}
					else
					$t = $xs[$i] - equate($xs[$i]) / $der;

					if($t > $endInterval || $t < $startInterval)
					{
						$this->comment = $this->errorList[0]->text;//1- функция не определена	
						return "Error";					
					}

			// step 8			
					while( abs(equate($t)) > $accuracy )
					{
						$xs[$i] = $t;

						$der = $this->derivative($xs[$i], $accuracy);
						if ($der == 0)
						{
							$this->comment = $this->errorList[1]->text;//1- функция не определена	
							return "Error";				
						}
						else
						{
							$t = $xs[$i] - equate($xs[$i]) / $der;
							$this->iterations++;
							if($t > $endInterval || $t < $startInterval)
							{
								$this->comment = $this->errorList[0]->text;//1- функция не определена	
								return "Error";					
							}
						}
						if($this->iterations > $this->overload)
						{					
								$this->comment = $this->errorList[2]->text;//1- функция не определена	
								return "Error";				
						}	
					}
					return $t;
				}
			}

// function hybridMethod($a, $b, $accuracy)
	// {
	// 	$c = 0;
	// 	$f_a = equate($a);
	// 	$f_b = equate($b);
	// 	$der = 0;
	// 	$XX = 0;
	// 	$xk1 = 0;
	// 	$xk = $b;
		
		
	// 	if( $f_a * $f_b > 0)
	// 	{
	// 		$this->comment = $this->errorList[3]->text;// нет корней или четные
	// 		return "Error";	
	// 	}
	// 	else
	// 	{
	// 		do
	// 		{
	// 			$this->iterations++;
	// 			$c = $xk;
	// 			$der = $this->derivative($xk, $accuracy/10);
	// 			if ($der==0)
	// 			{
	// 				$this->comment = $this->errorList[1]->text;	// division by zero
	// 				return "Error";						
	// 			}
	// 			$XX = $xk - equate($xk) / $der;
	// 			do
	// 			{
	// 				$this->iterations++;
	// 				if( abs(equate($XX)) < abs(equate($xk)) )
	// 				{
	// 					$xk1 = $xk;
	// 					// $xk1 = $XX;
	// 					break;
	// 				}
	// 				else
	// 				{
	// 					$XX = 0.5 * ($xk + $XX);
	// 				}

	// 			// if($this->iterations > $this->overload)
	// 			// {					
	// 			// 		$this->comment = $this->errorList[2]->text;//1- функция не определена	
	// 			// 		return "Error";				
	// 			// }	

	// 			}while(true);
	// 			$xk = $xk1;

	// 			if($this->iterations > $this->overload)
	// 			{					
	// 					$this->comment = $this->errorList[2]->text;//1- функция не определена	
	// 					return "Error";				
	// 			}	

	// 		}while(abs(equate($xk1)) > $accuracy);
	// 		// }while(abs($c - $xk1) > $accuracy);

	// 		return $xk1;
	// 	}
	// }

//

//new
function dichotomyMethod($a,$b,$eps)
	{
		$eps = $eps/10;
		 if(equate($a)*equate($b)>0)
		 {
			$this->comment = $this->errorList[3]->text;// нет корней или четные 			
			return "Error";			 	
		 }
		 else
	 {
		 	$c=0;
		 	
		 	do
		 	{
		 		$this->iterations++;
		 		if($this->iterations > $this->overload)
				{
					$this->comment = $this->errorList[2]->text;//1- функция не определена 
					return "Error"; 
				}
		 		$c=($a+$b)/2;
		 		if(($b-$a)<2*$eps)
		 		{
		 			$res=$c;
		 			break;
		 		}
		 		else
		 		{
		 			if(equate($c)==0)
		 			{
		 				$res=$c;
		 				break;
		 			}
		 			else if(equate($a)*equate($c)<0)
		 				$b=$c;
		 			else if(equate($a)*equate($c)>0)
		 				$a=$c;
		 		}
		 	}
		 	while(($b-$a)>2*$eps||equate($a)!=0);
		 	// while(equate($a) < $eps);

		 }
		 return $res;
	}


function secantMethod($a,$b,$eps)
	{
		$c = $b;
             if (equate($a) * equate($b) > 0)
            {
				$this->comment = $this->errorList[3]->text;// нет корней или четные 			
				return "Error";	
            }
            else
         {
	
			if (equate($b) * $this->derivative2($b,$eps) > 0)
			{
				$c = $b;
				$v=$b;
			} 
			else if (equate($a) * $this->derivative2($a,$eps) > 0)
			{
				$c = $a;
				$v=$a;
			}
			else 
			{
				$this->comment = $this->errorList[4]->text;// нет корней или четные 			
				return "Error";						
			}
			do
			{	
				if($this->derivative($c,$eps)==0)
				{
					$this->comment = $this->errorList[1]->text; // division by zero
					return "Error";
				}
				$c = $c - equate($c) / $this->derivative($v,$eps);
				$this->iterations++;
				if($this->iterations > $this->overload)
				{
					$this->comment = $this->errorList[2]->text;//1- функция не определена 
					return "Error"; 
				}
			} while (abs(equate($c))>$eps);
			return $c;
		 }
		}

function methodOfTangents($a,$b,$eps)
		{
		$c = $b;
             if (equate($a) * equate($b) > 0)
            {
				$this->comment = $this->errorList[3]->text;// нет корней или четные 			
				return "Error";	
            }
            else 
         {

			if (equate($b) * $this->derivative2($b,$eps) >0) 
				$c = $b;
			else if (equate($a) * $this->derivative2($a,$eps) >0)
				$c = $a;
				else {
				$this->comment = $this->errorList[4]->text;// нет корней или четные 			
				return "Error";						
				}
			do
			{	
				if($this->derivative($c,$eps)==0)
				{
					$this->comment = $this->errorList[1]->text; // division by zero
					return "Error";
				}
				$c = $c - equate($c) / $this->derivative($c,$eps);
				$this->iterations++;
				if($this->iterations > $this->overload)
				{
					$this->comment = $this->errorList[2]->text;//1- функция не определена 
					return "Error"; 
				}
			} while (abs(equate($c))>$eps);
			return $c;
		 }
		}

//
	function format($accuracy)
	{
		for ($i=1; $accuracy < 1; $i++) { 
			$accuracy *= 10;
		}
		return $i;
	}


	function derivative($a, $accuracy=0.5, $degree=1)
	{
		if($degree == 1)
			return (equate($a+$accuracy)-equate($a))/$accuracy;
		return ($this->derivative($a+$accuracy, $accuracy, $degree-1)-$this->derivative($a, $accuracy, $degree-1))/$accuracy;
	}

		function derivative2($x, $eps) 
	{	
	return (equate($x + $eps) - 2 * equate($x) + equate($x - $eps)) / pow($eps, 2);
}


	// $a=-5;
	// $b=5;
	// $accuracy=0.1;
	// $c=dichotomyMethod($a, $b, $accuracy);
	// echo "dichotomyMethod $c  | " . equate($c). "<br/>";
	// $c=secantMethod($a, $b, $accuracy);
	// echo "secantMethod $c  | " . equate($c). "<br/>";
	// $c=methodOfTangents($a, $b, $accuracy);
	// echo "methodOfTangents $c | " . equate($c). "<br/>";
	// $c = hordMethod($a,$b,$accuracy);
	// echo "hordMethod $c | " . equate($c). "<br/>";
	// $c = hybridMethod($a,$b,$accuracy);
	// echo "hybridMethod $c | " . equate(abs($c)). "<br/>";
	
}
?>