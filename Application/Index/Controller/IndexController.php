<?php
class IndexController extends Controller {
    public function indexAction() {
        $this->view->assign("test","hello world!");
        $this->view->show();
    }
}
?>
