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
    header('Location: index.php?message=No file uploaded');
    exit();
}

$imageFileType = strtolower(pathinfo($_FILES["photoUser"]["name"], PATHINFO_EXTENSION));
$target_file = $target_dir . "perfil.jpg"; // Save as JPEG
$uploadOk = 1;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  if (empty($_FILES["photoUser"]["tmp_name"])) {
    header('Location: index.php?message=No file uploaded');
    exit();
  }
  $check = getimagesize($_FILES["photoUser"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    header('Location: index.php?message=File is not an image');
    exit();
  }
}

// Check file size
if ($_FILES["photoUser"]["size"] > 500000) {
  header('Location: index.php?message=Sorry, your file is too large');
  exit();
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "webp" && $imageFileType != "svg" && $imageFileType != "jfif") {
  header('Location: index.php?message=Sorry, only JPG, JPEG, PNG, GIF, WEBP, SVG & JFIF files are allowed');
  exit();
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  header('Location: index.php?message=Sorry, your file was not uploaded');
  exit();
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
      header('Location: index.php?message=The file has been uploaded and converted to JPEG');
      exit();
    } else {
      header('Location: index.php?message=Sorry, there was an error converting your file');
      exit();
    }
  } else {
    header('Location: index.php?message=Sorry, there was an error uploading your file');
    exit();
  }
}
?>