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
                        <h3><i class="fa fa-user-secret">　</i>反馈列表</h3>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-5 p-m">
                                <form method="get" action="/user/feedback">
                                    <div class="input-group list-group col-sm-6">
                                        <input type="text" name="keyword" placeholder="请输入反馈内容检索" class="input-sm form-control">
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                    </span>
                                    </div>
                                </form>
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
                                    <th class="text-center">昵称</th>
                                    <th class="text-center">电话</th>
                                    <th class="text-center">反馈内容</th>
                                    <th class="text-center">状态</th>
                                    <th class="text-center">反馈时间</th>
                                    <th class="text-center">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (is_array($lists)): foreach ($lists as $k => $v): ?>
                                    <tr>
                                        <td align="center">
                                            <label class="checkbox-inline i-checks">
                                                <input type="checkbox" value="<?php echo $v['id'] ?>">
                                            </label>
                                        </td>
                                        <td align="center">
                                            <img class="goods_img" src="<?php echo Yii::$app->params['API_HOST'].$v['user']['cover']; ?>">
                                        </td>

                                        <td align="center">
                                            <?php echo $v['user']['nickname']; ?>
                                        </td>

                                        <td align="center">
                                            <?php echo $v['phone']; ?>
                                        </td>

                                        <td align="center">
                                            <?php echo $v['content']; ?>
                                        </td>

                                        <td align="center">
                                            <?php if ($v['status'] == 0): ?>
                                                <a href="javascript:;" class="status off" id="<?php echo $v['id']; ?>"
                                                   title="未回复">
                                                    未回复
                                                </a>
                                            <?php else: ?>
                                                <a href="javascript:;" class="status" id="<?php echo $v['id']; ?>" title="已回复" style="color: #00aa00">
                                                    已回复
                                                </a>
                                            <?php endif; ?>
                                        </td>

                                        <td align="center">
                                            <?php echo $v['addTime']; ?>
                                        </td>

                                        <td align="center">

                                            <button  data-id="<?php echo $v['id']?>" data-user-id="<?php echo $v['user']['id']?>" data-user="<?php echo $v['user']['nickname']?>" data-content="<?php echo $v['content']?>" type="button" data-toggle="modal" data-target="#add_per" class="btn btn-info btn-outline btn-xs btn-rounded speak"><i class="glyphicon glyphicon-tag"></i>&nbsp;回复</button>


                                            <button data-id="<?php echo $v['id']?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-outline btn-xs del btn-rounded"><i class="fa fa-trash-o"></i>&nbsp;删除</button>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                            <div class="col-sm-12 page"><span><strong>
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


    <div class="modal inmodal" id="add_per" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                </div>
                <form class="myform" action="<?php Url::to('user/feedback')?>" method="post">
                    <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken ?>">
                <small class="font-bold">
                    <div class="modal-body" style="height: 550px;">

                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="form-group">
                                <label><h3>反馈用户:</h3></label>
                                <input type="text" name="description" id="user" class="col-sm-6 form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label><h3>反馈内容:</h3></label>
                                <textarea name="a" rows="8"  id="content" class="col-sm-8 form-control" disabled></textarea>
                            </div>


                            <div class="form-group">
                                <label><h3>回复:</h3></label>
                                <textarea rows="8"  name="info" class="col-sm-8 form-control" required placeholder="随便写些什么"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="submit"  class="btn btn-primary">添加</button>
                    </div>
                </small>
                </form>
            </div>
        </div>
    </div>


<?php

$js = <<<JS
        $(".speak").click(function() {
             var id= $(this).attr('data-id');
              var user_id= $(this).attr('data-user-id');
             var user= $(this).attr('data-user');
             var content= $(this).attr('data-content');
               
             $("#id").val(id);
              $("#user_id").val(user_id);
             $("#user").val(user);
             $("#content").val(content);
             
        });

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
                content: '您确定要删除此反馈信息吗？',
                ok: function () {
                    $.ajax({
                        url: "/user/feedback-delete",
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
    </body><?php
/**
 * Created by PhpStorm.
 * User: PhpAdmin
 * Date: 2018/2/5
 * Time: 15:08
 */