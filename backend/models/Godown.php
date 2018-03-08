<?php

namespace backend\models;

use Yii;

/**
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property string $is_show
 */
class Godown extends \yii\db\ActiveRecord
{
    /**
     * 入库订单表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%godown}}';
    }

}