<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<body class="gray-bg">

<div class="wrapper wrapper-content animated ">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-key">　</i>添加角色</h3>
                </div>
                <div class="ibox-content">
                    <?php
                    $form=ActiveForm::begin([
                        'options'=>[ 'class'=>'form-horizontal m-t myform','id' => 'form-create'],
                        'validateOnBlur'=>false,//关闭失去焦点验证
                       // 'enableAjaxValidation'=>true, //开启Ajax验证
                        'action'=>Url::to(['rbac/add-roles']),
                        'method'=>'post',
                        'fieldConfig'=>[
                            'template'=>'{label}<div class="col-sm-4">{input}{error}</div><div class="hr-line-dashed"></div>',
                            'labelOptions'=>['class'=>'col-sm-2 control-label']
                        ],
                    ]);
                    ?>
                    <?= $form->field($model, 'description')->textInput(['placeholder' => '对角色的描述,例如：测试管理员', 'class' => 'form-control'])->label('角色描述:') ?>

                    <?= $form->field($model, 'name')->textInput(['placeholder' => '角色标识,例如：Test', 'class' => 'form-control'])->label('角色标识:') ?>

                    <?= $form->field($model, 'status')->dropDownList(['1'=>'总后台角色','2'=>'仓库后台角色'], ['prompt'=>'请选择'])->label('角色类型:') ?>


                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <?= Html::submitButton('添加角色', ['class' => 'btn btn-primary','id'=>'add']); ?>
                            <a href="<?php echo Url::to(['rbac/roles']) ?>" class="btn btn-white btn-bitbucket">取消</a>
                        </div>
                    </div>
                    <?php
                    ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
