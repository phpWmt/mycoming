<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/9
 * Time: 14:55
 */

namespace backend\controllers;

use Yii;
use yii\data\Pagination;
use backend\models\Entrepot;

//出入库模型
use backend\models\EntrepotGoods;//仓库入库商品
use backend\models\EntrepotGoodsSpec;//商品入库规格子表
use backend\models\EntrepotSpec;//商品入库规格表
use backend\models\EntrepotGoodsClassify;//仓库商品分类
use backend\models\Godown;//入库订单表
use backend\models\GodownDetail;//出入库明细
use backend\models\Goods;
use backend\models\AloneSpec; //子商品规格表
use yii\web\Response;
use backend\models\Admin;
use merchant\models\Clientele;
use backend\models\Comment;


class WarehouseController extends CommonController
{

    //仓库列表
    public function actionIndex(){
        $model = Entrepot::find();
        $get=Yii::$app->request->get();

        if (!empty($get['keyword'])){
            $model->andWhere(['like','entrepot_name',trim($get['keyword'])]);
        }

        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $model->andWhere(['between','create_time',$get['start_time'],$get['end_time']]);
        }

        if (!empty($get['cate_id'])){
            $cate=Cate::find()->select('id')->where(['pid'=>$get['cate_id']])->asArray()->all();
            if (!empty($cate)){
                $cate=array_column(Cate::find()->select('id')->where(['pid'=>$get['cate_id']])->asArray()->all(),'id');
                $model->andWhere(['in','cate_id',$cate]);
            }else{
                $model->andWhere(['cate_id'=>$get['cate_id']]);
            }
        }


