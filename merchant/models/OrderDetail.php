<?php
/**
 * Created by PhpStorm.
 * User: damai
 * Date: 2017/9/13
 * Time: 9:28
 */

namespace merchant\models;

use yii\db\ActiveRecord;

Class OrderDetail extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%order_detail}}';
    }


    public function getOrderDetail()
    {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'id']);
    }

//    //关联商品表
//    public function getGoods(){
//        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
//    }

    //关联商品表
    public function getGoods(){
        return $this->hasOne(EntrepotGoods::className(),['id'=>'goods_id']);
    }

    //关联订单表
    public function getOrder(){
        return $this->hasOne(Order::className(),['id'=>'order_id']);
    }

}