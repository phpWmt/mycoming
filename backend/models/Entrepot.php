<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/9
 * Time: 15:07
 */
namespace backend\models;

use yii\db\ActiveRecord;


class Entrepot extends ActiveRecord
{

    /**
     * 仓库表
     * @return string
     */
    public static function tableName()
    {
        return '{{%entrepot}}';
    }

}