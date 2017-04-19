<?php
    class IndexController extends Controller {
        public function indexAction() {
            $this->view->assign("result","hello world!");
            $this->view->show();
        }
        public function addAction() {
            //$indexModel = new IndexModel();
            //$result = $indexModel->test();
            $fruit = array("loving"=>'banana',"hating"=>'apple',"no_sense"=>'orange');
            $this->view->assign("fruit",$fruit);
            $this->view->assign("result","hello");
            $this->view->show();
        }

    }
?>
