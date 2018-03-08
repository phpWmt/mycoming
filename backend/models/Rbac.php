<?php

namespace backend\models;

use Yii;
class Rbac extends \yii\db\ActiveRecord
{
    public $update_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    public function scenarios()
    {
        return [
            'add_roles' => ['name', 'description','status'],
            'update'=>['name','description','update_name'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','description','status'], 'required','message'=>'此项不能为空'],
            ['name','unique','targetClass' =>'\backend\models\Rbac','message'=>'该标识已被占用','on'=>'add_roles'],
            ['name','ValidateName','on'=>'update'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function ValidateName(){
        if ($this->name==$this->update_name){
            $this->addErrors(['name'=>'没有做任何修改']);
        }

        $auth = Yii::$app->authManager;
        if ($auth->getRole($this->name)){
            $this->addError('name','该角色标识已存在');
        }
    }

    /**
     * 获取除过当前角色的其他角色数据
     * @param  [type] $data   所有的角色对象
     * @param  [type] $parent 当前角色名称
     * @return [type] array   返回其它角色信息
     *
     * @return [$status] int   区分总后台 和 仓库
     */
    public static function getOptions($data, $parent,$status)
    {

        $return = [];
        foreach ($data as $obj) {

            if((int)$obj->data === (int)$status){
                if (!empty($parent) && $parent->name != $obj->name && Yii::$app->authManager->canAddChild($parent, $obj)) {
                    $return[$obj->name] = $obj->description;
                }

                if (is_null($parent)) {
                    $return[$obj->name] = $obj->description;
                }
            }



        }

        return $return;
    }


    /**
     * 给角色添加权限或角色
     * @param [type] $children [description]
     * @param [type] $name     [description]
     */
    public static function addChild($children, $name)
    {
        $auth = Yii::$app->authManager;

        $itemObj = $auth->getRole($name);
        if (empty($itemObj)) {
            return false;
        }
        //开启事务 便于数据的一致性操作
        $trans = Yii::$app->db->beginTransaction();
        try {
            $auth->removeChildren($itemObj);
            foreach ($children as $item) {
                //判断是角色还权限
                $obj = empty($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
                $auth->addChild($itemObj, $obj);
            }
            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollback();
            return false;
        }
        return true;
    }



    /**
     * 获取指定角色下面的权限
     * @param  [type] $name 角色名称
     * @return [type]       权限名称
     */
    public static function getChildrenByName($name)
    {
        if (empty($name)) {
            return [];
        }
        $return = [];
        $return['roles'] = [];
        $return['permissions'] = [];
        $auth = Yii::$app->authManager;
        //获取该角色下面的所有权限节点
        $children = $auth->getChildren($name);
        if (empty($children)) {
            return [];
        }
        foreach ($children as $obj) {
            //判断是权限还是角色
            if ($obj->type == 1) {
                $return['roles'][] = $obj->name;
            } else {
                $return['permissions'][] = $obj->name;
            }
        }
        return $return;
    }



    /**
     * @param $adminid  管理员ID
     * @param $children 需要添加的权限和角色数据
     * @return bool
     */
    public static function grant($adminid, $children)
    {
        $trans = Yii::$app->db->beginTransaction();
        try {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($adminid);
            foreach ($children as $item) {
                $obj = empty($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
                $auth->assign($obj, $adminid);
            }
            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollback();
            return false;
        }
        return true;
    }



    /**
     * @param $adminid 管理员ID
     * @param $type     用来区分是角色还是权限 1角色 2权限
     * @return array
     */
    private static function _getItemByUser($adminid, $type)
    {
        $func = 'getPermissionsByUser';
        if ($type == 1) {
            $func = 'getRolesByUser';
        }
        $data = [];
        $auth = Yii::$app->authManager;
        $items = $auth->$func($adminid);
        foreach ($items as $item) {
            $data[] = $item->name;
        }
        return $data;
    }



    /**
     * 获取当前管理员的已经分配的角色或权限
     * @param $adminid 管理员ID
     * @return array
     */
    public static function getChildrenByUser($adminid)
    {
        $return = [];
        $return['roles'] = self::_getItemByUser($adminid, 1);
        $return['permissions'] = self::_getItemByUser($adminid, 2);
        return $return;
    }


}


