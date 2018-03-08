<?php

namespace merchant\controllers;

use common\help\ServerInfo;
use merchant\models\Clientele;
use Yii;
use merchant\models\User;
use merchant\models\Entrepot;
use merchant\models\Message;
use merchant\models\Order;
use yii\helpers\Url;

class MerchantIndexController extends CommonController
{

    //默认主页
    public function actionHome()
    {
        //仓库ID
        $entrepotId =  Yii::$app->admin->getIdentity()['entrepot'];

        //新订单通知
        $orderCount  = $this->tip();
        $url = Url::to(['merchant-order/index']);
        if(!empty($orderCount)){
            echo " 
                <div class=\"wrapper wrapper-content\" id='divids'>
                <div class=\"alert alert-info alert-dismissable\">
                 <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button>
                      当前有<b>$orderCount</b>个待发货订单！请尽快发货！
                     <a class=\"alert-link\" href=\"$url\">&nbsp;&nbsp;&nbsp;点击跳转</a>
                </div>
                </div>";
        }


        //客户统计
        //今日新增
        $beginToday= date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));
        $endToday=date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1);
        $dayCount =  Clientele::find()->where(['between', 'addTime', $beginToday, $endToday])->andWhere(['entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot'],'is_del'=>1])->count();

        //当月新增
        $month = date('Y-m',time());
        $monthCount = Clientele::find()->where(['like', 'addTime', $month])->andWhere(['entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot'],'is_del'=>1])->count();


        //客户总数
        $totalCount =  Clientele::find()->where(['entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot'],'is_del'=>1])->count();




        //财务统计
        //实例化
        $order = Order::find();

        //订单金额
        $orderMoney = $order->where(['order_status'=>1,'user_del'=>0,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->sum('price');

        //实收金额
        $orderPay = $order->where(['order_status'=>1,'user_del'=>0,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->sum('pay_money');


        //系统通知消息
        //实例化
        $message = Message::find();
        $message->joinWith('user');
        $userInfo = $message->where(['dyd_message.type'=>0])->asArray()->all();


        /*************
         *  图表统计
         */
        //订单统计
        $order_month=Order::find();
        //12个月
        for ($x=1; $x<=12; $x++) {
            if($x<=9){
                $xs = "0$x";
            }else{
                $xs = "$x";
            }
            $dataOrder[] = array( //已完成
                'time'=>date('Y-',time()).$xs,
                'name'=>$order_month->where(['like', 'create_time', date('Y-',time())."$xs"])->andWhere(['is_del'=>0,'user_del'=>0,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->count(),
            );
        }
        $today_order_start="";
        $today_order_month="";
        foreach($dataOrder as $v){
            $today_order_start.= "'$v[name]'".",";
            $today_order_month.="'$v[time]'".",";
        }
        $today_order_month =substr($today_order_month,0,-1);

        $today_order_start =substr($today_order_start,0,-1);


        //销量统计

        $order_month=Order::find();
        $order_month->where(false);
        //12个月
        for ($x=1; $x<=12; $x++) {
            if($x<=9){
                $xs = "0$x";
            }else{
                $xs = "$x";
            }
            $dataOrderSales[] = array( //已完成
                'time'=>date('Y-',time()).$xs,
                'price'=>$order_month->where(['like', 'create_time', date('Y-',time())."$xs"])->andWhere(['order_status'=>1,'user_del'=>0,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->sum('price'),
                'pay_money'=>$order_month->where(['like', 'create_time', date('Y-',time())."$xs"])->andWhere(['order_status'=>1,'user_del'=>0,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->sum('pay_money'),

            );
        }
        $today_sales_price="";
        $today_sales_pay_money="";
        $today_sales_month="";
        foreach($dataOrderSales as $v){
            $today_sales_price.= "'$v[price]'".",";
            $today_sales_pay_money.= "'$v[pay_money]'".",";

            $today_sales_month.="'$v[time]'".",";
        }
        $today_sales_month =substr($today_sales_month,0,-1);

        $today_sales_price =substr($today_sales_price,0,-1);

        $today_sales_pay_money =substr($today_sales_pay_money,0,-1);

        //最高值
        $salesCount = $order_month->where(['order_status'=>1,'user_del'=>0,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->sum('price');



        //返回
        return $this->render('home',[
            'dayCount'=>$dayCount,
            'monthCount'=>$monthCount,
            'totalCount'=>$totalCount,
            'orderMoney'=>$orderMoney,
            'orderPay'=>$orderPay,
            'userInfo'=>$userInfo,
            //订单统计
            'today_order_month'=>$today_order_month,
            'today_order_start'=>$today_order_start,
            //销量统计
            'today_sales_month'=>$today_sales_month,
            'today_sales_price'=>$today_sales_price,
            'today_sales_pay_money'=>$today_sales_pay_money,
            'salesCount'=>$salesCount,


        ]);
    }

    //左侧导航
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 订单提醒
     */
    public function tip(){
        //查询待或订单
        $countOrder = Order::find()->where(['order_status'=>0,'user_del'=>0,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->count();
        return $countOrder;
    }

}
