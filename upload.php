<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
  // Include the file handling functions
  require_once 'file_functions.php';

  // Include the MongoDB driver
  require_once 'vendor/mongodb/mongodb/src/Client.php';

  // Connect to the database
  $client = new MongoDB\Client("mongodb://localhost:27017");
  $db = $client->database;
  $collection = $db->files;

  // Get the list of uploaded files
  $files = getUploadedFiles();

  // Insert each file into the database
  foreach($files as $file) {
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_tmp_name = $file['tmp_name'];

    // Move the uploaded file to the server
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . $file_name;
    move_uploaded_file($file_tmp_name, $upload_file);

    // Insert the file data into the database
    $document = array(
      "file_name" => $file_name,
      "file_size" => $file_size,
    );
    $collection->insertOne($document);
  }

  // Close the database connection
  $client->close();

  // Redirect the user back to the main page
  header('Location: index.php');
?>
</body>
</html>