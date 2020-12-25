<?php

// Подключаем файл для подключения к БД "countries"
require_once('inc/connect_db.php');

// Создаём запрос в БД для получения данных из неё
$stmt = $pdo->query('SELECT * FROM table_countries');
?>

<div class="table_countries">
    <div class="titles_columns">
        <div class="number_row">№ п/п</div>
        <div class="column_item">Название страны</div>
        <div class="column_item">Столица страны</div>
        <div class="column_item">Государственный язык</div>
        <div class="column_item">Численность населения</div>
        <div class="column_item">Континент</div>
    </div>
    <!-- Выводим данные в структуру html разметки  -->
    <? While($row = $stmt->fetch()): ?>
        <div class="row_table">
            <div class="number_row">
                <?= $row['id']?>
            </div>
            <div class="column_item">
                <?= htmlspecialchars($row['title'])?>
            </div>
            <div class="column_item">
                <?= htmlspecialchars($row['capital'])?>
            </div>
            <div class="column_item">
                <?= htmlspecialchars($row['language'])?>
            </div>
            <div class="column_item">
                <?= htmlspecialchars($row['population'])?>
            </div>
            <div class="column_item">
                <?= htmlspecialchars($row['continent'])?>
            </div>
        </div>
    <?php endwhile; ?>
</div>