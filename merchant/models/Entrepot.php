<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/9
 * Time: 15:07
 */
namespace merchant\models;

use yii\db\ActiveRecord;
use yii\db\Expression;


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


    //返回仓库名称
    public static function return_name($id){
          $result = Entrepot::find()->where(['id'=>$id])->select('entrepot_name')->one();
          return $result['entrepot_name'];
    }
    //返回仓库注册时间
    public static function return_time($id){
        $result = Entrepot::find()->where(['id'=>$id])->select('add_time')->one();
        return $result['add_time'];
    }
    //返回仓库状态
    public static function return_status($id){
        $result = Entrepot::find()->where(['id'=>$id])->select('status')->one();
        if($result['status'] == 0){
            return "<b style='color: red'>已冻结</b>";
        }else{
            return "正常";
        }

    }

}