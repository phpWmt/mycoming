<?php

namespace merchant\models;

use Yii;

/**
 * This is the model class for table "{{%article_cate}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property integer $sort
 */
class ArticleCate extends \yii\db\ActiveRecord
{
    /**
     * 品牌表
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brand}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'sort'], 'integer'],
            [['is_show'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章分类名称',
            'pid' => '父级ID',
            'sort' => '排序',
            'is_show' => '是否显示',
            'img' => '品牌图片',
        ];
    }
}
