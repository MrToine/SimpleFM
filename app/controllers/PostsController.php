<?php
class PostsController extends Controller {

    function index() {
        $this->view();
    }

    function view($id = 1) {
        $this->loadModel('Posts');

        $posts = $this->Posts->findFirst(array(
            'conditions' => array('id' => $id)
        ));
        if(empty($posts)){
            die("error");
        }
        $this->set('posts', $posts);
        $this->render('posts');
    }
}
?>
