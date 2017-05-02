<?php
    /**
     * @desc 测试模块，收藏一切 重要的有用的有趣的代码段
     *
     */
    class IndexController extends Controller {
        /**
         * @desc 单元格合并代码
         */
        public function indexAction() {
            $this->load('Common/Function');
            $str = "hello_aaa.html";
            daddslashes($str,1);
            $signArr = $this->_testWeixinSign();
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
        /**
         * @desc 微信分享功能加签名
         * @remark 微信分享功能一定要建立在公众号开通了微信分享的功能才能对其自定义链接
         * @return array 签名数据
         */
        private function _testWeixinSign() {
            $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=%s&appid=%s&secret=%s";
            $tokenData = array(
                'grant_type' => client_credential,
                'appid'     =>  wxc4b77c360860c655,
                'secret'    => fad2d567b02f9daaa9a68cf75a0763a8
            );
            //echo $tokenUrl;die;
            $tokenUrl = sprintf($tokenUrl,$tokenData['grant_type'],$tokenData['appid'],$tokenData['secret']);
            $ret = $this->curlGet($tokenUrl);

            $tokenArr = json_decode($ret,true);
            $weixin['access_token'] = $tokenArr['access_token'];

            $ticketUrl = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=%s";
            $queryData = array(
                'access_token'  => $weixin['access_token'],
                'type'          => 'jsapi'
            );
            $ticketUrl = sprintf($ticketUrl,$queryData['access_token'],$queryData['type']);
            $ticketRes = $this->curlGet($ticketUrl);
            $ticketArr = json_decode($ticketRes,true);
            $weixin['ticket'] = $ticketArr['ticket'];

            $signSort = array();
            $signSort['noncestr'] = "sdfdsfwer233r23rfwe";
            $signSort['jsapi_ticket'] = $weixin['ticket'];
            $signSort['timestamp']    = time();
            $signSort['url'] =  "http://m.beta.fxtrip.cn/flight/index?oid=116364575";

            ksort($signSort);

            //拼接字符串
            $arg = "";
            while (list ($key, $val) = each($signSort)) {
                $arg .= $key . "=" . $val . "&";
            }
            $arg	= rtrim($arg,'&');
            $signArr['appId']     = $tokenData['appid'];
            $signArr['timestamp'] = $signSort['timestamp'];
            $signArr['nonceStr']  = $signSort['noncestr'];
            $signArr['sign'] =  sha1($arg);
            return $signArr;

        }

        /**
         * @desc curl来支持微信加签
         * @return json
         */
        private function curlGet($url) {
            //初始化
            $ch = curl_init();
            //设置选项，包括URL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            //执行并获取HTML文档内容
            return curl_exec($ch);
        }

    }
?>
