<?php

class Photos extends Controller
{

    /**
     * PAGE: index
     * This method handles showing the image upload form
     */
    public function index()
    {
        $this->view->render('photos/index');
    }


    /**
     * PAGE: upload
     * This method handles the actual file upload
     */
    public function deleteAll()
    {
    	$photos_model = $this->loadModel('Photos');
    	$photos_model->deleteAllPhotos();
    }
    public function addPhoto()
    {
        //load the photo model to handle upload
        $photos_model = $this->loadModel('Photos');
        //perform the upload method, put result (true or false) in $upload_succesfull
        $this->view->upload_succesfull = $photos_model->uploadPhoto();

        //exit();

        if ($this->view->upload_succesfull['0']) {
            $this->view->render('photos/succes');
        } else {
            $this->view->render('photos/fail');
        }
    }
}
