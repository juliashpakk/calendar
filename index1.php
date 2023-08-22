<html>
<head>
<title>Календарь</title>
<style type="text/css">
		hr {
			height: 1px;
			overflow: hidden;
			font-size: 0;
			line-height: 0;
			background: #ccc;
			margin: 50px 0;
			border: 0;
		}

		.b-calendar {
			font: Arial, sans-serif;
            font-size: 18px;
			background: #f2f2f2;
		}
		.b-calendar--along {
			width: 300px;
			padding: 15px 40px;
			margin: 50px auto;
		}
		.b-calendar--many {
			padding: 20px;
			width: 250px;
			display: inline-block;
			vertical-align: top;
			margin: 0 20px 20px;
		}
		.b-calendar__title {
			text-align: center;
			margin: 0 0 20px;
		}
		.b-calendar__year {
            font-size: 18px;
			font-weight: bold;
			color: #333;
		}
		.b-calendar__tb {
			width: 100%;
		}
		.b-calendar__head {
			font: Arial, sans-serif;
            font-size: 18px;
			padding: 5px;
			text-align: left;
			border-bottom: 1px solid #c0c0c0;
		}
		.b-calendar__np {
			padding: 5px;
		}
		.b-calendar__day {
			font: Arial, sans-serif;
            font-size: 18px;
			padding: 8px 5px;
			text-align: left;
		}
		.b-calendar__weekend {
			color: red;
		}
	</style>
</head>
<body>
<?php
function draw_calendar($month=6, $year=2023) {
	$calendar = '<table cellpadding="0" cellspacing="0" class="b-calendar__tb">';
    if(!$month==6 || !$year==2023){
        echo date('F Y ', strtotime("now"));

    }else{
        $monthName = date('F', mktime(0, 0, 0, $month, 10));
        echo "<p style='text-align:center; font-weight:bold; font-size:20px'>" .$monthName." ".$year. "</p>";
    }

	// вывод дней недели
	$headings = array('Пн','Вт','Ср','Чт','Пт','Сб','Вс');
	
	for($head_day = 0; $head_day <= 6; $head_day++) {
		$calendar.= '<th class="b-calendar__head';
		// выделяем выходные дни
		if ($head_day != 0) {
			if (($head_day % 5 == 0) || ($head_day % 6 == 0)) {
				$calendar .= ' b-calendar__weekend';
			}
		}
		$calendar .= '">';
		$calendar.= '<div>'.$headings[$head_day].'</div>';
		$calendar.= '</th>';
	}
	$calendar.= '</tr>';

	// выставляем начало недели на понедельник
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$running_day = $running_day - 1;
	if ($running_day == -1) {
		$running_day = 6;
	}
	
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$day_counter = 0;
	$days_in_this_week = 1;
	
	// первая строка календаря
	$calendar.= '<tr>';
	
	// вывод пустых ячеек
	for ($x = 0; $x < $running_day; $x++) {
		$calendar.= '<td class="b-calendar__np"></td>';
		$days_in_this_week++;
	}
	
	// дошли до чисел, будем их писать в первую строку
	for($list_day = 1; $list_day <= $days_in_month; $list_day++) {
		$calendar.= '<td class="b-calendar__day';

		// выделяем выходные дни
		if ($running_day != 0) {
			if (($running_day % 5 == 0) || ($running_day % 6 == 0)) {
				$calendar .= ' b-calendar__weekend';
			}
		}
		if(($list_day==1 || $list_day==2 || $list_day==7) && $month==1){
			$calendar .= ' b-calendar__weekend';
		}
		if(($list_day==8) && $month==3){
			$calendar .= ' b-calendar__weekend';
		}
		if(($list_day==25) && $month==4){
			$calendar .= ' b-calendar__weekend';
		}
		if(($list_day==1 || $list_day==9) && $month==5){
			$calendar .= ' b-calendar__weekend';
		}
		if(($list_day==3) && $month==7){
			$calendar .= ' b-calendar__weekend';
		}
		if(($list_day==7) && $month==11){
			$calendar .= ' b-calendar__weekend';
		}
		if(($list_day==25) && $month==12){
			$calendar .= ' b-calendar__weekend';
		}
		


		/*$calendar1 = simplexml_load_file('http://xmlcalendar.ru/data/ru/'.date($year).'/calendar.xml');

$calendar1 = $calendar1->days->day;
$array1=array();
$in=0;
//все праздники за текущий год
foreach( $calendar1 as $day1 ){
	$d = (array)$day1->attributes()->d;
	$d = $d[0];
	$d = substr($d, 3, 2).'.'.substr($d, 0, 2).'.'.date('Y');
	echo substr($d, 3, 2);
	if(substr($d, 0, 2)==$month){
    $array1[$in]=substr($d, 3, 2);
	$in++;
	}
	}
print_r($array1);
for($aa=0; $aa<count($array1); $aa++){
	if($list_day==$array1[$aa]){
		$calendar .= ' b-calendar__weekend';
	}
}*/
		
		$calendar .= '">';


		// пишем номер в ячейку
		$calendar.= '<div>'.$list_day.'</div>';
		$calendar.= '</td>';

		// дошли до последнего дня недели
		if ($running_day == 6) {
			// закрываем строку
			$calendar.= '</tr>';
			// если день не последний в месяце, начинаем следующую строку
			if (($day_counter + 1) != $days_in_month) {
				$calendar.= '<tr>';
			}
			// сбрасываем счетчики 
			$running_day = -1;
			$days_in_this_week = 0;
		}

		$days_in_this_week++; 
		$running_day++; 
		$day_counter++;
	}

	// выводим пустые ячейки в конце последней недели
	if ($days_in_this_week < 8) {
		for($x = 1; $x <= (8 - $days_in_this_week); $x++) {
			$calendar.= '<td class="b-calendar__np"> </td>';
		}
	}
	$calendar.= '</tr>';
	$calendar.= '</table>';

	return $calendar;
}
?>
<div class="b-calendar b-calendar--along">	
	<?
		echo draw_calendar(3, 2023);
	?>
</div>
</body>
</html>