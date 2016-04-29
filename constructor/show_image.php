<?php

require_once '../model/model.php';
$results = Image::loadImage();
if ($results) {
    $count = $_GET["count"]; //КОличество загружаемых изображений
    $path = array(); ////путь к изображению 
    $link = array(); //веб-адрес данного изображения
    for ($i = 0; $i < $count; $i++) {
    	$path[$i] = $results["path"][$i];
    	$link[$i] = $results["link"][$i];
    }
}


// Функция выводит изображения 
//с определённой формой для заполнения в файле ../view/image.php
function OutImageThroughCycle($path ,$i){ 
	$br++;
	echo '<div  class="image" id="image_'.$i.'">'
                
	. '<div class="image_area">'
                . '<img src=' . $path[$i] . ' alt="Image" style="width: 235px; 
                    padding-right:5px; text-align:center; "/>
                    
                    <span class="delete delete_'.$i.'" style="color: red; 
                    position: absolute; left:213px; top:10px; cursor: 
                    pointer;width:10px; height:10px;">X</span>
           </div>
	<p>
		<b>
			&nbsp;Размер фото: 
		</b>
		<select name="size_' . $i . '">
			<option value="1" selected>10X15</option>
			<option value="2">15X20</option>
			<option value="3">20X30</option>
		</select>
	</p>
	<p>
		<b>
			&nbsp;Материал: 
		</b>
		<select name="material_' . $i . '">
			<option value="1" selected>Глянец</option>
			<option value="2">Мат</option>
			<option value="3">Бумага</option>
		</select>
	</p>
	<p>
		<b>
			&nbsp;Обрезать фото: 
		</b>
		<input type="checkbox" id="cut_' . $i . '" value="cut" />
	</p>
	<p>
		<b>
			&nbsp;Убрать красные глаза: 
		</b>
		<input type="checkbox" id="red_eyes_' . $i . '" value="red_eyes" />
	</p>
	<p>
		<b>
			&nbsp;Коментарий к фотографии:
		</b>
		<p>
                    <input type="text" id="text_comment_' . $i . '" '
                    . 'name="comment_' . $i . '" style="width: 250px; 
                        padding-bottom: 100px; margin-top:10px; vertical-align:top;
                        margin-bottom: 150px;">
                        </p>
		</p>
	</div>';
}


?>