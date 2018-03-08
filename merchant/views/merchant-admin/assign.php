<?php
use yii\helpers\Url;

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

                    <h3><i class="fa fa-user-secret">　</i>分配角色</h3>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" onsubmit="return false;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">管理员名称:</label>
                            <div class="col-sm-3">
                                <input type="hidden" name="aid" value="<?php echo $admin['id'] ?>">
                                <input type="text" readonly="" value="<?php echo $admin['username'];?>" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色:</label>
                            <div class="col-sm-10">
                                <?php if (is_array($roles)): foreach ($roles as $k => $v): ?>
                                    <label class="checkbox-inline i-checks">
                                        <?php if (is_array($children['roles'])): ?>
                                            <?php if (in_array($k, $children['roles'])): ?>
                                                <input type="checkbox" value="<?php echo $k; ?>" checked="" name="children[]"><?php echo $v?>
                                            <?php else:?><input type="checkbox" value="<?php echo $k; ?>"  name="children[]"><?php echo $v?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </label>
                                <?php endforeach; endif;?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-primary" id="add" type="submit">授权</button>
                                <a href="<?php echo Url::to(['manager/list']) ?>"><button class="btn btn-white" id="cancel" type="button">取消</button></a>
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
    $(document).ready(function () {
        $(".i-checks").iCheck({checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green",})
    });

    $("#add").on('click', function () {
        $(".form-horizontal").ajaxSubmit({
            url: "/admin/assign",
            type: "post",
            data: {'_csrf-backend': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function (data) {
                if (data.status === 1) {
                    dialog({content: data.info}).showModal();
                    setTimeout(function () {
                        window.location.href = "/admin/list";
                    }, 800);
                } else {
                    dialog({title: '友情提示', content: data.info, ok: true}).showModal();
                }
            }
        });
    });
JS;
$this->registerJS($js);
?>

