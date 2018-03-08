<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/9
 * Time: 15:07
 */
namespace backend\models;

use yii\db\ActiveRecord;


class OrderRecord extends ActiveRecord
{

    /**
     * 发货记录
     * @return string
     */
    public static function tableName()
    {
        return '{{%order_record}}';
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