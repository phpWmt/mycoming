<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;

?>
<?= \common\widgets\Alert::widget()?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>用户列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-5 p-m">
                            <form method="get" action="/user/search">
                                <div class="input-group list-group col-sm-6">
                                    <input type="text" name="keyword" placeholder="请输入手机号、昵称" class="input-sm form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                    </span>
                                </div>
                            </form>
<!--                            <button id="delete_all" class="btn btn-sm btn-outline btn-danger m-l del_all" type="button">-->
<!--                                <i class="fa fa-user-times"></i>批量删除-->
<!--                            </button>-->
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" width="6%">
                                    <label class="checkbox-inline i-checks">
                                        <input type="checkbox" class="all-checks">
                                    </label>
                                </th>
                                <th class="text-center">头像</th>
                                <th class="text-center">手机号</th>
<!--                                <th class="text-center">姓名</th>-->
                                <th class="text-center">昵称</th>
                                <th class="text-center">状态</th>
                                <th class="text-center">注册时间</th>
                                <th class="text-center">上次登录时间</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($lists)): foreach ($lists as $k => $v): ?>
                                <tr>
                                    <td align="center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" value="<?php echo $v->id ?>">
                                        </label>
                                    </td>
                                    <td align="center">
                                        <img class="goods_img" src="<?php echo Yii::$app->params['API_HOST'].$v->cover; ?>">
                                    </td>
                                    <td align="center">
                                        <?php echo $v->phone; ?>
                                    </td>
<!--                                    <td align="center">-->
<!--                                        --><?php //echo $v->username; ?>
<!--                                    </td>-->
                                    <td align="center">
                                        <?php echo $v->nickname; ?>
                                    </td>
                                    <td align="center">
                                        <?php if ($v->status == 1): ?>
                                            <a href="javascript:;" class="status off" id="<?php echo $v->id; ?>"
                                               title="账户正常">
                                                <i class="fa fa-lg fa-check text-navy" data-status="1"></i>
                                            </a>
                                        <?php elseif ($v->status == 2): ?>
                                            <a href="javascript:;" class="status" id="<?php echo $v->id; ?>"
                                               title="账户锁定则不允许登录">
                                                <i class="fa fa-lg fa-lock text-warning" data-status="0"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $v->create_time; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $v->last_time; ?>
                                    </td>

                                    <td align="center">

                                        <button data-id="<?php echo $v['id']?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-outline btn-xs del btn-rounded"><i class="fa fa-trash-o"></i>&nbsp;删除</button>

                                        <a href="  <?php echo Url::to(['user/show', 'id' => $v['id']]) ?>">
                                            <button type="button" class="btn btn-primary btn-xs btn-outline btn-rounded"><i
                                                        class="fa fa-paste"></i>&nbsp;查看
                                            </button>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                        <div class="col-sm-12 page"><span>共<strong>
                        <?php echo $pages->totalCount; ?></strong>条记录</span>
                            <div class="pull-right">
                                <?= LinkPager::widget([
                                    'pagination'     => $pages,
                                    'nextPageLabel'  => '下一页',
                                    'prevPageLabel'  => '上一页',
                                    'firstPageLabel' => '首页',
                                    'lastPageLabel'  => '尾页',
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$js = <<<JS

    $(document).ready(function () {
        $(".i-checks").iCheck({checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"})
            // 全选
        $('.all-checks').on('ifChecked', function (event) {
            $("input[type='checkbox']").iCheck('check');
        });
        // 反选
        $('.all-checks').on('ifUnchecked', function (event) {
            $("input[type='checkbox']").iCheck('uncheck');
        });
    });

    $("#delete_all").click(function() {
       
        var id='';
        $('input[name="check"]:checked').each(function (i, obj) {
            id=$(obj).val()+','+id;
        });
        
        $(".myform").ajaxSubmit({
        url: "/room/update",
        type: "post",
        dataType: "json",
        success: function (data) {
            if(data.status === 1) {
                $("#update_status").text(data.info);
                setTimeout(function (){
               window.location.reload();
                }, 800);
            }else{
                $("#update_status").text(data.info);
            } 
        }
        });
    });
    //状态更改
    
    $('.status').click(function() {
      if ($(this).hasClass('off')){
          var status = '2';
      }else {
          var status = '1';
      }
     
      $.ajax({
            url:"/user/status",
            data:{id:$(this).attr('id'),status:status},
            type:"post",    
            success:function(e) {
                if (e == '1'){
                    
                    var success=dialog({content: '操作成功'}).showModal();
                        setTimeout(function () {
                            success.close();
                            window.location.reload();
                        }, 1000);
                }else {
                    layer.msg('请重试');
                    setTimeout(function (){
                        window.location.reload();
                    }, 800);
                }
            }
              
      })
    });
    
            //删除      
        $(".del").click(function () {
            var dele = $(this);
            var id= $(this).attr('data-id');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此用户吗？',
                ok: function () {
                    $.ajax({
                        url: "/user/delete",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
                            '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if(data.status === 1) {
                                var status=dialog({content: data.info}).showModal();
                                setTimeout(function (){
                                status.close();
                                dele.closest('tr').remove();
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
JS;
$this->registerJs($js);
?>
</body>