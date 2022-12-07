<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>File Upload and Download</h1>

<form action="upload.php" method="post" enctype="multipart/form-data">
  <label>Select files to upload:</label><br>
  <input type="file" name="files[]" multiple="multiple" />
  <input type="submit" value="Upload" />
</form>

<h2>Files in the Database:</h2>
<table>
  <tr>
    <th>File Name</th>
    <th>Action</th>
  </tr>

<?php
  // Include the MongoDB driver
  require_once 'vendor/mongodb/mongodb/src/Client.php';

  // Connect to the database
  $client = new MongoDB\Client("mongodb://localhost:27017");
  $db = $client->database;
  $collection = $db->files;

  // Query the database to get the list of files
  $query = array();
  $result = $collection->find($query);

  // Generate table rows for each file in the database
  foreach($result as $row) {
    $file_name = $row['file_name'];
    echo "<tr>";
    echo "<td>$file_name</td>";
    echo "<td><a href='download.php?file=$file_name' class='download-button'>Download</a></td>";
    echo "</tr>";
  }

  // Close the database connection
  $client->close();
?>
</table>
</body>
</html>