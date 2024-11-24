<?php
include("./includes.php");
if (!isset($_SESSION['user_id'])) {
    // Se não estiver logado, redireciona para a página de login
    header('Location: ../../login/login.php');
    exit();
}

$base_dir = dirname(__DIR__) . "/uploads/";

$target_dir = $base_dir . $_SESSION['user_email'] . "/";

if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0777, true)) {
        die('Failed to create folders...');
    }
}

if (!isset($_FILES["photoUser"])) {
    echo "No file uploaded";
    header('Location: index.php');
}
$imageFileType = strtolower(pathinfo($_FILES["photoUser"]["name"], PATHINFO_EXTENSION));
$target_file = $target_dir . "perfil.jpg"; // Save as JPEG
$uploadOk = 1;

echo $target_file;
echo "<br>";
echo $imageFileType;
echo "<br>";
echo $_FILES["photoUser"]["tmp_name"];
var_dump($_FILES["photoUser"]);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  if (empty($_FILES["photoUser"]["tmp_name"])) {
    echo "No file uploaded";
    header('Location: index.php');
  }
  $check = getimagesize($_FILES["photoUser"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
  var_dump($check);
}


// Check file size
if ($_FILES["photoUser"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "webp" && $imageFileType != "svg" && $imageFileType != "jfif") {
  echo "Sorry, only JPG, JPEG, PNG, GIF, WEBP, SVG & JFIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["photoUser"]["tmp_name"], $target_file)) {
    // Convert image to JPEG
    switch ($imageFileType) {
      case 'png':
        $image = imagecreatefrompng($target_file);
        break;
      case 'gif':
        $image = imagecreatefromgif($target_file);
        break;
      case 'webp':
        $image = imagecreatefromwebp($target_file);
        break;
      case 'jpeg':
      case 'jpg':
      default:
        $image = imagecreatefromjpeg($target_file);
        break;
    }
    if ($image) {
      imagejpeg($image, $target_file, 100); // Save as JPEG with quality 100
      imagedestroy($image);
      echo "The file ". htmlspecialchars( basename( $_FILES["photoUser"]["name"])). " has been uploaded and converted to JPEG.";
    } else {
      echo "Sorry, there was an error converting your file.";
    }
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>