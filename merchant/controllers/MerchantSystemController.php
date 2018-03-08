<?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/2/3
 * Time: 13:50
 */

namespace merchant\controllers;

use merchant\models\Admin;
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

class MerchantSystemController extends CommonController
{

    //仓库管理
    public function actionEntrepot(){
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
                ['id'=>Yii::$app->admin->getIdentity()['entrepot']]);

            if($resule){
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['merchant-system/entrepot']);
            }else{
                Yii::$app->getSession()->setFlash('success', '未做修改！');
                return $this->redirect(['merchant-system/entrepot']);
            }

        }else{
            $id =  Yii::$app->admin->getIdentity()['entrepot'];
            //实例化
            $model = Entrepot::find();
            $list = $model->where(['id'=>$id])->asArray()->one();
            return $this->render('entrepot',['list'=>$list,'id'=>$id]);
        }
    }


    //账号管理
    public function actionAccount(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model = new Admin();
            $resule = $model->updateAll(
                [
                    'username'=>$post['username'],
                    'name'=>$post['name'],
                    'phone'=>$post['phone'],
                    'password'=> $post['password'] ? password_hash($post['password'], PASSWORD_DEFAULT) : $post['psd'],
                ],
                ['id'=>Yii::$app->admin->getIdentity()['id']]);

            if($resule){
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['merchant-system/account']);
            }else{
                Yii::$app->getSession()->setFlash('success', '未做修改！');
                return $this->redirect(['merchant-system/account']);
            }

        }else{
            $id =  Yii::$app->admin->getIdentity()['id'];
            //实例化
            $model = Admin::find();
            $list =  $model->where(['id'=>$id])->asArray()->one();

            return $this->render('account',['list'=>$list,'id'=>$id]);
        }
    }

}