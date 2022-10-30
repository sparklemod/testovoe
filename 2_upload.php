<?php
$new_name = trim(mb_strtolower($_FILES['import_file']['name']));
$csvFileType = strtolower(pathinfo($new_name, PATHINFO_EXTENSION));

if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_FILES['import_file']) && ($csvFileType == "csv") && ($_FILES["import_file"]["size"] < 3000)) {
    $handle = fopen($_FILES['import_file']['tmp_name'], "r");
    if (false === $handle){
        die('Can\'t open file');
    }
    else{
        $dir = "upload";
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
        $array_csv = [];
        while (false !== ($row = fgetcsv($handle,1000,','))){
            $array_csv[] = $row;
        }
        fclose($handle);

        //echo "<pre>".print_r($array_csv, 1) . "</pre>";
        for ($i = 0; $i < count($array_csv); $i++) {
            $extention = substr($array_csv[$i][0], strpos($array_csv[$i][0],"."));
            //$filename = $uploadDir . ($i+1) . $extention;
            $filename = __DIR__ . '/upload/' . ($i+1) . $extention;
            echo "<pre>" . ($i+1) . $extention . ' was created' . "</pre>";
            file_put_contents($filename, $array_csv[$i][1]);
        }

    }
}
else echo "Возможно, файл не csv формата или слишком большой. Попробуйте снова";
?>

<!--Какие дыры это может создать? Как бороться?
- Пользователь может произвести атаку на файловую систему, отправить вредоносный скрипт.
Файлы нужно сохранять в тех папках, где отключена обработка любых скриптов (php, python, cgi и т.д.).-->


