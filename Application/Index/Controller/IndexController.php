<?php
class IndexController extends Controller {
    public function indexAction() {
        $indexModel = new IndexModel();
        $list = $indexModel->getIndexList();
        $this->view->assign("list",$list);
        $this->view->show();
    }
    public function addAction() {
        $indexModel = new IndexModel();
        $movie_list = $indexModel->test();

        $fruit = array("loving"=>'aaaa',"hating"=>'apple',"no_sense"=>'orange');
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
        $this->view->set_compile("111");
        $this->view->show();
    }
}
?>
