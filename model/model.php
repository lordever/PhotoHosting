<?php

/*
 * Класс Image работает с изображением и обработкой комментариев и параметрами 
 * к нему. Список методов: getName(), getTextError(), isSecurity(), loadImage(), 
 * saveImage(). Для обраотки тестовых комментариев и параметров к изображению в
 * методе saveImage() есть обращение к классу Comments и его методу loadComments.
 * ПЕРЕРАБОАТЬ!!!!!!
 */

class Image {

    private static $error = 0; // Код ошибки
    private static $id_folder; //Идентификатор папки в дирректории. 

    //Объявлен статичным, так как вызывается из разных методов
    /*
      Здесь нужен комментарий
     */

    /**
     * 
     * @param type $file
     * @param type $id_session
     */
    public static function saveImage($file, $id_session) {
        if ($file["error"][0] > 0) {
            self::$error = 7;
            header("Location: ../view/error.php?code=" . self::$error); //Ошибка
            exit;
        }
        $namesOfImage = array(); // В данную переменную помещаются все названия изображений
        $type = array();
        $size = array();
        $count; // Переменная хранит количество загружаемых в данный момент изображений
        $getnames = ""; // Переменная хранит строку GET запроса 
        $tmp_name = array(); //в переменной $tmp_name хранится пути загруженных изображений
        $numberOfFileds = array(); //Массив хранит в себе идентификатор папки, 
        //в которую загружаются изображения

        $count = self::parsingCountImage($file);
        for ($i = 0; $i < $count; $i++) { // Перебор файла на компоненты
            $namesOfImage[$i] = self::parsingNameImage($file, $i);
            $type[$i] = self::parsingTypeImage($file, $i);
            $size[$i] = self::parsingSizeUmage($file, $i);
            $tmp_name[$i] = self::parsingPathUmage($file, $i);
        }

        self::checkCount($count); //Проверка количества загружаемых изображений
        if (!self::isSecurity($namesOfImage, $type, $size, $count)) {
            header("Location: ../view/error.php?code=" . self::$error);
            exit; //Ошибка
        } else
        // <editor-fold defaultstate="collapsed" desc="Создание дирректории и загрузка изображения на сервер">
        if (self::isSecurity($namesOfImage, $type, $size, $count)) {
            $uploadfile = array();
            $names = self::getName($namesOfImage, $count); //принимает названия изображений(Может состоять из нескольких элементов)
            self::getFilelist();
            $numberOfFileds[0] = self::$id_folder; //Здесь хранится следующий id в очереди на создание дирректории
            if (mkdir("../images/$numberOfFileds[0]")) {
                for ($j = 0; $j < $count; $j++) {
                    $image = strstr($names[$j], '.', true); //strstr - Находит первое вхождение подстроки
                    $uploadfile[$j] = "../images/$numberOfFileds[0]/$image/$names[$j]"; //формирования пути изображения в массиве
                    $getnames .= "im_" . $j . "=" . $names[$j] . "&";
                    mkdir("../images/$numberOfFileds[0]/$image");
                    if (move_uploaded_file($tmp_name[$j], $uploadfile[$j])) { //Перемещает загруженный файл в новое место
                        header("Location: ../view/image.php?" . $getnames . "count=" .
                            $count . "&id=" . $numberOfFileds[0] . "&s_id=" . $id_session);
                    }
                }
            } else {
                self::$error = 3;
                header("Location: ../view/error.php?code=" . self::$error); //Ошибка
                exit;
            }
        }// </editor-fold>
    }

    public static function removeImages() {
        $id = $_GET["id"];
        $count = $_GET["count"];
        $im = array();
        $txt = array();
        for ($i = 0; $i < $count; $i++) {
            $im[$i] = $_GET["im_" . $i];
            $txt[$i] = strstr($_GET["im_" . $i], ".", true) . ".txt";
            $image = strstr($im[$i], '.', true);
            unlink("../images/$id/$image/" . $im[$i]);
            rmdir("../images/$id/$image");
        }
        if (rmdir("../images/$id"))
            return true;
        else
            return false;
    }

    public static function removeImagesDynamic($image_path) {
        $image_dir = substr($image_path, 0, -11);
        unlink($image_path);
        rmdir($image_dir);

        //Удаление дирректории, в случае если папка пуста
        $image_dir_isEmpty = substr($image_path, 0, -18);
        if(count(scandir($image_dir_isEmpty)) == 2){
            rmdir($image_dir_isEmpty);
        }
    }

