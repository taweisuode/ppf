<?php
    class IndexController extends Controller
    {
        public function indexAction()
        {
            echo 111;die;
            $test = "orange";
            $this->assign("fruit",$test);
            $this->view->show();
        }
        public function addAction()
        {
            $addModel = new Index_IndexModel();
            $result = $addModel->getName('管理员');
            $max = 4;
            $this->view->assign("max",$max);
            //echo "<pre>";
            //var_dump($result);die;
            //$test = "test";
            //$this->view->assign('add',$test);
            $fruit = array("loving"=>'banana',"hating"=>'apple',"no_sense"=>'orange');
            $this->view->assign("fruit",$fruit);
            $this->view->show();
        }
    }
?>
