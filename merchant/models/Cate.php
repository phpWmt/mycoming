<?php

namespace merchant\models;

use Yii;

/**
 * This is the model class for table "{{%cate}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property string $is_show
 */
class Cate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'pid'], 'integer'],
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
            'name' => '分类名称',
            'pid' => '父级ID',
            'is_show' => '是否显示',
        ];
    }
}