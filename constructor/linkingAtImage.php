<?php
$begin = "images";
print '<script type="text/javascript">
			var count =' . $_GET["count"] . '; 
			var id = ' . $_GET["id"] . ';'
                        
        . 'var link = new Array();
           var path = new Array();';
for ($i = 0; $i < $_GET["count"]; $i++) {
    print "link[$i] =  '" . strstr($link[$i], $begin) . "';";
    print "path[$i] =  '" . $path[$i] . "';"; //путь с именем и расширением используется для удаления изображений
}
print '</script>';
print '<script type="text/javascript" src="../js/functionsOfImage.js"></script>';
print '<script type="text/javascript" src="../js/DeleteImageDinamic.js"></script>';
?>
