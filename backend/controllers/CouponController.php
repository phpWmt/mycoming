<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/2/5
 * Time: 10:18
 */

namespace backend\controllers;

use Yii;
use backend\models\Coupon;
use backend\models\CouponSet;
use yii\data\Pagination;
use yii\web\Response;
use backend\models\User;


class CouponController extends CommonController
{

    protected $user;
    protected $request;

    public function init()
    {
        $this->user    = User::find();
        $this->request = \Yii::$app->request;
    }


    //优惠卷列表
    public function actionList(){
        $model = CouponSet::find();

        $get=Yii::$app->request->get();

        if (!empty($get['keyword'])){
            $model->andWhere(['like','name',trim($get['keyword'])]);
        }

        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $model->andWhere(['between','create_time',$get['start_time'],$get['end_time']]);
        }

        $count = $model->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 15]);
        $list = $model
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id desc')
            ->asArray()
            ->all();
        return $this->render('list',['list'=>$list,'pages'=>$pages]);
    }


    //添加优惠卷
    public function actionAdd(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model = new CouponSet();
            $model->creator = Yii::$app->admin->getIdentity()['username'];
            $model->name = $post['name'];
            $model->full_price = $post['max_price'];
            $model->cat_price = $post['deductible'];
            $model->type = $post['coupon_type'];
            $model->start_time = $post['begin_time'];
            $model->end_time = $post['end_time'];
            $model->create_time = date('Y-m-d H:i:s',time());

            if($model->save(false)){
                Yii::$app->getSession()->setFlash('success', '添加成功！');
                return $this->redirect(['coupon/list']);
            }
        }else{
            return $this->render('add');
        }

    }


    //单个 发放优惠卷
    public function actionIssue(){
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            $coupon = CouponSet::find()->where(['id'=>$post['coup_id']])->asArray()->one();

            //添加优惠卷
            $model =  new Coupon();
            $model->user_id = $post['id'];
            $model->coup_id = $coupon['id'];
            $model->full = $coupon['full_price'];
            $model->minus = $coupon['cat_price'];
            $model->addTime = $coupon['start_time'];
            $model->overTime = strtotime($coupon['end_time']);
            $result = $model->save(false);
            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($result){
                return ['status'=>1,'info'=>'发放成功'];
            }else{
                return ['status'=>2,'info'=>'发放失败'];
            }


        }else{
            //优惠卷ID
            $id = Yii::$app->request->get('id');
            $coupon = CouponSet::find()->where(['id'=>$id])->one();

            //判断是否已过期
            if(strtotime($coupon['end_time']) < time()){
                Yii::$app->getSession()->setFlash('success', '优惠卷已过期！');
                return $this->redirect(['coupon/list']);
            }

            //客户列表
            $this->user->where(['is_delete'=>1]);
            $page  = new Pagination(['totalCount' => $this->user->count(), 'pageSize' => 15]);
            $lists = $this->user->offset($page->offset)
                ->limit($page->limit)
                ->orderBy('id DESC')->all();
            return $this->render('issue',['lists'=>$lists,'pages'=>$page,'id'=>$id,'coupon'=>$coupon]);
        }
    }

    //全部发放
    public function actionAddCoupon(){
        $get = Yii::$app->request->get();

        if(Yii::$app->request->isGet){
            //优惠卷
            $coupon = CouponSet::find()->where(['id'=>$get['id']])->asArray()->one();

            //所有客户
            $this->user->where(['is_delete'=>1]);
            $lists = $this->user->asArray()->select('id')->all();

            //添加优惠卷
            $model =  new Coupon();
            foreach ($lists as $v){
                $_model=clone $model;
                $_model->user_id = $v['id'];
                $_model->coup_id = $coupon['id'];
                $_model->full = $coupon['full_price'];
                $_model->minus = $coupon['cat_price'];
                $_model->addTime = $coupon['start_time'];
                $_model->overTime = strtotime($coupon['end_time']);
                $res = $_model->save(false);
            }
            //返回
            if($res){
                Yii::$app->getSession()->setFlash('success', '全部发放成功！');
                return $this->redirect(['coupon/issue?id='.$get['id']]);
            }

        }else{
            Yii::$app->getSession()->setFlash('success', '系统参数错误！');
            return $this->redirect(['coupon/list']);
        }
    }

    //删除优惠卷
    public function actionDelete(){
        $request=Yii::$app->request;
        if ($request->isPost){
            $post =$request->post();

            //删除
            $result = CouponSet::deleteAll(['id'=>$post['id']]);

            Yii::$app->response->format=Response::FORMAT_JSON;

            if ($result){
                return ['status'=>1,'info'=>'删除成功'];
            }else{
                return ['status'=>2,'info'=>'删除失败'];
            }
        }
    }


    //统计图
    public function actionChart(){
        //优惠卷类型
        $listValue = CouponSet::find()->asArray()->all();

        $today_order_end="";
        foreach($listValue as $v){
            $today_order_end .= "'$v[name]'".",";
        }
        $today_order_ends =substr($today_order_end,0,-1);


        //实例化
        $coupon = new Coupon();

        //已发放优惠卷
        $couponMoney = $coupon::find()->select(['minus'])->sum('	minus');

        //已使用
        $couponYes = $coupon::find()->where(['isUse'=>1])->select(['minus'])->sum('minus');


        //未使用
        $couponNo = $coupon::find()->where(['isUse'=>0])->select(['minus'])->sum('minus');


        //每个红包发放数量
        foreach ($listValue as $value){
            $recha[] = array(
                'value'=>$coupon::find()->select(['minus'])->where(['coup_id'=>$value['id']])->sum('minus'),
                'name' => $value['name'],
            );
        }
        $datajson = json_encode($recha, JSON_UNESCAPED_UNICODE);


        return $this->render('cart',[
            'today_order_ends'=>$today_order_ends,
            'couponMoney'=>$couponMoney ? $couponMoney : '0',
            'couponYes'=>$couponYes ? $couponYes : '0',
            'couponNo'=>$couponNo ? $couponNo : '0',
            'datajson'=>$datajson,
        ]);
    }


}