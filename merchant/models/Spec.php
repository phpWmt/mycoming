<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/15
 * Time: 15:27
 */

namespace merchant\models;
use yii\db\ActiveRecord;


class Spec extends ActiveRecord{

    /**
     * 规格表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_spec}}';
    }

}