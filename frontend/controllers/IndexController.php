<?php
namespace frontend\controllers;

use yii\web\Controller;
use Yii;



/**
 * Site controller
 */
class IndexController extends Controller
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
