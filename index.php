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
          $storagename = "file.csv";
          if(move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $storagename)) {
          echo "Stored in: " . "uploads/" . $_FILES["file"]["name"] . "<br />";
          $f = fopen($targetdir.$storagename, "r");
          $csv = fgetcsv($f, 1000);
          print_r($csv);

          $con = mysqli_connect("localhost","lamp2user","info5094","paths");
          if (mysqli_connect_errno()) {
              echo "Unable to connect to MySQL! ". mysqli_connect_error();
              exit();
          }

          $path_name = $csv[0];
          $operating_frequency = $csv[1];
          $pi_description = $csv[2];
          $pi_note = $csv[3];

          $sqli = "INSERT INTO path_info (path_name,operating_frequency,pi_description,pi_note) VALUES ('{$path_name}','{$operating_frequency}','{$pi_description}','{$pi_note}')";
          $result = mysqli_query($con,$sqli);
          if ($result) {
              echo "File has been uploaded";
          };

          $pb_distance = $csv[4];
          $pb_ground_height = $csv[5];
          $pb_antenna = $csv[6];
          $pb_cable_type = $csv[7];
          $pb_cable_length = $csv[8];

          $sqli = "INSERT INTO path_beginning (pb_distance,pb_ground_height,pb_antenna,pb_cable_type,pb_cable_length) VALUES ('{$pb_distance}','{$pb_ground_height}','{$pb_antenna}','{$pb_cable_type}','{$pb_cable_length}')";
          $result = mysqli_query($con,$sqli);
          if ($result) {
              echo "File has been uploaded";
          };

          $pe_distance = $csv[9];
          $pe_ground_height = $csv[10];
          $pe_antenna = $csv[11];
          $pe_cable_type = $csv[12];
          $pe_cable_length = $csv[13];

          $sqli = "INSERT INTO path_ending (pe_distance,pe_ground_height,pe_antenna,pe_cable_type,pe_cable_length) VALUES ('{$pe_distance}','{$pe_ground_height}','{$pe_antenna}','{$pe_cable_type}','{$pe_cable_length}')";
          $result = mysqli_query($con,$sqli);
          if ($result) {
              echo "File has been uploaded";
          };
          $loop = count($csv) - 13;
          for ($i = 14; $i < $loop; $i++) {
            $md_distance = $csv[i];
            $i++;
            $md_ground_height = $csv[i];
            $i++;
            $md_terrain = $csv[i];
            $i++;
            $md_obstr_height = $csv[i];
            $i++;
            $md_obstr_type = $csv[i];
            $sqli = "INSERT INTO mid_points (md_distance,md_ground_height,md_terrain,md_obstr_height,md_obstr_type) VALUES ('{$md_distance}','{$md_ground_height}','{$md_terrain}','{$md_obstr_height}','{$md_obstr_type}')";
            $result = mysqli_query($con,$sqli);
            if ($result) {
                echo "File has been uploaded";
            };
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
