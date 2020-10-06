<?php
const INPUT_COUNT = 2;
?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
	<title>Lab_2</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="lab2.css">
	<meta name="variant" content="4">
	<meta name="description" content="Создайте 2 массива с целыми числами через 2 поля формы, объедините два 
	массива в один (не используя специальные функции PHP типа array_merge(arr1,arr2)!), Выведите все чётные 
	числа из получившегося массива.">

</head>

<body>
	 <!--- 
	 html form with dinamic input create
	 number of inputs depend of INPUT_COUNT value
	 --->
	<form class="" action="lab2.php" method="post">
		<?php
		$present_post = isset($_POST['values']);
		for ($i = 0; $i < INPUT_COUNT; $i++) {
			echo '<span class="intro-text"><a>Массив_' . ($i + 1) . '</a></span>';
			echo '<input class="input-field" type="text" name="values[] "';
			if ($present_post) {
				echo 'value="'  . $_POST['values'][$i] .  '"';
			}
			echo "><br>";
		}
		?>

		<button class="button-submit" type="submit" name="btn"> Submit</button>

	</form>

	<p>
		<?php
		//function to output 1-dimensional array
		function printArray($arr)
		{	
			//collapse array to string and output it
			echo '<br>' . implode(", ", $arr);
		}
		//function that output even numbers from 1-dimensional array
		function printEvenArray($arr)
		{
			$output_str = "";
			//enumeration numbers in array
			foreach ($arr as $val) {
				//parity check
				if ($val % 2 == 0) {
					$output_str .= ", $val";
				}
			}
			//output
			if (empty($output_str)) {
				echo '<br>' . "Результирующий массив не содержит чётных чисел";
			} else {
				echo '<br>' . 'Чётные элементы:';
				$output_str = trim($output_str, " ,");
				echo '<br>' . $output_str;
			}
		}
		//function to validate input
		function checkInput($string): bool
		{

			/*it is parser that have 6 states stError stBegin stNumber stDelimiter  stSign  stSpace 
			trim is used to avoid spaces at beggin and the end of string
			*/
			$string = trim($string);
			//array of parser states
			$states = array([0, 0, 0, 0, 0, 0], [0, 0, 2, 0, 4, 1], [0, 0, 2, 3, 0, 5], [0, 0, 2, 0, 4, 3], [0, 0, 2, 0, 0, 0], [0, 0, 0, 3, 0, 5]);
			//start state
			$now = 1;

			for ($i = 0, $j = strlen($string); $i < $j; $i++) {
				switch (true) {
					//check digit
					case (($string[$i] >= '0') && ($string[$i] <= '9')):
						$now = $states[$now][2];
						break;
					//check delimiter
					case $string[$i] == ',':
						$now = $states[$now][3];
						break;
					//check sing
					case ($string[$i] == '-'):
						//case (($string[$i] == '-')||($string[$i] == '+')):
						$now = $states[$now][4];
						break;
					//check space
					case ($string[$i] == ' '):
						$now = $states[$now][5];
						break;
					//other chars
					default:
						$now = $states[$now][0];
				}
			}
			//end state should be a number(2)
			return	$now == 2;
		}


		if ($present_post) {
			//$arrays[array of array] is array for storage arrays,gets from POST 
			$arrays = array();
			//validate data from input`s
			for ($i = 0; $i < INPUT_COUNT; $i++) {
				if (!checkInput($_POST['values'][$i])) {
					echo "Ошибка ввода в массиве №" . ($i + 1) . ".Пожалуйста вводите массив в формате \"число,число...\"" . '<br>';
					exit;
				} else {
					//delete ' ' from string and get array from string 
					$arrays[$i] = str_getcsv(str_replace(' ', '', $_POST['values'][$i]), ",");
				}
			}
			//merge all arrays (copy values) to first array (to array[0])
			for ($i = 1; $i < INPUT_COUNT; $i++) {
				foreach ($arrays[$i] as $value) {
					$arrays[0][] = $value;
				}
			}
			//output result
			echo 'Объединённый массив:';
			printArray($arrays[0]);
			printEvenArray($arrays[0]);
		}
		?>
	</p>
</body>

</html>