<?php

// Подключаем файл с кодом подключения к БД "countries"
require_once('inc/connect_db.php');

// Подключаем блок функций для валидации данных из формы
require_once('inc/validateForm.php');

// Присвоение данных из массива $_POST соответствующим переменным 
$title = $_POST['title'];
$capital = $_POST['capital'];
$language = $_POST['language'];
$population = $_POST['population'];

/* Вводим это условие, чтобы избежать появление "Notice", т.к массив 'continent' может не существовать,
если ни один checkbox не быран. Появление "Notice" не позволяет передать ответ на асинхронный запрос.*/
if (isset($_POST['continent'])) {
    $continent = $_POST['continent'];
} else {
    $continent = '';
}

// Создаём вспомогательный массив с названием полей формы (будем его использовать в функциях валидации)
$fields = array('"Название страны"', '"Столица"', '"Государственный язык"', '"Численность населения"');

// Перезаписываем в переменные данные из формы, прошедшие валидацию
$title = requiered($title, $fields[0]);
$capital = requiered($capital, $fields[1]);
$language = requiered($language, $fields[2]);
$population = check_population($population, $fields[3]);
$continent = check_continent($continent);

// Создаём таблицу в базе данных
$query = "
    CREATE TABLE IF NOT EXISTS `table_countries`(
    `id` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(60) NOT NULL,
    `capital` VARCHAR(60) NOT NULL,
    `language` VARCHAR(60) NOT NULL,
    `population` INT(11) UNSIGNED NULL,
    `continent` VARCHAR(50)
)";
$stmt = $pdo->query($query);

// Необходимо проверить имеется ли такая страна уже в таблице БД
$stmt = $pdo->prepare('SELECT COUNT(id) as num FROM table_countries WHERE title = ?');
$stmt->execute(array($title));
$info = $stmt->fetch();
$amount = $info['num'];

// Если даннные из формы прошли валидацию, пишем код добавления данных в таблицу БД
if ($title && $capital && $language) {

    if ($amount == 0) {
        // Сохраняем данные из формы в таблицу БД
        $query = "INSERT INTO table_countries (title, capital, language, population, continent) VALUES (?,?,?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $capital, $language, $population, $continent]);

        $message = "Данные отправлены, прошли проверку и сохранены в базу данных!";
        
    } else {
        // Иначе данные из формы не сохраняем, о чём и сообщаем
        $message = 'Данные не сохранены в базу данных, т.к. такая страна уже имеется в таблице базы данных!';
    }

} else {
    // Иначе данные из формы не сохраняем, о чём и сообщаем
    $message = 'Данные не прошли проверку и не сохранены в базу данных!';
}

// Отправляем ответ от сервера на запрос от клиента с учётом выполнения необходимых условий
$response = ['message' => $message];
echo json_encode($response);


