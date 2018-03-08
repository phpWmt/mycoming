<?php

namespace backend\models;

use Yii;

/**
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property string $is_show
 */
class GodownDetail extends \yii\db\ActiveRecord
{
    /**
     * 出入库明细表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%godown_detail}}';
    }

    //商品
    public function getGoods(){
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }

    //所属仓库
    public function getEntrepot(){
        return $this->hasOne(Entrepot::className(),['id'=>'entrepot_id']);
    }


    //入库类型
    public function getGodownType(){
        return $this->hasOne(GodownType::className(),['id'=>'godown_type']);
    }


}