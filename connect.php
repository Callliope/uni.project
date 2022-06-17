<?php
	$connect = pg_connect ("host=localhost port=5433 dbname=uniProject user=postgres password=empire51");

	// Массивы для перевода сокращенных названий предметов в полные названия предметов
	$subjects_names = [
	    "math" => "Математика",
	    "informatic" => "Информатика",
	    "physics" => "Физика",
	    "russian" => "Русский язык",
	    "history" => "История",
	    "social" => "Обществознание",
	    "english" => "Английский язык",
	    "literature" => "Литература",
	    "chemistry" => "Химия",
	    "geo" => "География",
	    "biology" => "Биология",
	];
	$names_subjects = [
		"Математика" => "math",
		"Информатика" => "informatic",
		"Физика" => "physics",
		"Русский язык" => "russian",
		"История" => "history",
		"Обществознание" => "social",
		"Английский язык" => "english",
		"Литература" => "literature",
		"Химия" => "chemistry",
		"География" => "geo",
		"Биология" => "biology",
	];
?>