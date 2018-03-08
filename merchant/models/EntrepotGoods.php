<?php

namespace merchant\models;

use Yii;

/**
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property string $is_show
 */
class EntrepotGoods extends \yii\db\ActiveRecord
{
    /**
     * 仓库入库商品
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entrepot_goods}}';
    }


    //商品分类
    public function getCate(){
        return $this->hasOne(Cate::className(),['id'=>'classify_id']);
    }

    //商品品牌
    public function getBrand(){
        return $this->hasOne(ArticleCate::className(),['id'=>'brand_id']);
    }

    //所属仓库
    public function getEntrepot(){
        return $this->hasOne(Entrepot::className(),['id'=>'entrepot_id']);
    }

    //商品分类
    public function getGoods(){
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }

    //入库类型
    public function getGodownType(){
        return $this->hasOne(GodownType::className(),['id'=>'godown_type']);
    }


}