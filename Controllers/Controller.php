<?php
class Controller{
    public function loadModel($action){
        return require '../Models/'.$action.'.php';
    }
}
?>