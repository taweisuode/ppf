<?php
    /**
     * @desc 测试模块，收藏一切 重要的有用的有趣的代码段
     *
     */
    class ExceptionController extends Controller {
        /**
         * @desc 单元格合并代码
         */
        public function indexAction() {
            $this->load('Common/Function');
            $test = 1;
            if($test == 1) {
                throw new FrameException("", ErrorCode::test);
            }
            $this->view->assign("result","hello world!");
            $this->view->assign('signArr',$signArr);
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
