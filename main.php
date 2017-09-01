<?php

//Usage $dateTime = date_validator($someDateObject);
//This will basically take date time objects of various formats (mm-dd-yyyy, yyyy-mm-dd, dd-mm-yyyy)
//It will output them all in mysql datetime format so it's convenient for date validation for databases

function isYear($var) {
	if (strlen($var) === 4) {
		return $var;
	}
}

function date_validator($dateItem) {
	$allDates = array();
	if (!is_array($dateItem)) {
		$test[] = $dateItem;
	} elseif (is_array($dateItem)) {
		foreach ($dateItem as $p) {
			$test[] = $p;
		}
	}
	foreach ($test as $item) {
		$datesArray = array();
		$elements = explode(' ', $item);
		foreach ($elements as $element) {
			if (stripos($element, '-')) {
					$date = rtrim($element);
					$yearChecker = explode('-', $date);
					$dateCheck = count(explode('-', $date));
				if ($dateCheck === 3) {
					$item = array_filter($yearChecker, "isYear");
					if (key($item) === 2) {
						$datePush['month'] = $yearChecker[0];
						$datePush['day'] = $yearChecker[1];
						$datePush['year'] = $yearChecker[2];
					} elseif (key($item) == 0) {
						$datePush['month'] = $yearChecker[1];
						$datePush['year'] = $yearChecker[0];
						$datePush['day'] = $yearChecker[2];
					}
					$datesArray['date'] = $datePush;
				}
			}
			if (stripos($element, ':')) {
				$time = rtrim($element);
				$timeChecker = explode(':', $time);
				$timeCheck = count(explode(':', $time));
				if ($timeCheck === 3) {
					$timePush['hour'] = $timeChecker[0];
					$timePush['minute'] = $timeChecker[1];
					$timePush['second'] = $timeChecker[2];
				}
				$datesArray['time'] = $timePush;
			}
			if (ctype_alpha($element)) {
				$timezone = rtrim($element);
				$datesArray['timezone'] = $timezone;
			}
		}
		$allDates[] = $datesArray;
	}
	foreach ($allDates as $process) {
		if (isset($process['date'])) {
			$dateObject = $process['date'];
			$passedDate = $dateObject['year'] . "-" . $dateObject['month'] . "-" . $dateObject['day'];
		}
		if (isset($process['time'])) {
			$timeObject = $process['time'];
			$passedTime = $timeObject['hour'] . ":" . $timeObject['minute'] . ":" . $timeObject['second'];
		}
		$dateTimeObject = $passedDate . " " . $passedTime;
		return $dateTimeObject;
	}
}

?>
