$(document).ready(function () { //Событие скрывает кнопку при загрузке страницы
    $(".delete").hide();
    
});

$(".image_area").hover(//СОбытие регулирует появление кнопки удаления 
        function () {
            $(".delete").fadeIn(100);
        },
        function () {
            $(".delete").fadeOut(100);
        }
);

//Удаление элемента из страницы при нажатии на крестик
$(".delete").click(function () {
    var checkId = false; 
    var i = 0; //Идентификатор для изображения
    while (checkId == false) {
        if ($(this).hasClass("delete_"+i)) 
        {
            var image_path =  path[i] //Путь к изображению
            $(this).parent("div").parent("div").remove(); 
            $.ajax({
                url: "delete.php?image_path="+image_path,
            });
            checkId = true;
            if(!$("#main").children(".image").hasClass("image"))
                window.location.href = '../view/main.php'; //Если элементов не 
            //осталось на странице, то возвращает на главную страницу
        } else {
            i++;
            checkId = false;
        }
    }
});



