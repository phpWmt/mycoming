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
class EntrepotGoodsClassify extends \yii\db\ActiveRecord
{
    /**
     * 仓库商品分类
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entrepot_goods_classify}}';
    }

}