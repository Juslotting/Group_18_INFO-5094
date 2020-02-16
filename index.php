<?php
/**
 * Project Information
 * Part 1 of 3
 *
 * Course 5094 LAMP 2
 * Professor Tom Hall
 *
 * Group 18
 * Group Members / Authors
 * Andi Ausrotas
 * Simone Desjardins
 * Justin Lott
 * Jadrienne Lovegrove
 * Nicholas Glover
 *
 * File Information
 * File Name: Index.php
 *
 * Purpose:
 * Main file for project, connects to database, contains php/html and displays upload page.
 */

session_start();

if (isset($_POST['save'])) {
    if(isset($_FILES["file"])) {
      if ($_FILES["file"]["error"] > 0) {
            echo $_FILES["file"]["error"] . "<br />";

        }
      else {
      echo "Upload: " . $_FILES["file"]["name"] . "<br />";
      echo "Type: " . $_FILES["file"]["type"] . "<br />";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
      //filetype is the extension (.csv)
      $fileType = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
      $targetdir = "uploads/";

      //checks if file is a csv
      if ($fileType == "csv") {
          $storagename = $_FILES["file"]["name"];
          if(move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $storagename)) {
          echo "Stored in: " . "uploads/" . $_FILES["file"]["name"] . "<br />";
          $f = fopen($targetdir.$storagename, "r");
          $csv = fgetcsv($f, 1000);
          print_r($csv);

          $con = mysqli_connect("localhost","root","Grilledbilly08","paths");
          if (mysqli_connect_errno()) {
              echo "Unable to connect to MySQL! ". mysqli_connect_error();
              exit();
          }

          $sqli = "INSERT INTO path_info (path_name,operating_frequency,pi_description,pi_note) VALUES (?,?,?,?);";
          $stmt= $con->prepare($sqli);
          $stmt->bindParam("ssss",$csv[0],$csv[1],$csv[2],$csv[3]);
          $status = $stmt->execute();
          if (!$status) {
              echo "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
              exit(1);
          }

          $sqli = "INSERT INTO path_beginning (pb_distance,pb_ground_height,pb_antenna,pb_cable_type,pb_cable_length) VALUES (?,?,?,?,?);";
          $stmt= $con->prepare($sqli);
          $stmt->bindParam("sssss",$csv[4],$csv[5],$csv[6],$csv[7],$csv[8]);
          $status = $stmt->execute();
          if (!$status) {
              echo "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
              exit(1);
          }

          $sqli = "INSERT INTO path_ending (pe_distance,pe_ground_height,pe_antenna,pe_cable_type,pe_cable_length) VALUES (?,?,?,?,?);";
          $stmt= $con->prepare($sqli);
          $stmt->bindParam("sssss",$csv[9],$csv[10],$csv[11],$csv[12],$csv[13]);
          $status = $stmt->execute();
          if (!$status) {
              echo "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
              exit(1);
          }
          /*for (){
          $sqli = "INSERT INTO path_ending (md_distance,md_ground_height,md_terrain,md_obstr_height,md_obstr_type) VALUES (?,?,?,?,?);";
          $stmt= $con->prepare($sqli);
          $stmt->bindParam($csv[14],$csv[15],$csv[16],$csv[17],$csv[18]);
          $status = $stmt->execute();
          if (!$status) {
              echo "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
              exit(1);
          }
        }*/
          }
          else {
            echo "File could not be uploaded";
          }
        }
      else {
        echo "File was wrong type";
      }
      }
    }
}
?>

<h1>Upload and Download</h1>
<p>Select csv file below, and then click Upload</p>
<form class="form" method="post" action="" enctype="multipart/form-data">
<label class="label">File:</label>
<input type="file" name="file" class="input"> <br/>
<button type="submit" name="save" class="btn"><i class="fa fa-upload fw-fa"></i> Upload</button>
</form>


<?php

session_unset();
session_destroy();

?>
