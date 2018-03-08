<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/1/9
 * Time: 14:55
 */

namespace merchant\controllers;

use Yii;
use yii\data\Pagination;
use merchant\models\Entrepot;

//出入库模型
use merchant\models\EntrepotGoods;//仓库入库商品
use merchant\models\EntrepotGoodsSpec;//商品入库规格子表
use merchant\models\EntrepotSpec;//商品入库规格表
use merchant\models\EntrepotGoodsClassify;//仓库商品分类
use merchant\models\Godown;//入库订单表
use merchant\models\GodownDetail;//出入库明细
use merchant\models\AloneSpec;
use merchant\models\Goods;
use merchant\models\Spec;



class MerchantWarehouseController extends CommonController
{

    //仓库 商品列表
    public function actionInventory(){

        $get=Yii::$app->request->get();

        if(!empty($get['id'])){

            $model = EntrepotGoods::find();

            $get=Yii::$app->request->get();

            if (!empty($get['keyword'])){

                $model->andWhere(['like','dyd_entrepot_goods.title',trim($get['keyword'])]);
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

//            $commandQuery = clone $model; //$model 实例化的对象
//            echo $commandQuery->createCommand()->getRawSql();

            return $this->render('inventory',['list'=>$list,'pages'=>$pages]);
        }else{
            Yii::$app->getSession()->setFlash('success', '参数错误！');
            return $this->redirect(['merchant-warehouse/inventory']);
        }
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
                return $this->redirect(['merchant-warehouse/inventory?id='. Yii::$app->admin->getIdentity()['entrepot'].'&status='.'1']);
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
                return $this->redirect(['/merchant-warehouse/inventory?id='.Yii::$app->admin->getIdentity()['entrepot']]);
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
                return $this->redirect(['merchant-warehouse/spec?id='.$get['id']]);
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
                return $this->redirect(['merchant-warehouse/spec?id='.$entrepot_goods_id['good_id']]);
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
                Yii::$app->getSession()->setFlash('success', '<b>商品库</b>-该规格库存剩余：<b>'.$specNum['num']."</b>&nbsp;无法添加！");
                return $this->redirect(['merchant-warehouse/spec?id='.$return_id]);
            }

            if($specNum['status'] == 0){
                Yii::$app->getSession()->setFlash('success', '<b>商品库</b>-该规格已被冻结无法添加！');
                return $this->redirect(['merchant-warehouse/spec?id='.$return_id]);
            }

            return $this->render('addInventory',['id'=>$id,'list'=>$list,'specNum'=>$specNum['num'],'goods_id'=>$specNum['id']]);
        }
    }


}