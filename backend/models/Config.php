<?php
/**
 * Created by PhpStorm.
 * User: damai
 * Date: 2017/9/5
 * Time: 7:34
 */

namespace backend\models;

use yii;


class Config extends yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%config}}';
    }

}