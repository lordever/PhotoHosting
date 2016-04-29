//Функция увеличивает отступ снизу у блока с изображением, 
//если высота изображения больше 200px 
$(window).load(function () {
    for (var i = 0; i < count; i++) {
        var imgHeight = $("#image_" + i + " .image_area img").height();
        if (imgHeight > 200) {
            $("#image_" + i).css("padding-bottom", "480px"); 
        }
    }
});

$("#send").click(function () {
    var email = $("input[name=email]").val();
    
    //Переменная count получена в файле(связке) ../constructor/linkingAtImage 
    for (var i = 0; i < count; i++) {

        //<editor-fold defaultstate="collapsed" desc="Объявляемые переменные(развернуть)">
        var size = $("select[name=size_" + i + "]").val();
        var material = $("select[name=material_" + i + "]").val();
        var cut = $("#cut_" + i).prop("checked");
        var red_eyes = $("#red_eyes_" + i).prop("checked");
        var comments = $("#text_comment_" + i).val();
        var check = false; // Переменная для проверки ввода данных
        //</editor-fold>

        if (cut) // В зависимости от выбранного checkbox возвращается соответствующее значение 
            cut = 1;
        else
            cut = 0;
        if (red_eyes) // В зависимости от выбранного radio возвращается соответствующее значение 
            red_eyes = 1;
        else
            red_eyes = 0;
        if ($.trim(email).length > 0) { //trim - уберает пробелы
            check = true;
        } else {
            check = false;
            var borderParam = "1px solid red";
            $("input[name=email]").css("border", borderParam);
            break;
        }
    }

    if (check) {
        for (var i = 0; i < count; i++) {
            $("input[name=email]").css("border", "1px solid grey");
            $.ajax({
                url: "add.php?size_" + i + "=" + size + "&material_" + i + "="
                        + material + "&cut_" + i + "=" + cut + "&red_eyes_"
                        + i + "=" + red_eyes + "&comments_" + i + "=" + comments +
                        "&count=" + count + "&link_" + i + "=" + link[i] + "&email=" + email,
                success: function (data) {
                    if (data == 1)
                        window.location.href = '../view/success.php';
                    if (data == 0)
                    {
                        alert("Error");
                    }
                }
            });
        }
    } else {
        var borderParam = "1px solid red";
        $("input[name=email]").css("border", borderParam);
        check = false;
    }

});





