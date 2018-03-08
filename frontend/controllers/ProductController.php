<?php
namespace frontend\controllers;

use Yii;



/**
 * Site controller
 */
class ProductController extends CommonController
{

    public $layout = 'home'; //布局文件
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
