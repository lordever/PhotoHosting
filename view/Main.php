<?
ob_start();
session_start();
if($_SESSION["s_id"] > 0)
    $_SESSION["s_id"] = 0;
if(!isset($_SESSION["s_id"]))
    $_SESSION["s_id"] = 0;

 ini_set('max_file_uploads', "50"); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Hosting</title>
        <script type="text/javascript" src="../lib/jquery-2.1.4.min.js"></script>
        <link re="stylesheet" type="text/css" href="../styles/index.css" />
        <style>
            h1{
                text-align:center;
            }

            .blockOfWork{
                margin:0 auto;
                width:500px;
            }

            .blockOfWork b{
                text-align:center;
            }
        </style>
        <script type="text/javascript">
            </script>
    </head>
    <body>
        <h1>Welcome to my Hosting!</h1>
        <?php
        if (isset($_POST["load"])){
            require_once "../constructor/load.php";
        }
        ?>
        <form action="" name="hosting" method="post" enctype="multipart/form-data">
            <div class="blockOfWork">
                <p>
                    <b style="color: red">*</b><b>Выберите изображения:</b>
                    <input type='file' name='image[]' min="1" max="30" multiple='true'/>
                </p>
                
                <p align="right">
                    <input type="submit" name="load" value="Отправить"  />
                </p>
            </div>
        </form>
    </body>
</html>