<?php
/**
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Anthony VIOLET
 * @version     SimpleFM 1.0 - 20/04/2020
 * @since       SimpleFM 1.1 - 23/04/2020
 * @contributor
*/

class CRUD {

    static function list($model, $request, $fields = array()){
        $return = strtolower($model).'s';
        $perPage = 10;
        $controller = new Controller($request);
        $controller->loadModel($model);
        if($fields) {
            $data['data'] = $controller->$model->find(array(
                'fields' => $fields,
                'limit' => ($perPage * ($controller->request->page-1)).', '.$perPage
            ));
        }else{
            $data['data'] = $controller->$model->find(array(
                'limit' => ($perPage * ($controller->request->page-1)).', '.$perPage
            ));
        }
        $data['total'] = $controller->$model->findCount();
        $data['pages'] = ceil($data['total'] / $perPage);
        if($model == "Post"){
            $data['model'] = "new";
        }else{
            $data['model'] = $model;
        }
        $controller->render('_CRUD', $data);
    }

    static function edit($model, $request, $id) {
        $controller = new Controller($request);
        $controller->loadModel($model);
        if($id === null){
            if($model == "Post"){
                $post = $controller->$model->findFirst(array(
                   'conditions' => array(
                       'online' => -1
                   )
                ));
                if(!empty($post)) {
                    $id = $post->id;
                }
                $controller->$model->save(array(
                    'online' => -1
                ));
                $id = $controller->$model->id;
            }
        }
        $data['id'] = "";
        $html = "";
        if($controller->request->data){
           if($controller->$model->validate($controller->request->data)){
               $controller->$model->save($controller->request->data);
               $id = $controller->$model->id;
               $controller->Sessions->set_flash("Le contenu à bien été modifier", "success");
               $controller->redirect('admin/news/index');
           }else{
               $html .= "Attention, des erreurs se sont glissées. Une innatention peut-être ?";
               $html .= "<ol>";
               foreach ($controller->$model->errors as $key => $value) {
                   $html .= "<li>".$value."</li>";
               }
               $html .= "</ol>";
               $controller->Sessions->set_flash($html, "warning");
           }
        }

        if($id) {
            $controller->request->data = $controller->$model->findFirst(array(
               'conditions' => array('id' => $id)
            ));
            $data['id'] = $id;
        }
        $controller->set($data);
    }

    static function delete($model, $request, $id) {
        $controller = new Controller($request);
        $controller->loadModel($model);
        if($model == "Media"){
            $file = $controller->$model->findFirst(array(
                'conditions' => array('id' => $id)
            ));
            if(file_exists(ROOT.DS.'assets/img/'.$file->file)) {
                unlink(ROOT.DS.'assets/img/'.$file->file);
            }else{
                die('on trouve pas le fichier..."'.ROOT.DS.'assets/img/'.$file->file.'"');
            }
        }
        $controller->$model->delete($id);
    }
}
