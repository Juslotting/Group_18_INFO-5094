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

//Commented out because mysqli isn't working

/*$con = new mysqli_connect("localhost","lamp2user","info5094","paths");
if (mysqli_connect_errno()) {
    echo "Unable to connect to MySQL! ". mysqli_connect_error();
    exit();
}*/
session_start();

if (isset($_POST['save'])) {
    $target_dir = "/uploads";
    //$f is the opened and read file
    $f = fopen($_POST["file"]["tmp_name"], "r");
    //target file is the file, to move, use tmp_name instead of name
    $target_file = $_FILES["file"]["name"];
    //filetype is the extension (.csv)
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
    //checks if file is a csv
    if ($fileType == "csv") {
        if(move_uploaded_file($_FILES["file"]["tmp_name"])) {
            $csv = fgetcsv($f, 1000);
            echo $csv;
            //$csv should be the csv file with each line read into an array
            //here is where I was going to put each line into the database




            $filename = basename($_FILES["file"]["name"]);
            $location = "/uploads" . $filename;
            //Commented out because mysql isn't working
           /* $sqli = "INSERT INTO files (f_filename, f_location) VALUES ('{$filename}','{$location}')";
            $result = mysqli_query($con,$sqli);
            if ($result) {
                echo "File has been uploaded";
            };*/
        }
        else {
            echo "File failed to upload";
        }
    }
    else {
        echo "File not supported";
    }
}
?>

<h1>Upload and Download</h1>
<form class="form" method="post" action="" enctype="multipart/form-data">
<label class="label">File:</label>
<input type="file" name="file" class="input"> <br/>
<button type="submit" name="save" class="btn"><i class="fa fa-upload fw-fa"></i> Upload</button>
</form>


<?php

session_unset();
session_destroy();

?>