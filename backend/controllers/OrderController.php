<?php
/**
 * Created by PhpStorm.
 * User: damai
 * Date: 2017/9/11
 * Time: 13:30
 */

namespace backend\controllers;


use backend\models\EntrepotGoods;
use backend\models\Goods;
use backend\models\Order;
use backend\models\OrderDetail;
use backend\models\OrderRecord; //发货记录
use backend\models\OrderPay; //收款记录
use backend\models\EntrepotGoodsSpec;//仓库规格ID
use backend\models\OrderDetailed;//订单出入库明细
use backend\models\Comment;//评论表
use backend\models\Courier;//快递公司
use yii\data\Pagination;
use yii\web\Response;
use yii\helpers\Url;
use Yii;



Class OrderController extends CommonController
{
    protected $request;

    public function init()
    {
        $this->request = \Yii::$app->request;
    }


    /**显示列表
     *
     * @return string
     */
    public function actionIndex()
    {
        $order = Order::find();

        $order_status =  Yii::$app->request->get('order_status');

        //查询条件
        if(!empty($order_status)){
            if($order_status != '00'){
                $order_status === '01' ? $order_status = 0 : $order_status;

                $order->andWhere(['dyd_order.order_status' =>$order_status]);
            }
        }

        //订单号检索
        $keyword = $this->request->get('keyword');
        if(!empty($keyword)){
            $order->andwhere(['or', ['like', 'order_num', trim($keyword)]]);
        }

        $order->andWhere(['dyd_order.user_del' => '0']);

        $order->joinWith('entrepot'); //所属仓库
        $order->joinWith('user');

        $page  = new Pagination(['totalCount' => $order->count(), 'pageSize' => 15]);
        $lists = $order->offset($page->offset)
            ->limit($page->limit)
            ->orderBy('id DESC')->all();

        return $this->render('index', ['lists' => $lists, 'pages' => $page,'order_status'=>$order_status]);
    }




    //订单详情
    public function actionShow()
    {
        $id    = $this->request->get('id');
        if(\Yii::$app->request->isGet){

            //实例化
            $order   =  Order::find();

            $orderDetail = OrderDetail::find();

            $order->where(['dyd_order.id'=>$id]); //条件
            $order->joinWith('detail'); //订单详情
            $order->joinWith('user'); //用户
            $order->joinWith('address'); //收货地址
            $order->joinWith('entrepot'); //所属仓库

            $lists = $order->asArray()->one();

            //关联商品表 查询商品详情
            foreach ($lists['detail'] as $key=>$v){
                $lists['detail'][$key]['img'] = Goods::find()->where(['id'=>$v['goods_id']])->asArray()->one();
            }

            //快递公司
            $GodownTypeb = Courier::find()->where(['is_show'=>1])->asArray()->all();

            return $this->render('show', ['order' => $lists,'id'=>$id,'GodownTypeb'=>$GodownTypeb]);
        }else{

            \Yii::$app->getSession()->setFlash('success', '参数错误！');

            return $this->redirect(['order/index']);
        }

    }




    //订单发货 添加发货记录 收款记录  出入库明细
    public function actionOrderRecord(){
        $POST = \Yii::$app->request->post();

        //将多个一维数组合并成一个二维数组
        $a= $POST['egId'];
        $b= $POST['spec_id'];
        $c= $POST['spec'];
        $d= $POST['shop_price'];
        $e= $POST['shop_num'];

        foreach($a as $key=>$val){

            $data[$key]['goods_id']=$a[$key];


            $data[$key]['spec_id']=$b[$key];


            $data[$key]['spec']=$c[$key];

            $data[$key]['shop_price']=$d[$key];

            $data[$key]['shop_num']=$e[$key];
        }


        //填写订单信息
        $order = new Order();

        $resOrder = $order->updateAll([
            'order_status'=>1, //待收货
            'pay_money'=>$POST['pay_money'],
            'express'=>$POST['express'],
            'express_num'=>$POST['express_num'],
            'express_phone'=>$POST['express_phone'],
            'payment'=>$POST['payment'],
            'express_info'=>$POST['express_info'],
            'update_time'=>date('Y-m-d H:i:s'),
            ],['id'=>$POST['order_id']]);


        if($resOrder){
            //推送
            push($POST['user_id'],$POST['order_id'],"订单发货","您的订单已发货请注意查收！",1);

            //收款记录
            $res1 = $this->payMoney($POST['order_id'],$POST['price'],$POST['pay_money'],$POST['payment']);

            //发货记录
            $res2 = $this->delivery($POST['order_id'],$data);

            //出入库明细
            $res3 = $this->orderDetailed($POST['order_id'],$data);

            //返回添加商品规格
            if ($res1 && $res2 && $res3){
                //声明返回类型 json串
                \Yii::$app->response->format=Response::FORMAT_JSON;
                return ['status'=>1,'info'=>'发货成功！','url'=>Url::to(['order/index'])];
            }

        }else{
            return ['status'=>2,'info'=>'订单信息填写失败！'];
        }

    }



    //发货记录
    public function delivery($order_id,$data){

        $model = new OrderRecord();

        foreach ($data as $value){
            $_model = clone $model; //克隆对象
            $_model->order_id = $order_id;
            $_model->goods_id = $value['goods_id'];
            $_model->spec_id = $value['spec_id'];
            $_model->spec = $value['spec'];
            $_model->shop_price = $value['shop_price'];
            $_model->shop_num = $value['shop_num'];
            $resRecord= $_model->save(false);


            //减去规格库存
            //实例化仓库规格表
            $postGods = EntrepotGoodsSpec::findOne($value['spec_id']);  //实例化模型。传条件ID
            $resSpec = $postGods->updateCounters(['num'=>"-$value[shop_num]"]);  //updateCounters 实现 减法 值：
            //减去商品库存
            $EntrepotGoods = EntrepotGoods::findOne($value['goods_id']);
            $resGoods = $EntrepotGoods->updateCounters(['num'=>"-$value[shop_num]"]);
            //加上已售出数量
            $resGoodsAdd = $EntrepotGoods->updateCounters(['sold'=>"$value[shop_num]"]);  //自动加$value['shop_num']
        }

        if($resRecord && $resSpec && $resGoods && $resGoodsAdd){
            return true;
        }else{
            return ['status'=>2,'info'=>'发货记录添加失败！'];
        }
    }


    //收款记录
    public function payMoney($order_id,$price,$pay_money,$payment){
        $model = new OrderPay();

        $model->order_id= $order_id;

        $model->order_moner= $price;

        $model->pay_money= $pay_money;

        $model->payment= $payment;

        if($model->save(false)){
            return true;
        }else{
            return ['status'=>2,'info'=>'收款记录添加失败！'];
        }
    }


    //出入库明细
    public function orderDetailed($order_id,$data){
        $mode = new OrderDetailed();
        //入库
        foreach ($data as $value){
            $_model = clone $mode; //克隆对象
            $_model->number = "IN".-date('Ymd',time())."-".rand(1,10000);
            $_model->order_id= $order_id;
            $_model->goods_id = $value['goods_id'];
            $_model->spec = $value['spec'];
            $_model->num = "+$value[shop_num]";
            $_model->status = 2;
            $resRecord= $_model->save(false);
        }

        //返回
        if($resRecord){
            //出库
            foreach ($data as $value){
                $_model = clone $mode; //克隆对象
                $_model->number = "OUT".-date('Ymd',time())."-".rand(1,10000);
                $_model->order_id= $order_id;
                $_model->goods_id = $value['goods_id'];
                $_model->spec = $value['spec'];
                $_model->num = "-$value[shop_num]";
                $_model->status = 1;
                $resGoods= $_model->save(false);
            }
            if($resGoods){
                return true;
            }else{
                return ['status'=>2,'info'=>'出库明细添加失败！'];
            }

        }else{
            return ['status'=>2,'info'=>'入库明细添加失败！'];
        }


    }



    //查看出入库明细  发货明细 收款明细
    public function actionLook()
    {
        $id    = $this->request->get('id');
        if(\Yii::$app->request->isGet){


            //实例化
            $OrderDetailed   =  OrderDetailed::find(); //出入库明细
            $OrderPay = OrderPay::find();//收款记录
            $OrderRecord = OrderRecord::find();//发货记录
            $Comment = Comment::find();//订单评价

            $OrderDetailed->where(['dyd_order_detailed.order_id'=>$id]); //条件
            $OrderDetailed->joinWith('goods'); //仓库商品
            $OrderDetailed->joinWith('order'); //订单
            //出入库明细
            $listsDetailed = $OrderDetailed->asArray()->all();

            $OrderPay->where(['dyd_order_pay.order_id'=>$id]); //条件
            $OrderPay->joinWith('order'); //订单
            //收款记录
            $listsPay = $OrderPay->asArray()->all();


            $OrderRecord->where(['dyd_order_record.order_id'=>$id]); //条件
            $OrderRecord->joinWith('goods'); //仓库商品
            $OrderRecord->joinWith('order'); //订单
            //出入库明细
            $listsRecord = $OrderRecord->asArray()->all();

            //订单评价
            $Comment->where(['dyd_comment.order_id'=>$id]); //条件
            $Comment->joinWith('user'); //用户
            $Comment->joinWith('goods'); //商品
            $Comment->joinWith('entrepot'); //仓库
            //订单评价
            $listsComment = $Comment->asArray()->all();



            return $this->render('look', ['listsDetailed' => $listsDetailed,'listsPay'=>$listsPay,'listsRecord'=>$listsRecord,'listsComment'=>$listsComment]);

        }else{

            \Yii::$app->getSession()->setFlash('success', '参数错误！');

            return $this->redirect(['order/index']);
        }

    }


    /**搜索
     * @return string
     */
    public function actionSearch()
    {
        $keyword = $this->request->get('keyword');
        $order   = Order::find()->joinWith('user')
            ->where(['del' => '1'])
            ->andwhere(['or',
                        ['like', 'order_number', $keyword],
            ]);

        $page  = new Pagination(['totalCount' => $order->count(), 'pageSize' => 15]);
        $lists = $order->offset($page->offset)
            ->limit($page->limit)->orderBy('id DESC')->all();
        return $this->render('index', ['lists' => $lists, 'page' => $page]);
    }



    /**
     *删除 订单
     */
    public function actionDestroy()
    {

        //实例化
        $model = new Order();

        $resule = $model->updateAll(['user_del'=>1],['id'=>$this->request->post('id')]);


        //声明返回类型 json串
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if ($resule) {

            return ['status' => 1, 'info' => '删除成功！'];
        } else {
            return ['status' => 1, 'info' => '删除失败,请重试！'];
        }

    }




    //评论列表
    public function actionComment(){

        //实例化
        $Comment = Comment::find();

        //好评  中评 差评
        $grade =  Yii::$app->request->get('grade');

        //查询条件
        if(!empty($grade)){
            $Comment->andWhere(['dyd_comment.grade' =>$grade]);
        }

        //订单评价

        $Comment->joinWith('user'); //用户
        $Comment->joinWith('goods'); //商品
        $Comment->joinWith('entrepot'); //仓库
        //出入库明细
        $page  = new Pagination(['totalCount' => $Comment->count(), 'pageSize' => 15]);
        $listsComment = $Comment->offset($page->offset)
            ->limit($page->limit)
            ->orderBy('id DESC')->all();

        return $this->render('comment', ['page'=>$page,'listsComment'=>$listsComment]);

    }


    //删除评论
    public function actionCommentDel(){
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;

        $post=Yii::$app->request->post();

        //删除评论
        $result = Comment::deleteAll(['id'=>$post['id']]);

        if ($result){
            return ['status' => 1, 'info' => '删除成功'];
        }
    }

    //快递公司
    public function actionCourier(){
        $GodownTypeb = Courier::find()->asArray()->all();

        return $this->render('courier',['GodownTypeb'=>$GodownTypeb]);
    }

    //快递公司 显示或隐藏
    public function actionOperation(){
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
        $post=Yii::$app->request->post();

        //实例化
        $model = new Courier();

        //操作
        if($post['action'] == 'show'){//显示
            $res = $model->updateAll(['is_show'=>1],['id'=>$post['id']]);

        }else if($post['action'] == 'hide'){//隐藏

            $res = $model->updateAll(['is_show'=>0],['id'=>$post['id']]);
        }
        //返回
        if ($res){
            return ['status' => 1, 'info' => '操作成功'];
        }
    }

    //添加物流公司
    public function actionGodownType(){
        $request=Yii::$app->request;
        if ($request->isPost){
            Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
            $post=$request->post();
            $model=new Courier();
            $model->delivery_name	=$post['name'];
            $model->delivery_code	=$post['code'];
            $model->delivery_sort	=$post['sort'];
            $model->is_show	= 1;
            if($model->save(false)){
                return ['status' => 1, 'info' => '添加成功'];
            }
        }
    }

    //删除物流公司
    public function actionDelete()
    {
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;

        $post=Yii::$app->request->post();

        $model=new Courier();
        $res=$model::findOne($post['id'])->delete();

        if ($res){
            return ['status' => 1, 'info' => '删除成功'];
        }
    }

}