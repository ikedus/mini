<?php

class PhotosModel
{

    //This method is not working yet. But you will need to write it.
    public function getAllPhotos()
    {
        $sql = "SELECT * FROM photos";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function uploadPhoto()
    {
        $target_file = UPLOAD_PATH . basename($_FILES["fileToUpload"]["name"]);

        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check == false) {
                //File is not an image, return false (todo: return an error message)
                return false;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            //File already exists, return false (todo: return an error message)
            return false;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            //File is to big, return false (todo: return an error message)
            return false;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            //File doesnt have proper extension, return false (todo: return an error message) 
            return false;
        }
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //File was succesfully uploaded, return true
            return true;
        } else {
            //File wasnt uploaded, return false (todo: return an error message)
            return false;
        }
        
    }
}