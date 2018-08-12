<?php
// require Uploadcare API
require_once 'vendor/autoload.php';

// Define uploadcare account keys
define('UC_PUBLIC_KEY', 'demopublickey');
define('UC_SECRET_KEY', 'demoprivatekey');
use \Uploadcare;

// create an API instance
$api = new Uploadcare\Api(UC_PUBLIC_KEY, UC_SECRET_KEY);

// Count of uploaded files
$filesCount = count($_FILES['upload']['name']);
if($filesCount) {
  echo '<h3> Files just uploaded </h3>';
} else {
  echo 'No files uploaded';
}

for( $i=0 ; $i < $filesCount ; $i++ ) {
  //Get temp file path
  $tmpPath = $_FILES['upload']['tmp_name'][$i];
  //Make sure we have a file path
  if ($tmpPath != ""){
    //Setting up the dest file name
    $destFilePath = "./uploads/" . $_FILES['upload']['name'][$i];
    move_uploaded_file($tmpPath, $destFilePath);
    $file = $api->uploader->fromPath($destFilePath);
    $file->store();
    echo '<p><a href="'.$file->getUrl().'">';
    if($file->data['is_image']) {
      echo '<img src="'.$file->preview(300, 300)->getUrl().'"><br/>';
    }
    echo $_FILES['upload']['name'][$i];
    echo '</a></p>';
  }
}
?>