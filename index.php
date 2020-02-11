<?php
$con = mysqli_connect("localhost","lamp2user","info5094","paths");
if (mysqli_connect_errno()) {
echo "Unable to connect to MySQL! ". mysqli_connect_error();
exit();
}
if (isset($_POST['save'])) {
$target_dir = "uploads/";
$target_file = $target_dir . date("dmYhis") . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file);
/*
if($fileType['extension'] == "csv" ) {
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
$files = date("dmYhis") . basename($_FILES["file"]["name"]);
}else{
echo "Error Uploading File";
exit;
}
}else{
echo "File Not Supported";
exit;
}*/
$filename = $_POST['filename'];
$location = "uploads/" . $files;
$sqli = "INSERT INTO files (f_filename, f_location) VALUES ('{$filename}','{$location}')";
$result = mysqli_query($con,$sqli);
if ($result) {
echo "File has been uploaded";
};
}
?>

<h1>Upload and Download</h1>
<form class="form" method="post" action="" enctype="multipart/form-data">
<label class="label">Filename:</label>
<input type="text" name="filename" > <br/>
<label class="label">File:</label>
<input type="file" name="file" class="input"> <br/>
<button type="submit" name="save" class="btn"><i class="fa fa-upload fw-fa"></i> Upload</button>
</form>