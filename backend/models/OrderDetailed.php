<?php
namespace backend\models;

use yii\db\ActiveRecord;

class OrderDetailed extends ActiveRecord{

    /**
     * 订单出入库明细表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_detailed}}';
    }

    //关联商品表
    public function getGoods(){
        return $this->hasOne(EntrepotGoods::className(),['id'=>'goods_id']);
    }

    //关联订单表
    public function getOrder(){
        return $this->hasOne(Order::className(),['id'=>'order_id']);
    }

}