        $count = $model->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $list = $model
            ->offset($pages->offset)
            ->andWhere(['is_delete'=>1])
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('index', ['list' => $list, 'pages' => $pages]);
    }


    //添加仓库
    public function actionAdd(){

       if(Yii::$app->request->isPost){
           $post=Yii::$app->request->post();
           //分割经纬度
           $location = explode(',',$post['location']);
           //添加仓库
           $model = new Entrepot();
           $model->entrepot_name = $post['entrepot_name'];
           $model->phone = $post['phone'];
           $model->entrepot_num = $this->number();
           $model->entrepot_address = $post['entrepot_address'];
           $model->lng = $location['0'];
           $model->lat = $location['1'];
           $model->status	 = 1;
           $model->is_delete = 1;
           $model->add_time = date('Y-m-d H:i:s');
           if($model->save()){
               Yii::$app->getSession()->setFlash('success', '添加成功！');
               return $this->redirect(['warehouse/index']);
           }else{
               Yii::$app->getSession()->setFlash('success', '添加失败');
               return $this->redirect(['warehouse/add']);
           }

       }else{
           return $this->render('add');
       }

    }


    //修改仓库
    public function actionEditor(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model = new Entrepot();
            $resule = $model->updateAll(
                [
                    'entrepot_name'=>$post['entrepot_name'],
                    'phone'=>$post['phone'],
                    'entrepot_address'=>$post['entrepot_address'],
                    'lng'=>$post['lng'],
                    'lat'=>$post['lat'],
                ],
                ['id'=>$post['id']]);

            if($resule){
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['warehouse/index']);
            }

        }else{
             $id = Yii::$app->request->get('id');
             //实例化
            $model = Entrepot::find();
            $list = $model->where(['id'=>$id])->asArray()->one();
            return $this->render('editor',['list'=>$list,'id'=>$id]);
        }


    }


    //生成十位编号
    public function number(){

        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }



    //仓库 查看商品库存
    public function actionInventory(){

            $get=Yii::$app->request->get();

            if($get['status'] == 0){
                Yii::$app->getSession()->setFlash('success', '该仓库已禁用无法查看！');
                return $this->redirect(['warehouse/index']);
            }

            $model = EntrepotGoods::find();


            if (!empty($get['keyword'])){
                $model->andWhere(['like','dyd_entrepot_goods.title',trim($get['keyword'])]);
            }
            if (!empty($get['start_time'])&&!empty($get['end_time'])){
                $model->andWhere(['between','dyd_entrepot_goods.addTime',$get['start_time'],$get['end_time']]);
            }


            //仓库ID
            $model->andWhere(['dyd_entrepot_goods.entrepot_id'=> $get['id']]);

            $count = $model->count();

            $model->joinWith('goods');  //商品
            $model->joinWith('entrepot');  //仓库
            $model->joinWith('cate');  //分类
            $model->joinWith('brand');  //品牌
            $model->joinWith('godownType');  //品牌


            $pages = new Pagination(['totalCount' => $count, 'pageSize' => 15]);
            $list = $model
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->orderBy('id desc')
                ->asArray()
                ->all();

            return $this->render('inventory',['name'=>$get['name'],'list'=>$list,'pages'=>$pages,'id'=>$get['id']]);
    }


    //仓库 查看商品规格
    public function actionSpec(){
        $get=Yii::$app->request->get();

        if(!empty($get['id'])){

            $model = EntrepotGoodsSpec::find();
            $EntrepotSpec = EntrepotSpec::find();

            //商品ID
            $model->where(['dyd_entrepot_goods_spec.good_id'=> $get['id']]);
            $EntrepotSpec->where(['dyd_entrepot_spec.goods_id'=> $get['id']]);

            //子规格
            $model->joinWith('entrepot');  //仓库

            $model->joinWith('goods');  //商品

            $list = $model->orderBy('id desc')
                ->asArray()
                ->all();

            //规格
            $EntrepotSpec->joinWith('entrepot');  //仓库

            $EntrepotSpec->joinWith('goods');  //商品

            $listSpec = $EntrepotSpec->orderBy('id asc')
                ->asArray()
                ->all();

            return $this->render('spec',['list'=>$list,'listSpec'=>$listSpec,'id'=>$get['id']]);
        }else{
            Yii::$app->getSession()->setFlash('success', '参数错误！');
            return $this->redirect(['warehouse/index']);
        }
    }

    //修改仓库状态
    public function actionStatus(){
        $get = Yii::$app->request->get();

        if(Yii::$app->request->isGet){
            $model = new Entrepot();
            $resule = $model->updateAll(['status'=>$get['status']],['id'=>$get['id']]);
            if($resule){
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['warehouse/index']);
            }

        }
    }


    //删除仓库 彻底删除
    public function actionDelete(){
        $request=Yii::$app->request;
        if ($request->isPost){
            $id=$request->post('id');

            //删除 仓库
            $result = Entrepot::deleteAll(['id'=>$id]);

            //删除仓库的管理员
            Admin::deleteAll(['entrepot'=>$id]);

            //删除仓库的用户
            Clientele::deleteAll(['entrepot_id'=>$id]);

            //删除仓库订单评论
            Comment::deleteAll(['entrepot_id'=>$id]);

            //删除仓库的商品
            EntrepotGoods::deleteAll(['entrepot_id'=>$id]);

            //删除仓库商品规格
            EntrepotSpec::deleteAll(['entrepot_id'=>$id]);

            //删除仓库商品子规格
            EntrepotGoodsSpec::deleteAll(['entrepot_id'=>$id]);

            //删除仓库的分类
            EntrepotGoodsClassify::deleteAll(['entrepot_id'=>$id]);

            //删除仓库入库记录
            GodownDetail::deleteAll(['entrepot_id'=>$id]);

            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($result){
                return ['status'=>1,'info'=>'删除成功'];
            }else{
                return ['status'=>2,'info'=>'删除失败'];
            }
        }
    }


   /*****************************************************************************************************************************************/
                                            //仓库商品修改
   /****************************************************************************************************************************************/

   //推荐
    public function actionRecommended(){
        $post = Yii::$app->request->get();

        if(Yii::$app->request->isGet){
            $model = new EntrepotGoods();
            if($post['is_recom'] == 1){ //推荐
                $resule = $model->updateAll(['is_recom'=>$post['is_recom'],'recom_reason'=>$post['recom_reason']],['id'=>$post['id']]);
            }else{
                $resule = $model->updateAll(['is_recom'=>$post['is_recom'],'recom_reason'=>''],['id'=>$post['id']]);
            }
            //返回
            if($resule){
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['warehouse/inventory?id='.$post['s_id'].'&name='.$post['name'].'&status='.'1']);
            }

        }
    }


    //修改仓库商品状态
    public function actionEntrepotStatus(){
        $get = Yii::$app->request->get();

        if(Yii::$app->request->isGet){
            $model = new EntrepotGoods();

            $resule = $model->updateAll(['status'=>$get['status']],['id'=>$get['Entrepot_id']]);

            if($resule){
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['warehouse/inventory?id='.$get['id'].'&name='.$get['name'].'&status='.'1']);
            }

        }
    }


    //删除仓库商品
    public function actionEntrepotDelete(){
        $request=Yii::$app->request;
        if ($request->isPost){
            $id=$request->post('id');

            //删除 仓库入库商品
            $result1 = EntrepotGoods::deleteAll(['id'=>$id]);
            //删除 商品入库规格子表
            $result2 = EntrepotGoodsSpec::deleteAll(['good_id' => $id]);
            //删除 商品入库规格表
            $result3 = EntrepotSpec::deleteAll(['goods_id' => $id]);

            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($result1 || $result2 || $result3){
                return ['status'=>1,'info'=>'删除成功'];
            }else{
                return ['status'=>2,'info'=>'删除失败'];
            }
        }
    }


    //修改仓库规格入库状态
    public function actionSpecStatus(){
        $get = Yii::$app->request->get();

        if(Yii::$app->request->isGet){

            $model = new EntrepotGoodsSpec();

            $resule = $model->updateAll(['status'=>$get['status']],['id'=>$get['spec_id']]);
            if($resule){
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['warehouse/spec?id='.$get['id']]);
            }

        }
    }


    //删除仓库规格入库状态
    public function actionSpecDel(){
        $request=Yii::$app->request;
        if ($request->isPost){
            $id=$request->post('id');

            $resule = EntrepotGoodsSpec::deleteAll(['id' => $id]);

            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($resule){
                return ['status'=>1,'info'=>'删除成功'];
            }else{
                return ['status'=>2,'info'=>'删除失败'];
            }
        }
    }




    //仓库 子规格增加库存
    public function actionAddInventory(){
        $id = Yii::$app->request->get('Add_id'); //仓库规格ID

        $return_id = Yii::$app->request->get('id');


        if(Yii::$app->request->isPost){
            //增加
            $post = Yii::$app->request->post();

             //仓库规格ID
             $entrepot_spec_id = $post['entrepot_spec_id'];
             //商品库规格ID
             $goods_spec_id = $post['goods_spec_id'];
             //新增数量
             $num = $post['number'];

                //加库存
                //仓库商品规格加库存
                $postGods = EntrepotGoodsSpec::findOne($entrepot_spec_id);  //实例化模型。传条件ID
                $postGods->updateCounters(['num'=>"$num"]);  //updateCounters 实现 减法 给负值：
                $postGods->updateCounters(['total_num'=>"$num"]);  //updateCounters 实现 减法 给负值：
                //查询仓库商品ID
                $entrepot_goods_id = EntrepotGoodsSpec::find()->where(['id'=>$entrepot_spec_id])->asArray()->select('id,good_id')->one();//仓库商品ID
                //仓库商品加库存
                $EntrpotGods = EntrepotGoods::findOne($entrepot_goods_id['good_id']);  //实例化模型。传条件ID
                $EntrpotGods->updateCounters(['num'=>"$num"]);
                $EntrpotGods->updateCounters(['total_num'=>"$num"]);



                //减库存
                //减去商品库的规格库存
                $goodsGods = AloneSpec::findOne($goods_spec_id);  //实例化模型。传条件ID
                $goodsGods->updateCounters(['num'=>"-$num"]);  //updateCounters 实现 减法 给负值：
                //查询商品库ID
                $goods_goods_id = AloneSpec::find()->where(['id'=>$goods_spec_id])->asArray()->select('goods_id')->one();//商品库ID
                //给商品库减库存
                $goods_Gods = Goods::findOne($goods_goods_id['goods_id']);  //实例化模型。传条件ID
                $res = $goods_Gods->updateCounters(['repertory'=>"-$num"]);

                //返回
                if($res){
                    Yii::$app->getSession()->setFlash('success', '新增库存成功！');
                    return $this->redirect(['warehouse/spec?id='.$entrepot_goods_id['good_id']]);
                }


        }else{
            $model = EntrepotGoodsSpec::find();
            //子规格
            $model->joinWith('entrepot');  //仓库

            $model->joinWith('goods');  //商品

            $model->where(['dyd_entrepot_goods_spec.id'=>$id]);  //条件

            $list = $model->orderBy('id desc')
                ->asArray()
                ->one();

            //查询商品库该规格剩余数量
            $spec = EntrepotGoodsSpec::find()->where(['id'=>$id])->asArray()->select('spec_id')->one();

            $specNum = AloneSpec::find()->where(['id'=>$spec['spec_id']])->asArray()->select('id,num,status')->one();

            if($specNum['num'] == 0){
                Yii::$app->getSession()->setFlash('success', '商品库-该规格剩余库存剩余：<b>'.$specNum['num']."</b>&nbsp;无法添加！");
                return $this->redirect(['warehouse/spec?id='.$return_id]);
            }

            if($specNum['status'] == 0){
                Yii::$app->getSession()->setFlash('success', '商品库-该规格已被冻结无法添加！');
                return $this->redirect(['warehouse/spec?id='.$return_id]);
            }

            return $this->render('addInventory',['id'=>$id,'list'=>$list,'specNum'=>$specNum['num'],'goods_id'=>$specNum['id']]);
        }
    }



}