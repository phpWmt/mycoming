<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2017/11/15
 * Time: 15:10
 */

namespace frontend\controllers;


class PublicController extends CommonController
{
    public $layout = 'home'; //布局文件

    /**
     * 会员登录页面
     * @return string
     */
    public function actionLogin(){

        return $this->render('login');
    }

    /**
     * 会员退出
     */
    public function actionLout(){

       return $this->redirect('login');
    }
}