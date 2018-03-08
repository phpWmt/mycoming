<?php
/**
 * Created by PhpStorm.
 * User: damai
 * Date: 2017/9/5
 * Time: 7:34
 */

namespace merchant\models;

use yii;
use merchant\models\Order;
use merchant\models\Clientele;

class User extends yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function scenarios()
    {
        $scenario = parent::scenarios();
        return [
            'create' => ['username', 'password', 'phone', 'email', 'nickname'],
            'update' => ['username', 'password', 'phone', 'email', 'nickname'],
            'show' => ['id'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'create_time' => 'Create Time',
            'nickname' => 'Nickname',
            'status' => 'Status',
        ];
    }
    public function rules()
    {
        return [
            ['username', 'string', 'length' => [2, 16],'tooLong' => '长度限制为2-16字符', 'tooShort' => '长度限制为2-16字符','on' => 'create'],
            ['phone', 'unique', 'targetClass' =>'\merchant\models\User','message' => '该手机号已注册','on' => 'create'],
            ['phone','match','pattern'=>'/^[1][358][0-9]{9}$/','message'=>'请输入正确的手机号','on' => 'create'],
            ['email','match','pattern'=>'/^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/','message'=>'请输入正确的邮箱','on' => 'create'],
            ['nickname', 'string', 'length' => [4, 16],'tooLong' => '长度限制为4-16字符', 'tooShort' => '长度限制为4-16字符','on' => 'create'],
            ['password', 'string', 'length' => [6, 16],'tooLong' => '长度限制为4-16字符', 'tooShort' => '长度限制为6-16字符','on' => 'create'],

        ];
    }


    public function create($data)
    {
        $this->scenario = 'create';
        if ($this->load($data) && $this->validate()) {
            return true;
        } else {
            return false;
        }
    }

    //返回两个时间戳相差天数
    public static function return_time($time){
        $second1 = strtotime($time);
        $second2 = time();

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        echo floor(($second1 - $second2) / 86400);
    }

    //统计该用户下单数
    public static function count_shop($user_id){
        $orderCount = Order::find()->where(['user_id'=>$user_id])->count();
        echo $orderCount;
    }

    //统计该用户关注了几个仓库
    public static function count_entrepot($user_id){
        $ClienteleCount = Clientele::find()->where(['user_id'=>$user_id])->count();
        echo $ClienteleCount;
    }

}