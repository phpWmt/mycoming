<?php
/**
 * Created by PhpStorm.
 * User: damai
 * Date: 2017/9/14
 * Time: 17:17
 */

namespace backend\controllers;

use backend\models\Config;
use backend\traits\AdminTrait;

Class SeoController extends CommonController
{
    use AdminTrait;

    public function actionIndex()
    {
        $seo = $this->getConfig('seo');

        return $this->render('index', ['seo' => $seo]);
    }

    public function actionUpdate()
    {
        $request = \Yii::$app->request;
        $config  = Config::findOne('seo');
        if ($config) {
            $config->info = json_encode($request->get());
            $config->save();
        } else {
            $seo       = new Config();
            $seo->name = 'seo';
            $seo->info = json_encode($request->get());
            $seo->save();
        }
    }
}