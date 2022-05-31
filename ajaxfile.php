<?php

$id= "10";/*$_POST["id"];*/
$filename = $_FILES['file']['name'];
$file_extension = pathinfo($location, PATHINFO_EXTENSION);
$file_extension = strtolower($file_extension);
$image_ext = array("jpg","png","jpeg","gif");

$location = 'barang/'.$id.".".$file_extension;

$response = 0;
if(in_array($file_extension,$image_ext)){
  if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    $response = $location;
  }
}

echo $response;
?>