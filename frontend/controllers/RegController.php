<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/19 0019
 * Time: 22:30
 */

namespace frontend\controllers;


class RegController extends CommonController
{
    public $layout = 'home';    
    /**
     * 会员注册
     * @return \yii\web\Response
     */
    public function actionIndex(){

        return $this->render('index');
    }

}