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
error_reporting(-1);
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
            //open file
            if($f = fopen($targetdir.$storagename, "r")) {
              $csv = array();
              while (($line = fgetcsv($f)) !== FALSE) {
                array_push($csv,$line);
              }
              fclose($f);
              echo $csv[0][0];


              $con= new PDO("mysql:host=127.0.0.1;dbname='paths'", 'lamp2user', 'info5094');
              $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $sqli = "INSERT INTO path_info (path_name,operating_frequency,pi_description,pi_note) VALUES (:path_name,:operating_frequency,:pi_description,:pi_note)";
              $stmt= $con->prepare($sqli);
              $stmt->bindParam(":path_name",$csv[0][0]);
              $stmt->bindParam(":operating_frequency",$csv[0][1]);
              $stmt->bindParam(":pi_description",$csv[0][2]);
              $stmt->bindParam(":pi_note",$csv[0][3]);
              $status = $stmt->execute();
              if (!$status) {
                  echo "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                  exit(1);
              }
              else {
                echo "Insert successful";
              }

              $sqli = "INSERT INTO path_beginning (pb_distance,pb_ground_height,pb_antenna,pb_cable_type,pb_cable_length) VALUES (:pb_distance,:pb_ground_height,:pb_antenna,:pb_cable_type,:pb_cable_length)";
              $stmt= $con->prepare($sqli);
              $stmt->bindParam(":pb_distance",$csv[1][0]);
              $stmt->bindParam(":pb_ground_height",$csv[1][1]);
              $stmt->bindParam(":pb_antenna",$csv[1][2]);
              $stmt->bindParam(":pb_cable_type",$csv[1][3]);
              $stmt->bindParam(":pb_cable_length",$csv[1][4]);
              $status = $stmt->execute();
              if (!$status) {
                  echo "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                  exit(1);
              }
              else {
                echo "Insert successful";
              }

              $sqli = "INSERT INTO path_ending (pe_distance,pe_ground_height,pe_antenna,pe_cable_type,pe_cable_length) VALUES (:pe_distance,:pe_ground_height,:pe_antenna,:pe_cable_type,:pe_cable_length)";
              $stmt= $con->prepare($sqli);
              $stmt->bindParam(":pe_distance",$csv[2][0]);
              $stmt->bindParam(":pe_ground_height",$csv[2][1]);
              $stmt->bindParam(":pe_antenna",$csv[2][2]);
              $stmt->bindParam(":pe_cable_type",$csv[2][3]);
              $stmt->bindParam(":pe_cable_length",$csv[2][4]);
              $status = $stmt->execute();
              if (!$status) {
                  echo "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                  exit(1);
              }
              else {
                echo "Insert successful";
              }

              for($i = 3; $i < 17; $i++) {
                $sqli = "INSERT INTO path_ending (md_distance,md_ground_height,md_terrain,md_obstr_height,md_obstr_type) VALUES (:md_distance,:md_ground_height,:md_terrain,:md_obstr_height,:md_obstr_type)";
                $stmt= $con->prepare($sqli);
                $stmt->bindParam(":md_distance",$csv[$i][0]);
                $stmt->bindParam(":md_ground_height",$csv[$i][1]);
                $stmt->bindParam(":md_terrain",$csv[$i][2]);
                $stmt->bindParam(":md_obstr_height",$csv[$i][3]);
                $stmt->bindParam("md_obstr_type",$csv[$i][4]);
                $status = $stmt->execute();
                if (!$status) {
                    echo "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                    exit(1);
                }
                else {
                  echo "Insert successful";
                }
              }
            }
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
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<div>
<h1>Upload and Download</h1>
<p>Select csv file below, and then click Upload</p>
<form class="form" method="post" action="" enctype="multipart/form-data">
    <label class="label">File: </label>
    <input type="file" name="file" class="input"> <br /><br />
    <button type="submit" name="save" class="btn"><i class="fa fa-upload fw-fa"></i> Upload</button>
</form>
</div>


<?php

session_unset();
session_destroy();

?>
