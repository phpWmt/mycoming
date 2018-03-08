<?php
use yii\helpers\Url;
use yii\widgets\LinkPager; //使用小物件
use yii\bootstrap\Alert;
if( Yii::$app->getSession()->hasFlash('success') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', //这里是提示框的class
        ],
        'body' => Yii::$app->getSession()->getFlash('success'), //消息体
    ]);
    echo "<script>window.setTimeout(\"location.replace(location.href)\",1000);</script>";

}
?>
<body class="gray-bg">
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="col-sm-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h3><i class="fa fa-bars">　</i>物流公司</h3>
            </div>
            <div class="ibox-content">

                <button class="btn btn-info add btn-xs" type="button" data-toggle="modal"
                        data-target="#cate"><i class="fa fa-plus"></i>新增物流公司
                </button>
                <div class="dd" id="nestable2">
                    <?php if(!empty($GodownTypeb)):foreach ($GodownTypeb as $v):?>
                        <ol class="dd-list">
                            <li class="dd-item">
                                <div class="dd-handle">
                                    <span class="label label-info"><i class="fa fa-home"></i></span><?php echo $v['delivery_name']?>
                                    <div class="sort-left">

                                        <?php if($v['is_show'] == 1):?>
                                            <button data-id="<?php echo $v['id']; ?>" data-action="hide" data_type="class" class="action btn btn-warning radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">隐藏</span></button>
                                        <?php else:?>
                                            <button data-id="<?php echo $v['id']; ?>" data-action="show" data_type="class" class="action btn btn-default radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">显示</span></button>
                                        <?php endif;?>

                                        <button data-id="<?php echo $v['id']; ?>" type="button" class="del btn update btn-outline btn-danger btn-xs btn-mini"><i class="glyphicon glyphicon-trash"></i>删除</button>

                                    </div>
                                </div>
                            </li>
                        </ol>
                    <?php endforeach;endif;?>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<!--多次使用 弹窗-->
<div class="modal inmodal" id="cate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="fa fa-tag modal-icon"></i>
                <h4 class="modal-title" id="cate_title">物流公司添加</h4>
                <h4 id="top_cate"></h4>
                <small id="response_info" class="label label-info"></small>
            </div>
            <form class="form-horizontal myform" onsubmit="return false;">
                <input type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">物流公司:</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" id="cate_name" placeholder="例如：顺丰快递" class="form-control cate_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">拼音名称:</label>
                        <input type="hidden" id="cate_pid" name="pid" value="0">
                        <div class="col-sm-8">
                            <input type="text" name="code" id="cate_name" placeholder="例如：shunfeng" class="form-control cate_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">字母排序:</label>
                        <input type="hidden" id="cate_pid" name="pid" value="0">
                        <div class="col-sm-8">
                            <input type="text" name="sort" id="cate_name" placeholder="例如：S" class="form-control cate_name">
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="button" id="cate_submit" class="btn btn-primary">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
$js = <<<JS

        //源代码
        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('浏览器不支持');
            }
        };

    //添加库存类型
    $("#cate_submit").on("click", function () {
        $(".myform").ajaxSubmit({
            url: "/order/godown-type",
            type: "post",
            dataType: "json",
            success: function (data) {
                if(data.status === 1) {
                    $("#response_info").text(data.info);
                    setTimeout(function (){
                    window.location.reload();
                    }, 800);
                }else{
                    $("#response_info").text(data.info);
                } 
            }
        });
    });
   
            //删除
            $(".del").click(function () {
            var del = $(this);
            var id=$(this).attr('data-id');
            
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此物流公司吗？',
                ok: function () {
                    $.ajax({
                        url: "/order/godown-delete",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
                            'model':model,
                            '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            console.log(data);
                            if(data.status === 1) {
                                var status=dialog({content: data.info}).showModal();
                                setTimeout(function (){
                                status.close();
                                del.closest('li').remove();
                                }, 800);
                            }else{ 
                                dialog({title: "提示",content: data.info,ok: true}).showModal();
                            } 
                        }
                    });
                },
                cancel: true
            });
            d.showModal();
        }); 
            
            
            //显示或隐藏
            $(".action").click(function () {
            var type=$(this).attr('data_type');
            var action=$(this).attr('data-action');
            var id=$(this).attr('data-id');
            
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要操作此类型吗？',
                ok: function () {
                    $.ajax({
                        url: "/order/operation",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
                            'action':action,     
                            'type':type,
                            '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if(data.status === 1) {
                                var status=dialog({content: data.info}).showModal();
                                setTimeout(function (){
                                status.close();
                                del.closest('li').remove();
                                }, 800);
                                window.location.reload();
                            }else{ 
                                dialog({title: "提示",content: data.info,ok: true}).showModal();
                            } 
                        }
                    });
                },
                cancel: true
            });
            d.showModal();
        }); 
JS;
$this->registerJs($js);
?>
</body>