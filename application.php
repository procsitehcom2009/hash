<?php
require_once("LoadFile.php");//Подключаем класс LoadFile
$path_dir="temp/";//Указываем временную дирректорию для загрузки файла
for ($i=0;$i<count($_FILES['file']['tmp_name']);$i++){//В цикле проходим по массиву файлов
    $loadfile= new LoadFile(//Создаем новый объект класс LoadFile
        $path_dir,
        $_FILES['file']['name'][$i],
        $_FILES['file']['type'][$i],
        $_FILES['file']['tmp_name'][$i],
        $_FILES['file']['error'][$i],
        $_FILES['file']['size'][$i]
    );
    $loadfiles[$i]=$loadfile->get();//Вызываем метод получение данных объекта класса LoadFile и вносим в массив
}
echo json_encode($loadfiles);//Отдаем массив данных в JSON формате

