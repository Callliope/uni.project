<?php
    require_once ('connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Результат:</h1>

    <?php
        $city = $_POST ['city'];
        $military = $_POST ['military'];
        $subjects = $_POST ['subject'];
        $base = $_POST ['base'];

        // Получим название города по его id
        $city_name_query = pg_query_params ($connect, "SELECT city_name FROM cities WHERE city_id = $1", [$city]);
        $city_name = pg_fetch_assoc ($city_name_query) ["city_name"];

        // Переделаем массив с сокращенными названиями предметов в массив с полными названиями предметов
        $names = [];
        foreach ($subjects as $subject) {
            array_push ($names, $subjects_names [$subject]);
        }
        // Переведем его в json формат
        $str_names = json_encode ($names, JSON_UNESCAPED_UNICODE);
        $str_names = str_replace ("\"", "'", $str_names);

        // Выберем ВУЗы по городу и военной кафедре
        $univers_query = pg_query_params ($connect, "SELECT university_id FROM university WHERE city = $1 AND military = $2", [$city, $military]);
        $univers = pg_fetch_all_columns ($univers_query);
        // Если ВУЗов не нашлось, сообщим об этом пользователю и завершим программу
        if (!$univers) exit ("Ничего не найдено, отсутствуют ВУЗы");
        // Приведем массив с выборкой в порядок
        for ($i = 0; $i < count ($univers); $i ++) {
            $univers [$i] = (int) $univers [$i];
        }
        // Переведем список ВУЗов в json формат
        $str_univers = json_encode ($univers, JSON_UNESCAPED_UNICODE);
        $str_univers = str_replace ("\"", "'", $str_univers);

        // Выберем направления в ВУЗах по предметам и ВУЗам
        $directions_query = pg_query ($connect, "SELECT university_, direction_, subject1, subject2, subject3 FROM subjects
            WHERE subject1 = ANY(ARRAY{$str_names})
            AND subject2 = ANY(ARRAY{$str_names})
            AND
            (subject3 = ANY(ARRAY{$str_names}) OR subject3 IS NULL)
            AND university_ = ANY(ARRAY{$str_univers})");
        $directions = pg_fetch_all ($directions_query);
        // Если направлений не нашлось, сообщим об этом пользователю и завершим программу
        if (!$directions) exit ("Ничего не найдено, отсутствуют направления");

        // Выводили ли мы хотя бы одно направление?
        $ok = false;

        // Проверим, подходит ли нам направление, учитывая наши баллы и основу обучения
        foreach ($directions as $direction) {
            // Посчитаем сумму наших баллов по предметам, которые требуются на это направление
            $score = 0;
            if ($direction ["subject1"]) $score += (int) $_POST [$names_subjects [$direction ["subject1"]]];
            if ($direction ["subject2"]) $score += (int) $_POST [$names_subjects [$direction ["subject2"]]];
            if ($direction ["subject3"]) $score += (int) $_POST [$names_subjects [$direction ["subject3"]]];

            // Проверим, есть ли выбранная основа обучения в базе данных и если нет, то сообщим об этом пользователю и завершим программу
            $isBase_query = pg_query ($connect, "SELECT column_name FROM information_schema.columns WHERE table_name = 'budgetcommerce'");
            $isBase = pg_fetch_all_columns ($isBase_query);
            if (!in_array ("{$base}_score", $isBase)) exit ("Ничего не найдено, отсутствует выбранная основа обучения");
            
            // Получим проходной балл на это направление с учетом нашей основой обучения
            $passing_score_query = pg_query_params ($connect, "SELECT {$base}_score FROM budgetcommerce WHERE university_ = $1 AND direction_ = $2", [$direction ["university_"], $direction ["direction_"]]);
            $passing_score = (int) pg_fetch_assoc ($passing_score_query) ["{$base}_score"];

            // Если наш балл больше проходного, выведем это направление со всей информацией
            if ($score >= $passing_score) {
                echo "Город: " . $city_name . "<br>";

                $univer_query = pg_query_params ($connect, "SELECT university_name FROM university WHERE university_id = $1", [$direction ["university_"]]);
                $univer = pg_fetch_assoc ($univer_query) ["university_name"];
                echo "ВУЗ: " . $univer . "<br>";

                $direction_name_query = pg_query_params ($connect, "SELECT direction_name FROM direction WHERE direction_id = $1", [$direction ["direction_"]]);
                $direction_name = pg_fetch_assoc ($direction_name_query) ["direction_name"];
                echo "Направление: " . $direction_name . "<br>";

                echo "Военная кафедра: ";
                if ($military == "TRUE") echo "есть";
                else if ($military == "FALSE") echo "нет";
                echo "<br>";

                echo "Минимальный проходной балл: " . $passing_score . "<br>";
                echo "Ваш балл: " . $score . "<br><br>";

                $ok = true;
            }
        }

        // А если меньше, выведем пользователю сообщение о том, что ничего не найдено (при том условии, что еще ничего не выводили)
        if (!$ok) echo "Ничего не найдено, не хватает баллов";
    ?>
    <div class="row">
                <div class="col-md-5 mb-3">
                    <button class="btn btn-light btn-lg btn-block">Отправить результат на почту</button>
                </div>
                <div class="col-md-5 mb-3">
                    <button class="btn btn-light btn-lg btn-block">Скачать результат в формате PDF</button>
                </div>
            </div>

</body>

</html>