    /*
     * Функция loadImage() обрабатывает im. Указывается в GET параметре, 
     * в функции SaveImage(класс Image). После успешного выполнения этой функции 
     * возвращается массив с полями path - путь к изображению, и link - веб-адрес 
     * данного изображения.   
     */

    public static function loadImage() {
        $im = array(); //Указывается в GET параметре укзанном в функции SaveImage(класс Image)
        $count = $_GET["count"]; // GET параметр count отображает количество загружаемых изображений 
        $numberOfFilds = $_GET["id"];
        $results = array("path" => array(), "link" => array()); // переменная results(ассоциативныый массив) содержит путь и адрес изображений
        for ($i = 0; $i < $count; $i++) { // Перебор GET параметров
            $im[$i] = $_GET["im_" . $i];
        }
        if (!$im) {
            return false;
        }
        for ($i = 0; $i < $count; $i++) {
            $image = strstr($im[$i], '.', true); //strstr - Находит первое вхождение подстроки
            if (!file_exists("../images/$numberOfFilds/$image/$im[$i]")) { //Проверить наличие указанного файла или каталога
                return false;
            }
            $results["path"][$i] = "../images/$numberOfFilds/$image/$im[$i]"; //путь к изображению
            $results["link"][$i] = "http://" . $SERVER["HTTP_HOST"]
                    . "../images/$numberOfFilds/$image/"; //веб-адрес данного изображения
                }
                return $results;
            }

// <editor-fold defaultstate="collapsed" desc="Вывод кода ошибки">
    /*
     * Функция getTextError() обрабатывает код ошибки и выводит соответствующее 
     * сообщение в зависимости от кода.
     */
    public static function getTextError($code) {
        if ($code == 1) {
            return "Неверный тип изображения!";
        } elseif ($code == 2) {
            return "превышен максимальный размер файла"
            . "(10 Мб)!";
        } elseif ($code == 3) {
            return "Ошибка при загрузке. Попробуйте ещё "
            . "раз.";
        } elseif ($code == 4) {
            return "Ошибка при вводе данных. "
            . "Введите все поля обозначенные звёздочкой";
        } elseif ($code == 6) {
            return "Возможно загрузить до 20 изображений";
        } elseif ($code == 7) {
            return "Необходимо загрузить не менее одного изображения, "
            . "форматов(.jpeg .png .jpg)";
        }
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Парсинг из файла">
    private static function parsingCountImage($file) {//Перебор количества изображений
        foreach ($file as $key => $value) {
            if ($key == "name") {
                return $count = count($value);
            }
        }
    }

    private static function parsingNameImage($file, $i) {//Перебор имени изображений
        foreach ($file as $key => $value) {
            if ($key == "name") {
                return $namesOfImage[$i] = $value[$i];
            }
        }
    }

    private static function parsingTypeImage($file, $i) {//Перебор на тип изображения
        foreach ($file as $key => $value) {
            if ($key == "type") {
                return $type[$i] = $value[$i];
            }
        }
    }

    private static function parsingSizeUmage($file, $i) {//Перебор на размер изображения
        foreach ($file as $key => $value) {
            if ($key == "size") {
                return $size[$i] = $value[$i];
            }
        }
    }

    private static function parsingPathUmage($file, $i) {//Перебор на пути изображения
        foreach ($file as $key => $value) {
            if ($key == "tmp_name") {
                return $tmp_name[$i] = $value[$i];
            }
        }
    }

// </editor-fold>

    private static function checkCount($count) { //Проверка числа загрузок изображений
        if ($count > 20) {
            self::$error = 6;
            header("Location: ../view/error.php?code=" . self::$error); //Ошибка
            exit;
        }
    }

    /*
     * Функция isSecurity() проверяет файл(изображение) на правильность формата
     * (изображение должно быть только формата .jpeg .jpg .png). А также 
     * проверяется размер изображения и количество загруженных изображений в 
     * переменной $count. 
     */

    private static function isSecurity($namesOfImage, $type, $size, $count) {
        $blacklist = array(".php", ".phtml", ".php3", "php4", ".html",
            ".htm");
        foreach ($blacklist as $item) {
            for ($i = 0; $i < $count; $i++) {
                if (preg_match("/$item\$/i", $namesOfImage[$i])) { //Проверка на правильность расширения 
                    self::$error = 1;
                    return false;
                }
//Проверка на тип изображения
                if (($type[$i] != "image/jpeg") && ($type[$i] != "image/jpg") && ($type[$i] != "image/png")) {
                    self::$error = 1;
                    return false;
                }

//проверка на размер изображения
                if ($size[$i] > (10000 * 1024)) {
                    self::$error = 2;
                    return false;
                }
            }
        }
        return true;
    }

    /*
     * Функция getName() принимает и обрабатывает название изображения и его
     * наличие на сервере. В случае успешного выполнения функция возвращает кеш, 
     * который будем являться названием изображения на сервере.
     */

    private static function getName($filename, $count) {
        $names = array();
        $success = false; // Переменная проверки правильности выполнения программы
        for ($i = 0; $i < $count; $i++) {
            $names[$i] = substr(md5(microtime()), 0, 6); //кеширует название изображения
            $names[$i] .= strchr($filename[$i], "."); //Находит последнее вхождение подстроки начиная с точки(".")
            if (!file_exists("../images/$filename[$i]")) {  //Проверить наличие указанного файла или каталога
                $success = true;
            } else {
                $success = false;
            }
        }
        if ($success) {
            return $names;
        } else {
            return self::getName();
        }
    }

    private static function getFilelist() {
        $filelist = scandir("../images/"); // переменная хранит дерево папок в дирректории ../images/
        for ($i = 0; $i < count($filelist); $i++) {
            $last = (count($filelist) - 2); //Последнее значение переменной является максимальным элементом массива $filelist
            if (!$last) { //В случае, если папки в дирректории отсутствуют, вернуть 0
                self::$id_folder = 1;
            } else {
                self::$id_folder = $last + 1;
            }
        }
    }

}

/*
 * Класс Comments отвечает за принятие текстовых комментариев и параметров к 
 * загружаемому изображению. В данном классе содержатся методы: checkCut(), 
 * checkSize(), getRedEyes(), loadComments().
 */

class Comments {
    /*
     * Функция loadComments() обрабатывает каждый из принимаемых значений, после
     *  чего составляет лист комментария, в котором указываются все эти параметры в 
     * текстовом формате. Данная функция необходима для последующего вывода 
     * информации об изображении на экран. Функция loadComments() принимает 
     * значения: текстовый комментарий, кешируемое название изображения(name), 
     * название изображения вводимый пользователем (name_image), материал, 
     * параметр RedEyes(красные глаза), параметр обрезки(Cut), параметр размер(Size).
     * Данная функция содержит в себе стороние функции, такие как: getRedEyes(),
     *  checkCut(), checkSize(). После успешного выполнения всех этих функций 
     * создаётся текстовый документ, котором указываются все необходимые 
     * параметры, для последующего вывода их на экран. 
     */

