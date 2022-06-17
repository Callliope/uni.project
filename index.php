<?php
    require_once ('connect.php');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Модуль поиска</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- навбар -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="container-fluid ">
            <img src="free-icon-global-education-3379905.png" alt="" width="25" height="24"
                class="d-inline-block align-text-top">
            <a class="navbar-brand " href="#">Ассистент поступления</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Профориентация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Поиск мест</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- основа -->
    <form action="page2.php" method="POST" target="_blank">
        <div class="container p-4 ">
            <h1>Поиск по всем вузам России</h1>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="city">Выберите город</label>
                    <select class="custom-select d-block w-100" id="city" name="city" required>
                        <option value=""></option>
                        <?php
                            $cities = pg_query ($connect, "SELECT * FROM cities");
                            $cities = pg_fetch_all ($cities);
                            foreach ($cities as $city) {
                                echo "<option value='{$city ['city_id']}'>{$city ['city_name']}</option>";
                            }
                        ?>
                    </select>
                    <!-- <div class="invalid-feedback">
                        Выберите город
                    </div> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="study">Выберите форму обучения</label>
                    <select class="custom-select d-block w-100" id="study">
                        <option value=""></option>
                        <option value="Очная">Очная</option>
                        <option value="Заочная">Заочная</option>
                        <option value="Вечерняя">Вечерняя</option>
                    </select>
                    <!-- <div class="invalid-feedback">
                        Please provide a valid state.
                    </div> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="base">Выберите основу обучения</label>
                    <select class="custom-select d-block w-100" id="base" name="base" required>
                        <option value=""></option>
                        <option value="budget">Бюджет</option>
                        <option value="commerce">Коммерция</option>
                        <option value="target">Целевое</option>
                    </select>
                    <!-- <div class="invalid-feedback">
                        Please provide a valid state.
                    </div> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="study">Выберите предметы ЕГЭ</label>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <input type="checkbox" id="math" name="subject[]" value="math" class="subject-input">
                        <label for="math">Математика</label>
        
                        <input type="checkbox" id="informatic" name="subject[]" value="informatic" class="subject-input">
                        <label for="informatic">Информатика</label>
        
                        <input type="checkbox" id="physics" name="subject[]" value="physics" class="subject-input">
                        <label for="physics">Физика</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <input type="checkbox" id="russian" name="subject[]" value="russian" class="subject-input">
                        <label for="russian">Русский язык</label>
        
        
                        <input type="checkbox" id="history" name="subject[]" value="history" class="subject-input">
                        <label for="history">История</label>
        
                        <input type="checkbox" id="social" name="subject[]" value="social" class="subject-input">
                        <label for="social">Обществознание</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <input type="checkbox" id="english" name="subject[]" value="english" class="subject-input">
                        <label for="english">Английский язык</label>
        
                        <input type="checkbox" id="literature" name="subject[]" value="literature" class="subject-input">
                        <label for="literature">Литература</label>
        
                        <input type="checkbox" id="chemistry" name="subject[]" value="chemistry" class="subject-input">
                        <label for="chemistry">Химия</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <input type="checkbox" id="geo" name="subject[]" value="geo" class="subject-input">
                        <label for="geo">География</label>
        
                        <input type="checkbox" id="biology" name="subject[]" value="biology" class="subject-input">
                        <label for="biology">Биология</label>
        
                    </div>
                </div>
                <!-- <div class="invalid-feedback">
                    Please provide a valid state.
                </div> -->
            </div>
            <!-- <div class="row">
                <div class="col-md-5 mb-3">
                    <button type="button" class="btn btn-light" onclick="showinput()">Ввести баллы</button>
                </div>
            </div> -->

            <?php
                foreach ($subjects_names as $subject => $name) {
                    echo
                    "<div class='row row-block inactive' id='{$subject}block'>
                        <div class='col-md-5 mb-3'>
                            <label for='mathinput' class='col-md-5'>Введите кол-во баллов по предмету '{$name}'</label>
                            <input class='form-control' type='text' id='{$subject}input' placeholder='100' name='{$subject}'>
                        </div>
                    </div>";
                }
            ?>

            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="city">Наличие военной кафедры</label>
                    <select class="custom-select d-block w-100" id="military" name="military" required>
                        <option value=""></option>
                        <option value="TRUE">Есть военная кафедра</option>
                        <option value="FALSE">Нет военной кафедры</option>
                    </select>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <button class="btn btn-light btn-lg btn-block">Узнать результат</button>
                </div>
            </div>
        </div>
    </form>
    

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

</body>

</html>