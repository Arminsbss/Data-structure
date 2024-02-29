<?php
error_reporting(E_ERROR | E_PARSE);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the file was uploaded without errors
    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {

        // Check if the file size is within the limit (30 megabytes)
        $maxFileSize = 15 * 1024 * 1024;  // 30 megabytes in bytes
        if ($_FILES['fileInput']['size'] > $maxFileSize) {
            header('HTTP/1.1 400 Bad Request');
            exit();
        }

        // Get the values from the form
        $name = isset($_POST['textInput']) ? $_POST['textInput'] : '';
        $fileInfo = pathinfo($_FILES['fileInput']['name']);
        $extension = isset($fileInfo['extension']) ? $fileInfo['extension'] : '';

        // Replace spaces with dashes in the name
        $name = str_replace(' ', '-', $name);

        // Generate the file name as per the specified format
        $fileName = $name . '-' . date('Y-m-d-H-i') . '.' . $extension;

        // Move the uploaded file to the desired location with the generated name
        $uploadDirectory = 'uploads/';  // Change this to your desired directory
        $destination = $uploadDirectory . $fileName;

        if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $destination)) {
            // File uploaded successfully
            echo 'alright';
        } else {
            header('HTTP/1.1 500 Internal Server Error');
        }

    } else {
        header('HTTP/1.1 400 Bad Request');
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
}
exit();