    public static function loadComments($links, $material, $size, $red_eyes, $cut, $text_comment) {
        $text_comment = htmlspecialchars($text_comment); //проверка на спецсимволы
        $comments = fopen("../$links" . "Comment.txt", "a+t"); //создание текстового документа
        fwrite($comments, "Material: " . $material .
                "\nSize: " . $size . "\nRed eyes: " . $red_eyes . "\nCut: " . $cut . "\nComments: " . $text_comment); // запись параметров в текстовый документ
        fclose($comments); //закрытие текстового документа
        return true;
    }

}

class EmailCheck {

    public static function getEmail($email) {
        if (self::checkEmail($email) == true) {
            $sendEmail = self::sendEmail($email);
            return $sendEmail;
        } else {
            return false;
        }
    }

    public static function checkEmail($email) {
        $email_reg = "/[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*"
        . "[a-z0-9]+)*\.)+[a-z]+/i";
        if (preg_match($email_reg, $email)) {
            return true;
        } else {
            return false;
        }
    }

    private static function sendEmail($email) {
        $message = "Текст сообьщения";
        $to = $email;
        $from = "lordever@mail.ru";
        $theme = "Фотография"; //Тема сообщения
        $theme = "=?windows-1251?B?" . base64_encode($theme) . "?="; //Кодирование темы
        $headers = "From: $from\r\nReply-to: $to\r\nContent-type: text/plain; "
        . "charset=windows-1251\r\n";
        $send_mail = mail($to, $theme, $message, $headers);
        return $send_mail;
    }

}

?>