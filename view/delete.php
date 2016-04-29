<?php
    /*
     * Логика программы подинамическому удалению изображений из страницы
     */

     require_once "../model/model.php";
     $image_path = $_GET["image_path"];
     Image::removeImagesDynamic($image_path);
?>
