<?php
namespace  merchant\models;


use yii\db\ActiveRecord;

class Comment extends ActiveRecord{

    /**
     * 评论表
     * @return string
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    //用户
    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    //所属仓库
    public function getEntrepot(){
        return $this->hasOne(Entrepot::className(),['id'=>'entrepot_id']);
    }

    //商品
    public function getGoods(){
        return $this->hasOne(Goods::className(),['id'=>'goodId']);
    }


}