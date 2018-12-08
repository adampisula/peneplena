<?php

    $new_id = 0;

    $path = get_template_directory()."/img/backgrounds/";
    $files = array_diff(scandir($path), array(".", ".."));

    $target_dir = get_bloginfo('template_url')."/img/backgrounds/";
    $target_file = $target_dir.basename(( (string) (count($files) + 1)).explode("." ,$_FILES["img"]["name"])[1]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["img"]["tmp_name"]);

        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    if($imageFileType == "png") {
        $image = imagecreatefrompng($target_file);
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $quality = 85; // 0 = worst / smaller file, 100 = better / bigger file
        $target_file = explode(".", $target_file)[0].".jpg";
        imagejpeg($bg, $target_file, $quality);
        imagedestroy($bg);
    }

    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO photos (file, author, link) VALUES (".$target_file.", ".$_POST["author"].", ".$_POST["link"].")";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        $uploadOk = 0;
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    if($uploadOk <= 0)
        die("ERROR");

    header("Location: upload.php");