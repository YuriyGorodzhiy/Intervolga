<?php

// Блок функций для валидации данных, отправленых на сервер из формы

// Функция для валидации обязательных полей "Название страны", "Столица", "Государственный язык"
function requiered($val, $field) {
    // проверка на пустоту
    if (empty($val)) {
        return false;
    } else {
        // проверка на количество символов
        if (3 <= mb_strlen($val, 'utf-8') && mb_strlen($val, 'utf-8') <= 60) {
            // проверка на соответствие регулярному выражению
            if (preg_match("/^[А-ЯЁ][а-яА-ЯёЁ\s-]+[а-яё]$/u", $val)) {
                return $val;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

// Функция для валидации поля "Численность населения"
function check_population($val, $field) {
    // проверка на пустоту
    if (!empty($val)) {
        // проверка является ли строка числом
        if (is_numeric($val) && strlen($val) <= 10) {
            return $val;
        } else {
            return false;
        }
    } else {
        return $val;
    }
}

// Функция для валидации поля "Континент"
function check_continent($continent) {
    // Если массив "continent" не пустой, то проверяем значения его элементов на соотвествие заявленным 
    if (!empty($continent)) {
        foreach ($continent as $key => $val) {
            switch ($val) {
                case "Европа":
                    break;
                case "Азия":
                    break;
                case "Африка":
                    break;
                case "Северная Америка":
                    break;
                case "Южная Америка":
                    break;
                case "Австралия":
                    break;
                default:
                    unset($continent[$key]);
                }
        }
        // Из элементов массива составляем строку
        $continent = implode(", ", $continent);
    }
    return $continent;
}