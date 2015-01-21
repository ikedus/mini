<?php

/**
 * Class Songs
 * This is a demo class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class blog extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/songs/index
     */
    public function index()
    {
        $this->model = $this->loadModel("blog");
        // getting all songs and amount of songs
        $this->view->blogs = $this->model->getAllblogs();

       // load views. within the views we can echo out $songs and $amount_of_songs easily
        $this->view->render('blog/index');
    }

    public function view($blog_id)
    {
        $this->model = $this->loadModel("blog");
        // getting all songs and amount of songs
        $this->view->blog = $this->model->getblog($blog_id);

       // load views. within the views we can echo out $songs and $amount_of_songs easily
        $this->view->render('blog/view');
    }
    /**
     * ACTION: addSong
     * This method handles what happens when you move to http://yourproject/songs/addsong
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a song" form on songs/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to songs/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addblog()
    {   
        $this->model = $this->loadModel("blog");
        // if we have POST data to create a new song entry
        if (isset($_POST["submit_add_blog"])) {
            // do addSong() in model/model.php
            $this->model->addblog($_POST["auteur"], $_POST["titel"],  $_POST["content"]);
        }

        // where to go after song has been added
        header('location: ' . URL . 'blog/index');
    }

    /**
     * ACTION: deleteSong
     * This method handles what happens when you move to http://yourproject/songs/deletesong
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "delete a song" button on songs/index
     * directs the user after the click. This method handles all the data from the GET request (in the URL!) and then
     * redirects the user back to songs/index via the last line: header(...)
     * This is an example of how to handle a GET request.
     * @param int $song_id Id of the to-delete song
     */
    public function deleteblog($blog_id)
    {   
        $this->model = $this->loadModel("blog");
        // if we have an id of a song that should be deleted
        if (isset($blog_id)) {
            // do deleteSong() in model/model.php
            $this->model->deleteblog($blog_id);
        }


        // where to go after song has been deleted
        header('location: ' . URL . 'blog/index');
    }

     /**
     * ACTION: editSong
     * This method handles what happens when you move to http://yourproject/songs/editsong
     * @param int $song_id Id of the to-edit song
     */
    public function editBlog($blog_id)
    {
        $this->model = $this->loadModel("blog");
        // if we have an id of a song that should be edited
        if (isset($blog_id)) {
            // do getSong() in model/model.php
            $this->view->blog = $this->model->getBlog($blog_id);

            // in a real application we would also check if this db entry exists and therefore show the result or
            // redirect the user to an error page or similar

            // load views. within the views we can echo out $song easily
            $this->view->render('blog/edit');
        } else {
            // redirect user to songs index page (as we don't have a song_id)
            header('location: ' . URL . 'blog/index');
        }
    }
    
    /**
     * ACTION: updateSong
     * This method handles what happens when you move to http://yourproject/songs/updatesong
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "update a song" form on songs/edit
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to songs/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function updateBlog()
    {   
        $this->model = $this->loadModel("blog");
        // if we have POST data to create a new song entry
        if (isset($_POST["submit_update_blog"])) {
            // do updateSong() from model/model.php
            $this->model->updateblog($_POST["auteur"], $_POST["titel"],  $_POST["content"], $_POST['blog_id']);
        }

        // where to go after song has been added
        header('location: ' . URL . 'blog/index');
    }

    /**
     * AJAX-ACTION: ajaxGetStats
     * TODO documentation
     */
    public function ajaxGetStats()
    {
        $this->model = $this->loadModel("songs");

        $this->amount_of_songs = $this->model->getAmountOfSongs();

        // simply echo out something. A supersimple API would be possible by echoing JSON here
        echo $this->amount_of_songs;
    }

}
