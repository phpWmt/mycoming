<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/9
 * Time: 15:07
 */
namespace backend\models;

use yii\db\ActiveRecord;


class Courier extends ActiveRecord
{

    /**
     * 快递公司
     * @return string
     */
    public static function tableName()
    {
        return '{{%courier}}';
    }

}