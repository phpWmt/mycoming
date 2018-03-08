<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/9
 * Time: 15:07
 */
namespace merchant\models;

use yii\db\ActiveRecord;
use merchant\models\Entrepot;

class Clientele extends ActiveRecord
{

    /**
     * 仓库用户表
     * @return string
     */
    public static function tableName()
    {
        return '{{%clientele}}';
    }


    //关联用户
    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    //返回仓库名称
    public static function return_entrepot($id)
    {
        $result = Entrepot::find()->where(['id'=>$id])->select('entrepot_name')->asArray()->one();
        return $result['entrepot_name'];
    }

}