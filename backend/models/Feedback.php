<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/15
 * Time: 15:27
 */

namespace backend\models;
use yii\db\ActiveRecord;


class Feedback extends ActiveRecord{

    /**
     * 意见反馈
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%feedback}}';
    }

    //商品品牌
    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

}