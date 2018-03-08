<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/15
 * Time: 15:27
 */

namespace backend\models;
use yii\db\ActiveRecord;


class AloneSpec extends ActiveRecord{

    /**
     * 子商品规格表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_alone_spec}}';
    }

    //关联商品
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['id' => 'goods_id']);
    }

}