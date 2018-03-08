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
class EntrepotGoodsSpec extends \yii\db\ActiveRecord
{
    /**
     * 商品入库规格表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entrepot_goods_spec}}';
    }

    //所属仓库
    public function getEntrepot(){
        return $this->hasOne(Entrepot::className(),['id'=>'entrepot_id']);
    }

    //商品
    public function getGoods(){
        return $this->hasOne(EntrepotGoods::className(),['id'=>'good_id']);
    }



}