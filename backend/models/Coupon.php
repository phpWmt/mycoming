<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/15
 * Time: 15:27
 */

namespace backend\models;
use yii\db\ActiveRecord;


class Coupon extends ActiveRecord{


    /**
     * 发放优惠卷
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coupon}}';
    }



    //查询用户是否已发放
    public static function return_status($uId,$cId){
        $result = Coupon::find()->where(['user_id'=>$uId,'coup_id'=>$cId])->select('id')->asArray()->one();
       if(empty($result)){
            echo "<a class=\"btn btn-info btn-rounded btn-outline btn-xs\" href=\"buttons.html#\">未发放</a>";
       }else{
           echo "<a class=\"btn btn-success btn-rounded btn-outline btn-xs\" href=\"buttons.html#\">已发放</a>";
       }

    }



}