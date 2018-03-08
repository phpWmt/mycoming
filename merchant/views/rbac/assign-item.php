<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<style>
    .checkbox-inline{
        width:160px;
    }
</style>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <h3><i class="fa fa-key">　</i>分配权限</h3>
                </div>
                <div class="ibox-content">
                    <form method="post" id="assign_form" class="form-horizontal" onsubmit="return false;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色名称:</label>
                            <div class="col-sm-3">
                                <input type="text"  class="form-control"  name="name" value="<?php echo $parent->name ?>" readonly = "readonly" >
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">全选:</label>
                            <div class="col-sm-10">
                            <input type="checkbox"  class="form-control all-checks">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">权限节点:</label>
                            <div id="permissions" class="col-sm-10">
                                <?php if (is_array($permissions)): foreach ($permissions as $k => $v): ?>
                                    <label class="checkbox-inline i-checks">
                                        <?php if (!empty($children['permissions'])):?>
                                            <?php if (in_array($k, $children['permissions'])): ?>
                                                <input type="checkbox" value="<?php echo $k; ?>" checked="" name="children[]"><?php echo $v?>
                                            <?php else:?><input type="checkbox" value="<?php echo $k; ?>"  name="children[]"><?php echo $v?>
                                            <?php endif; ?>
                                        <?php else:?><input type="checkbox" value="<?php echo $k; ?>"  name="children[]"><?php echo $v?>
                                        <?php endif; ?>
                                    </label>
                                <?php endforeach; endif;?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <?= Html::submitButton('提交', ['class' => 'btn btn-primary','id'=>'add']); ?>
                                <a href="<?php echo Url::to(['rbac/roles']) ?>"><button class="btn btn-white" id="cancel" type="button">取消</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js=<<<JS
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
            increaseArea: '20%' // optional
        });
    // 全选
    $('.all-checks').on('ifChecked', function (event) {
        $("#permissions input[type='checkbox']").iCheck('check');
    });
    // 反选
    $('.all-checks').on('ifUnchecked', function (event) {
        $("#permissions input[type='checkbox']").iCheck('uncheck');
    });

    $("#add").on('click', function () {
        $("#assign_form").ajaxSubmit({
            url: "/rbac/assign-item",
            type: "post",
            data: {'_csrf-backend': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function (data) {
                
                
                if (data.status === 1) {
                    dialog({content: data.info}).showModal();
                    setTimeout(function () {
                        window.location.href = "/rbac/roles";
                    }, 800);
                } else {
                    dialog({title: '友情提示', content: data.info, ok: true}).showModal();
                }
                
                
                
            }
        });
    });
JS;
$this->registerJs($js);
?>

