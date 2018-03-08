<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2017/12/14
 * Time: 16:02
 */

namespace frontend\controllers;

use yii\web\Controller;
use Yii;

class WxController extends Controller
{
    //微信公众号APPID
    public $appid = "wx538e4391cac53f07";
    //微信公众号APP_SECRET
    public $appsecret = "3b64f5ccb82c7eb5c67902886f0231cd";


    /**
     * 验证Token
     */
    public function actionValidation(){
        $echoStr = $_GET["echostr"];
        ob_clean();//核心就是这句 大概作用就是清除前面的输出缓冲区
        echo $echoStr;
        exit;
    }




    public function actionIndex()
    {

        echo 122;die;

    }

    public function GetIp()
    {
        $realip = '';
        $unknown = 'unknown';
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($arr as $ip) {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $realip = $ip;
                        break;
                    }
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
                $realip = $_SERVER['REMOTE_ADDR'];
            } else {
                $realip = $unknown;
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)) {
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } elseif (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)) {
                $realip = getenv("HTTP_CLIENT_IP");
            } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)) {
                $realip = getenv("REMOTE_ADDR");
            } else {
                $realip = $unknown;
            }
        }
        $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
        return $realip;
    }


    /**
     * 通过IP获取城市信息
     * @param  string $ip [description]
     * @return [type]     [description]
     */
    public function actionGetLookup($ip = '')
    {
        if (empty($ip)) {
            $ip = $this->GetIp();
        }
        $location = @file_get_contents('http://restapi.amap.com/v3/ip?key='.Yii::$app->params['AMAP_WEB_KEY'].'&ip=' . $ip);
        $json = json_decode($location, true);
        return $json['city'];
    }


    /**
     *
     * 获取微信access_token方法
     */
    private function actionGetToken()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->appsecret";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $access_token = json_decode($output, true);
        return $access_token["access_token"];
    }

    /**
     * 勿删勿改！
     * 微信公众号创建菜单
     */
    public function actionMenu()
    {
        $access_token = $this->actionGetToken();
        $jsonmenu='{
        "button": [
            {
                "type": "view",
                "name": "寻找代驾",
                "url": "http://wx.bixinchuxing.com"
            },
            {
                "name": "比心助手",
                "sub_button": [
                    {
                        "type": "view",
                        "name": "成为司机",
                        "url": "'.Yii::$app->params['ADMIN_HOST'].'/api/become-driver"
                    },
                    {
                        "type": "media_id",
                        "name": "加盟合作",
                        "media_id": "jULoC5crTHiyH5S06LwvwW-I8WzoHE6I91FI91_GbSs"
                    },
                    {
                        "type": "view",
                        "name": "司机版APP",
                        "url": "http://a.app.qq.com/o/simple.jsp?pkgname=com.damai.driver"
                    },
                    {
                        "type": "view",
                        "name": "用户版APP",
                        "url": "http://a.app.qq.com/o/simple.jsp?pkgname=com.damai.bixin"
                    }
                ]
            },
            {
                "name": "帮助中心",
                "sub_button": [
                    {
                        "type": "media_id",
                        "name": "关于我们",
                        "media_id": "jULoC5crTHiyH5S06Lwvwamx2CwmLgtASCNMcS-vAqk"
                    },
                    {
                        "type": "view",
                        "name": "个人中心",
                        "url": "http://wx.bixinchuxing.com/mypage/mypage?state=1"
                    },
                    {
                        "type": "media_id",
                        "name": "客服中心",
                        "media_id": "jULoC5crTHiyH5S06LwvwUeP5xFWnuwdQAmB8N_y3y8"
                    }
                ]
            },
        ]
    }';
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token;
        $result = $this->https_request($url, $jsonmenu);
        var_dump($result);
    }

    /**
     * @param $url 请求的地址
     * @param null $data 请求数据
     * @return mixed 返回的数据
     */
    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public function actionTest()
    {
        $city = OpenCity::find()
            ->where(['and', ['>', 'pid', 1], ['like', 'city', '成都']])
            ->asArray()
            ->one();
        var_dump($city);
        if (empty($city)) {
            echo 311;
        }
    }
    /**
     * 获取添加的永久素材信息
     * @return [type] [description]
     */
    private function actionGetMatter()
    {
        $access_token = $this->actionGetToken();
        $data='{
           "type":"news",
           "offset":0,
           "count":10
        }';
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=" .$access_token;
        $result = $this->https_request($url, $data);
        var_dump($result);
    }
}