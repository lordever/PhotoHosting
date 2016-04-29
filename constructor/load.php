<?php

/*
 * В данном файле производится обработка параметров: текст комментария, название
 * изображения вводимый пользователем, размер, параметр обрезки фото, параметр 
 * красные глаза, параметр материал. После обработки параметров вызывается функция 
 * SaveImage(Класс Image)
 */
if (isset($_POST["load"])) {
    if (count($_FILES["image"]["name"]) > 20) {
        header("Location: ../view/error.php?code=6"); //Ошибка
    } else {
        require_once '../model/model.php';
        session_start();
        Image::saveImage($_FILES["image"], $_SESSION["s_id"]); //Сохранение изображения
    }
}
?>