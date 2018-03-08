<?php
/**
 * Created by PhpStorm.
 * User: damai
 * Date: 2017/9/11
 * Time: 13:43
 */

namespace merchant\models;


use yii\db\ActiveRecord;
use Yii;

Class Order extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**关联订单详情
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetail()
    {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'id']);

    }


    /**关联用户信息
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**管理用户地址
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }


    //所属仓库
    public function getEntrepot(){
        return $this->hasOne(Entrepot::className(),['id'=>'entrepot_id']);
    }




    /**返回订单状态
     *
     * @param $status
     *
     * @return string
     */
    static public function return_status($status)
    {
        switch ($status) {
            case 0:
                return "<span class='btn btn-primary btn-rounded btn-outline btn-xs'><i class='glyphicon glyphicon-dashboard'></i>&nbsp;待发货</span>";
                break;
            case 1:
                return "<span class='btn btn-success btn-rounded btn-outline btn-xs'><i class='glyphicon glyphicon-dashboard'></i>&nbsp;待收货</span>";
                break;
            case 2:
                return "<span class='btn btn-warning btn-rounded btn-outline btn-xs'><i class='glyphicon glyphicon-dashboard'></i>&nbsp;待评价</span>";
                break;
            case 3:
                return "<span class='btn btn-default btn-rounded btn-outline btn-xs'><i class='glyphicon glyphicon-dashboard'></i>&nbsp;已完成</span>";
                break;
            case 4:
                return "<span class='btn btn-danger btn-rounded btn-outline btn-xs'><i class='glyphicon glyphicon-dashboard'></i>&nbsp;已取消</span>";
                break;
        }
    }


    /**
     * 返回待发货订单
     *
     * @param $status
     *
     * @return string
     */
    static public function return_goods()
    {
        //查询待或订单
        $countOrder = Order::find()->where(['order_status'=>0,'user_del'=>0,'entrepot_id'=> Yii::$app->admin->getIdentity()['entrepot']])->count();
        echo $countOrder;
    }


    //返回两个时间戳相差天数 或小时
    public static function return_time($time){
        $second2 = strtotime($time);
        $second1 = time();

        $hour=floor(($second1-$second2)%86400/3600);

        $mins =floor(($second1-$second2)%86400%3600/60);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }

        //返回
        if($hour == 0){
            echo $mins."分钟前";
        }elseif (floor(($second1 - $second2) / 86400) == 0){
            echo $hour."小时前";
        }else{
            echo floor(($second1 - $second2) / 86400)."天前";
        }

    }



}