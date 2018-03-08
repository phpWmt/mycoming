<?php

namespace merchant\controllers;

use yii;
use yii\helpers\FileHelper;


class ClearController extends CommonController
{

    /**
     * 清除后台缓存
     * @return string
     */
    public function actionmerchant()
    {
        FileHelper::removeDirectory(yii::getAlias('@runtime/cache'));
        Yii::$app->response->format=yii\web\Response::FORMAT_JSON;
        return ['status'=>1,'info'=>'清理成功'];
    }

    /**
     * 清除前台缓存
     * @return string
     */
    public function actionFrontend()
    {
        FileHelper::removeDirectory(yii::getAlias('@frontend/runtime/cache'));
        Yii::$app->response->format=yii\web\Response::FORMAT_JSON;
        return ['status'=>1,'info'=>'清理成功'];
    }
}