<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/15
 * Time: 15:27
 */

namespace merchant\models;
use yii\db\ActiveRecord;


class OrderPay extends ActiveRecord{

    /**
     * 规格表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_pay}}';
    }

    //关联订单表
    public function getOrder(){
        return $this->hasOne(Order::className(),['id'=>'order_id']);
    }
}