<?php

namespace backend\models;

use Yii;


/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $id
 * @property integer $cate_id
 * @property string $title
 * @property string $info
 * @property integer $num
 * @property string $price
 * @property string $cover
 * @property string $img
 * @property string $is_hot
 * @property string $is_sale
 * @property string $sale_price
 * @property string $create_time
 * @property string $update_time
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cate_id' => 'Cate ID',
            'title' => '商品标题',
            'info' => '商品详情',
            'list_price' => '商品单价',
            'cover' => '封面图片',
            'img' => '轮番图片',
            'is_hot' => '是否热卖',
            'is_sale' => '是否促销',
            'sale_price' => '促销价格',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    //商品分类
    public function getCate(){
        return $this->hasOne(Cate::className(),['id'=>'cate_id']);
    }

    //商品品牌
    public function getBrand(){
        return $this->hasOne(ArticleCate::className(),['id'=>'brand_id']);
    }

    //所属仓库
    public function getEntrepot(){
        return $this->hasOne(Entrepot::className(),['id'=>'entrepot']);
    }


    //返回规格列表
    public static function return_spec($id){
var_dump($id);die;
        $e_id =explode(',',$id);

        $resultSpec = AloneSpec::find()->andWhere(['in', 'id', $e_id])->select('id,spec')->asArray()->all();

        foreach ($resultSpec as $value){
            echo "  <tr>
                            <td class=\"text-center\" width=\"2%\">
                                <label class=\"checkbox-inline i-checks\">
                                    <input type=\"checkbox\" class=\"all-checks\">
                                </label>
                            </td>
                            <td align=\"center\">
                               $value[id]
                            </td>
                            <td align=\"center\">
                                <b>$value[spec]</b>
                            </td>
                   </tr>";
        }

    }



    /**
     * 返回商品总数
     *
     * @param $status
     *
     * @return string
     */
    static public function return_goods()
    {
        $countGoods = Goods::find()->count();
        echo $countGoods;
    }


}
