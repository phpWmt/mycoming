<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<body class="gray-bg">

<div class="wrapper wrapper-content animated ">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-key">　</i><?php echo $title['title'] ?></h3>
                </div>
                <div class="ibox-content">
                    <?php
                    $form=ActiveForm::begin([
                        'options'=>[ 'class'=>'form-horizontal m-t myform','id' => 'form-update'],
                        'validateOnBlur'=>false,//关闭失去焦点验证
                       // 'enableAjaxValidation'=>true, //开启Ajax验证
                       //'enableClientValidation'=>false, //关闭客户端验证
                        'action'=>Url::to(['rbac/update-item']),
                        'fieldConfig'=>[
                            'template'=>'{label}<div class="col-sm-4">{input}{error}</div><div class="hr-line-dashed"></div>',
                            'labelOptions'=>['class'=>'col-sm-2 control-label']
                        ],
                    ]);
                    ?>

                    <?= $form->field($model, 'description')->textInput(['placeholder' => '对角色的描述,例如：测试管理员','value' => $data->description, 'class' => 'form-control'])->label($title['description'].':') ?>

                    <input type="hidden" id="rbac-type" class="form-control" name="Rbac[type]" value="<?php echo $title['type'] ?>">

                    <input type="hidden" id="rbac-update_name" class="form-control" name="Rbac[update_name]" value="<?php echo $data->name ?>">

                    <input type="hidden" id="rbac-update_description" class="form-control" name="Rbac[update_description]" value="<?php echo $data->description ?>">

                    <?= $form->field($model, 'name')->textInput(['placeholder' => '角色标识,例如：Test','value' => $data->name, 'class' => 'form-control'])->label($title['name'].':') ?>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']); ?>
                            <a href="<?php echo Url::to([$title['url']]) ?>"><?= Html::Button('取消', ['class' => 'btn btn-white btn-bitbucket']); ?></a>
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
