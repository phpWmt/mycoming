<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/7
 * Time: 13:13
 */

namespace backend\controllers;

use backend\models\Config;
use backend\models\UploadForm;
use backend\traits\AdminTrait;
use yii\web\Controller;
use yii\web\UploadedFile;

class OperationController extends Controller
{
    use AdminTrait;

    public function actionPay()
    {
        $wechat = $this->getConfig('wechat');
        $alipay = $this->getConfig('alipay');
        $yun    = $this->getConfig('yun');

        return $this->render('pay', ['wechat' => $wechat, 'alipay' => $alipay, 'yun' => $yun]);
    }

    /**
     *微信
     */
    public function actionWechat()
    {
        $request = \Yii::$app->request;
        $config  = Config::findOne('wechat');
        if ($config) {
            $config->info = json_encode($request->get());
            $config->save();
        } else {
            $seo       = new Config();
            $seo->name = 'wechat';
            $seo->info = json_encode($request->get());
            $seo->save();
        }
        \Yii::$app->getSession()->setFlash('success', '操作成功');
        $this->redirect(['operation/pay']);

    }

    /**
     *支付宝
     */
    public function actionAlipay()
    {
        $request = \Yii::$app->request;

        $config = Config::findOne('alipay');
        if ($config) {
            $config->info = json_encode($request->get());
            $config->save();
        } else {
            $seo       = new Config();
            $seo->name = 'alipay';
            $seo->info = json_encode($request->get());
            $seo->save();
        }
        \Yii::$app->getSession()->setFlash('success', '操作成功');
        $this->redirect(['operation/pay']);
    }

    /**
     *云之讯
     */
    public function actionYun()
    {
        $request = \Yii::$app->request;

        $config = Config::findOne('yun');
        if ($config) {
            $config->info = json_encode($request->get());
            $config->save();
        } else {
            $seo       = new Config();
            $seo->name = 'yun';
            $seo->info = json_encode($request->get());
            $seo->save();
        }
        \Yii::$app->getSession()->setFlash('success', '操作成功');
        $this->redirect(['operation/pay']);
    }

    public function actionSetting()
    {
        $fileName = '';
        $request  = \Yii::$app->request;
        if (\Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName('logo');
            if (!is_null($file)) {
                if (!file_exists('logo/')) {
                    mkdir('logo/', 0777, true);
                }
                $file->saveAs('logo/logo.png');
                $fileName = '/logo/logo.png';
            }
            $config = Config::findOne('site');

            $site['logo']    = $fileName;
            $site['name']    = $request->post('name');
            $site['contact'] = $request->post('contact');
            if ($config) {
                $config->info = json_encode($site);
                $config->save();
            } else {
                $seo       = new Config();
                $seo->name = 'site';
                $seo->info = json_encode($site);
                $seo->save();
            }
            \Yii::$app->getSession()->setFlash('success', '操作成功');

        }

        $site = $this->getConfig('site');

        return $this->render('setting', ['site' => $site]);
    }

    public function actionSetEdit()
    {

//        $request = \Yii::$app->request;
////        var_dump($request->());
////        $model = new UploadForm();
//
//
//        $logo = UploadedFile::getInstanceByName('logo');
//        var_dump($logo);
//        die;
//        if ($model->upload()) {
//            // 文件上传成功
//            return;
//        }
//

    }
}