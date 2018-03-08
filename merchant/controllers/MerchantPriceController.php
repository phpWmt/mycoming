<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/2/6
 * Time: 16:53
 */

namespace merchant\controllers;

use merchant\models\OrderPay;
use merchant\models\Order;
use Yii;
use yii\data\Pagination;


class MerchantPriceController extends CommonController
{

    //列表
    public function actionList(){


        //仓库ID
        $entrepot_id = Yii::$app->admin->getIdentity()['entrepot'];

        //实例化
        $model = Order::find();

        $get=Yii::$app->request->get();

        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $model->andWhere(['between','create_time',$get['start_time'],$get['end_time']]);
        }

        $model->andWhere(['order_status'=>1,'user_del'=>0,'entrepot_id'=>$entrepot_id]);
        $count = $model->count();
        $page  = new Pagination(['totalCount' =>$count, 'pageSize' => 15]);
        $lists = $model->offset($page->offset)
            ->limit($page->limit)
            ->orderBy('id DESC')
            ->select('id,payment,price,pay_money,create_time,update_time')
            ->asArray()
            ->all();

        return $this->render('list', ['list' => $lists, 'pages' => $page]);
    }


    //统计图
    public function actionChart(){
        $order_month=Order::find();
        //12个月
        for ($x=1; $x<=12; $x++) {
            if($x<=9){
                $xs = "0$x";
            }else{
                $xs = "$x";
            }
            $dataOrder[] = array( //已完成
                'time'=>date('Y-',time()).$xs.'月',

            );
            $recha[] = array(
                'value'=>$order_month->where(['like', 'create_time', date('Y-',time())."$xs"])->andWhere(['is_del'=>0,'user_del'=>0,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->sum('price'),
                'name' => date('Y-',time()).$xs.'月',
            );

            $recha1[] = array(
                'value'=>$order_month->where(['like', 'create_time', date('Y-',time())."$xs"])->andWhere(['is_del'=>0,'user_del'=>0,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->sum('pay_money'),
                'name' => date('Y-',time()).$xs.'月',
            );


        }


        if(!empty($recha)){
            $today_order_start = json_encode($recha, JSON_UNESCAPED_UNICODE);
        }


        if(!empty($recha1)){
            $today_order_pay_money = json_encode($recha1, JSON_UNESCAPED_UNICODE);
        }


        //12月
        $today_order_month="";
        foreach($dataOrder as $v){
            $today_order_month.="'$v[time]'".",";
        }
        $today_order_month =substr($today_order_month,0,-1);

        return $this->render('chart',[
            'today_order_month'=>$today_order_month,
            'today_order_start'=>$today_order_start,
            'today_order_pay_money'=>$today_order_pay_money,

        ]);
    }



}