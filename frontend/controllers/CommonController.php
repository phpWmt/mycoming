<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;

class CommonController extends Controller
{

//    /**
//     * 构造方法：所有控制器都需继承
//     * CommonController constructor.
//     */
//   function __construct(){
//        //访问控制
//
//    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }



}
