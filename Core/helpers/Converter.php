<?php
namespace Core\helpers;

//статический класс для работы с конфигурациями бэкендa
class Converter{

    public static  function insert_base64_encoded_image_src($img, $echo = false){
        $imageSize = getimagesize($img);
        $imageData = base64_encode(file_get_contents($img));
        $imageSrc = "data:{$imageSize['mime']};base64,{$imageData}";
        if($echo == true){
            echo $imageSrc;
        } else {
            return $imageSrc;
        }
    }
}
