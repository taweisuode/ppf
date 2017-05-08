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
            $indexModel = new IndexModel();
            $movie_list = $indexModel->test();

            $fruit = array("loving"=>'banana',"hating"=>'apple',"no_sense"=>'orange');
            $test = array(
                "aaa" => array(
                    "yes" => "no",
                    "sad" => 'happy'
                ),
                "bbb" => array(
                    "one" => "two",
                    "three"=> "four"
                )
            );
            $this->view->assign("movie_list",$movie_list);
            $this->view->assign("fruit",$fruit);
            $this->view->assign("test",$test);
            $this->view->assign("result","hello");
            $this->view->show();
        }

    }
?>
