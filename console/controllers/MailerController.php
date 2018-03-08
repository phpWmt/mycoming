<?php
namespace console\controllers;

use yii\console\Controller;

class MailerController extends Controller{
    public function actionSend(){
        file_put_contents(\Yii::getAlias('@backend').'/web/t.txt','111');
    }
}