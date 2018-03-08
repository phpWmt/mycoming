<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/15
 * Time: 15:27
 */

namespace backend\models;
use yii\db\ActiveRecord;


class CouponSet extends ActiveRecord{

    /**
     * 优惠卷列表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coupon_set}}';
    }


}