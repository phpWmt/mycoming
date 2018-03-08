<?php

namespace merchant\models;

use Yii;


/**
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property string $is_show
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     *仓库入库规格表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }


    //所属仓库
    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

}