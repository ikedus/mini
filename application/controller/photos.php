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

    public function succes()
    {
        $this->view->render('photos/succes');
    }

    public function fail()
    {
        $this->view->render('photos/fail');
    }

    /**
     * PAGE: upload
     * This method handles the actual file upload
     */
    public function addPhoto()
    {
        //load the photo model to handle upload
        $photos_model = $this->loadModel('Photos');
        //perform the upload method, put result (true or false) in $upload_succesfull
        $upload_succesfull = $photos_model->uploadPhoto();

        if ($upload_succesfull) {
            header('location: ' . URL . 'photos/succes');
        } else {
            header('location: ' . URL . 'photos/fail');
        }
    }
}
