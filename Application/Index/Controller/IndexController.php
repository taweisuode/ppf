<?php
    class IndexController extends Controller {
        public function indexAction() {
            $this->load('Common/Function');
            $str = "hello_aaa.html";
            daddslashes($str,1);
            
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
