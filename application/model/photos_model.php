<?php

class PhotosModel
{

    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    //This method is not working yet. But you will need to write it.
    public function getAllPhotos()
    {
        $sql = "SELECT * FROM photos";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function deleteAllPhotos()
    {
        $files = glob(UPLOAD_PATH .'*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
            }
        $sql = "TRUNCATE TABLE photos";
        $this->db->query($sql);
        header('location: ' . URL . 'photos/index');
    }
    public function uploadPhoto()
   {
        $return = array('0' => true);

        $target_file = UPLOAD_PATH . basename($_FILES["fileToUpload"]["name"]);

        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check == false) {
                $return = array('0' => false,'1' => 'bestand is ongeldig' );
                return $return;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $return = array('0' => false,'1' => 'bestand bestaat al' );
            return false;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 3*1024*1024) {
            $return = array('0' => false,'1' => 'bestand is te groot ' . $_FILES["fileToUpload"]["size"] );
            return $return;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "jpeg") {
            $return = array('0' => false,'1' => 'bestand in verkeerde extensie' . $imageFileType);
            return $return;
        }

        if ($this->getLonglat()['0'] == false) {
          return $this->getLonglat();
        } else {
          $lat = $this->getLonglat()['lat'];
        $lng = $this->getLonglat()['lng'];
  
        }

        // $file = $this->deleteLongLat($_FILES["fileToUpload"]["tmp_name"]);

        if ($this->deleteLongLat($_FILES["fileToUpload"]["tmp_name"])) {

            $sql = "INSERT INTO photos (location, lat, lng) VALUES (:location, :lat, :lng)";
            $query = $this->db->prepare($sql);
            $parameters = array(':location' => $target_file, ':lat' => $lat, ':lng' => $lng);

            // useful for debugging: you can see the SQL behind above construction by using:
            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

            $query->execute($parameters);

            $return = array('0' => true,'1' => '<a target="_blank" href="http://maps.google.nl/?q='.  $lat . ', '. $lng. '">locatie zien</a>' );
            return $return;
        } else {
            $return = array('0' => false,'1' => 'uploaden mislukt' );
            return $return;
        }
        
    }
    private function getLongLat()
    {
        $data = exif_read_data($_FILES["fileToUpload"]["tmp_name"]);
        
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();


        if (isset($data['GPSLatitude']) && isset($data['GPSLongitude']) &&
            isset($data['GPSLatitudeRef']) && isset($data['GPSLongitudeRef']) &&
            in_array($data['GPSLatitudeRef'], array('E','W','N','S')) && in_array($data['GPSLongitudeRef'], array('E','W','N','S'))) {

            $GPSLatitudeRef  = strtolower(trim($data['GPSLatitudeRef']));
            $GPSLongitudeRef = strtolower(trim($data['GPSLongitudeRef']));

            $lat_degrees_a = explode('/',$data['GPSLatitude'][0]);
            $lat_minutes_a = explode('/',$data['GPSLatitude'][1]);
            $lat_seconds_a = explode('/',$data['GPSLatitude'][2]);
            $lng_degrees_a = explode('/',$data['GPSLongitude'][0]);
            $lng_minutes_a = explode('/',$data['GPSLongitude'][1]);
            $lng_seconds_a = explode('/',$data['GPSLongitude'][2]);

            $lat_degrees = $lat_degrees_a[0] / $lat_degrees_a[1];
            $lat_minutes = $lat_minutes_a[0] / $lat_minutes_a[1];
            $lat_seconds = $lat_seconds_a[0] / $lat_seconds_a[1];
            $lng_degrees = $lng_degrees_a[0] / $lng_degrees_a[1];
            $lng_minutes = $lng_minutes_a[0] / $lng_minutes_a[1];
            $lng_seconds = $lng_seconds_a[0] / $lng_seconds_a[1];

            $lat = (float) $lat_degrees+((($lat_minutes*60)+($lat_seconds))/3600);
            $lng = (float) $lng_degrees+((($lng_minutes*60)+($lng_seconds))/3600);

            //If the latitude is South, make it negative. 
            //If the longitude is west, make it negative
            $GPSLatitudeRef  == 's' ? $lat *= -1 : '';
            $GPSLongitudeRef == 'w' ? $lng *= -1 : '';

            $return = array('0' => true , 'lat'=> $lat, 'lng'=>$lng);

        }
        else { 
            $return = array('0' => false,'1' => 'geen gps data gevonden' );
        }
        return $return;;
    }

    private function deleteLongLat($photo)
    {   
        $target_file = UPLOAD_PATH . basename($_FILES["fileToUpload"]["name"]);
        $newphoto = imagecreatefromjpeg($photo);
        $exif = exif_read_data($_FILES["fileToUpload"]["tmp_name"]);

        if ($exif['Orientation'] != 1) {
          $newphoto =  imagerotate($newphoto, 270, 0);
        }


        $locatie = UPLOAD_PATH . basename($_FILES["fileToUpload"]["name"], '.'.pathinfo($target_file,PATHINFO_EXTENSION)) . '.jpg';
        // $newphotoname = UPLOAD_PATH . basename($_FILES["fileToUpload"]["name"], $extensie);
        return imagejpeg($newphoto,$locatie);
        

    }
}