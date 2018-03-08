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
    <div class="col-sm-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3><i class="fa fa-bars">　</i>商品分类</h3>
            </div>
            <div class="ibox-content">

                <div class="row">
                    <div class="col-sm-4">
                        <div id="nestable2-menu">
                            <button type="button" data-action="expand-all" class="btn btn-white btn-sm">全部展开</button>
                            <button type="button" data-action="collapse-all" class="btn btn-white btn-sm hides">收起全部</button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-info add btn-xs" type="button" data-toggle="modal"
                        data-target="#cate"><i class="fa fa-plus"></i>新增顶级分类
                </button>
                <div class="dd" id="nestable2">
                    <?php if (is_array($cate)): foreach ($cate as $k => $v): ?>
                        <ol class="dd-list">
                            <li class="dd-item">
                                <div class="dd-handle">
                                        <span class="label label-info"><i class="fa fa-home"></i></span><?php echo $v['name']; ?>
                                    <div class="sort-left">
                                        <button data-pid="<?php echo $v['pid'] ?>" type="button" data-id="<?php echo $v['id'] ?>" data-name="<?php echo $v['name'] ?>" class="btn add btn-outline btn-primary btn-xs btn-mini" data-toggle="modal" data-target="#cate"><i class="fa fa-plus"></i>添加子分类</button>

                                        <?php if($v['is_show'] == 1 && $v['apply'] == 0):?>
                                            <button data-id="<?php echo $v['id']; ?>" data-action="hide" data_type="class" class="action btn btn-warning radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">隐藏</span></button>
                                        <?php else:?>
                                            <button data-id="<?php echo $v['id']; ?>" data-action="show" data_type="class" class="action btn btn-default radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">显示</span></button>
                                        <?php endif;?>

                                        <button data-id="<?php echo $v['id']; ?>" data-toggle="modal" data-target="#cate" data-name="<?php echo $v['name']; ?>" data-sort="<?php echo $v['sort']; ?>" type="button" class="btn update btn-outline btn-success btn-xs btn-mini"><i class="glyphicon glyphicon-pencil"></i>修改</button>
                                        <button data-id="<?php echo $v['id']; ?>" type="button" class="del btn update btn-outline btn-danger btn-xs btn-mini"><i class="glyphicon glyphicon-trash"></i>删除</button>
                                    </div>
                                </div>

                                <?php if (is_array($v['children'])): foreach ($v['children'] as $k1 => $v1): ?>
                                    <ol class="dd-list">
                                        <li class="dd-item">
                                            <div class="dd-handle">
                                                <i class="fa fa-home"></i><?php echo $v1['name']; ?>
                                                <div class="sort-left">
                                                    <?php if($v1['is_show'] == 1):?>
                                                        <button data-id="<?php echo $v1['id']; ?>" data-action="hide" data_type="class" class="action btn btn-warning radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">隐藏</span></button>
                                                    <?php else:?>
                                                        <button data-id="<?php echo $v1['id']; ?>" data-action="show" data_type="class" class="action btn btn-default radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">显示</span></button>
                                                    <?php endif;?>

                                                    <button data-id="<?php echo $v1['id']; ?>" data-toggle="modal" data-target="#cate" data-name="<?php echo $v1['name']; ?>" type="button" data-sort="<?php echo $v['sort']; ?>" class="btn update  btn-outline btn-success btn-xs"><i class="glyphicon glyphicon-pencil"></i>修改</button>
                                                    <button data-id="<?php echo $v1['id']; ?>" type="button" class="del btn update  btn-outline btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i>删除</button>
                                                </div>
                                            </div>
                                            <?php if (is_array($v1['children'])): foreach ($v1['children'] as $k2 => $v2): ?>
                                                <ol class="dd-list">
                                                    <li class="dd-item">
                                                        <div class="dd-handle">
                                                            <i class="fa fa-tag"></i><?php echo $v2['name']; ?>
                                                            <div class="sort-left">
                                                                <button data-id="<?php echo $v2['id']; ?>" data-toggle="modal" data-target="#cate" data-name="<?php echo $v2['name']; ?>" data-sort="<?php echo $v['sort']; ?>" type="button" class="btn update btn-success btn-xs"><i class="glyphicon glyphicon-pencil"></i>修改</button>
                                                                <button data-id="<?php echo $v2['id']; ?>" type="button" class="del btn update btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i>删除</button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ol>
                                            <?php endforeach; endif; ?>
                                        </li>
                                    </ol>
                                <?php endforeach; endif; ?>
                            </li>
                        </ol>
                    <?php endforeach; endif; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- 申请的分类   -->
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><i class="fa fa-cart-plus">　</i>申请分类</h3>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center"><b>分类名称</b></th>
                            <th class="text-center"><b>分类等级</b></th>
                            <th class="text-center"><b>操作</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($listCate)): foreach ($listCate as $k => $v): ?>
                            <tr>

                                <td align="center"><?php echo($v["name"]); ?></td>

                                <td align="center">
                                    <?php if($v["pid"] == 0):?>
                                        <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="#">顶级分类</a>
                                    <?php else:?>
                                       <a class="btn btn-info btn-rounded btn-outline btn-xs" href="#"> 顶级分类：<?php echo \backend\models\Cate::return_cate($v["pid"]) ?></a>
                                    <?php endif;?>
                                </td>

                                <td align="center">

                                    <a class="btn btn-primary btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['cate/status','id'=>$v['id'],'status'=>1])?>"><i class="fa fa-check"></i>&nbsp;通过审核</a>&nbsp;&nbsp;&nbsp;&nbsp;


                                    <button data-id="<?php echo $v['id'] ?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-outline btn-xs Apply-del btn-rounded"><i class="fa fa-trash-o"></i>&nbsp;删除</button>

                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                    <div class="col-sm-12 page">
                        <div class="pull-right">
                            <?= LinkPager::widget([
                                'pagination' => $pagesCate,
                                'nextPageLabel' => '下一页',
                                'prevPageLabel' => '上一页',
                                'firstPageLabel' => '首页',
                                'lastPageLabel' => '尾页',
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  商品品牌   -->
    <div class="col-sm-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3><i class="fa fa-bars">　</i>商品品牌</h3>
            </div>
            <div class="ibox-content">

                <div class="row">
                    <div class="col-sm-4">
                        <div id="nestable-menu">
                            <button type="button" data-action="article_expand-all" class="btn btn-white btn-sm">全部展开</button>
                            <button type="button" data-action="article_collapse-all" class="btn btn-white btn-sm hides">收起全部</button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-info add btn-xs" type="button" data-toggle="modal" data-model="article"
                        data-target="#cate"><i class="fa fa-plus"></i>新增顶级品牌
                </button>
                <div class="dd" id="nestable">
                    <?php if (is_array($article_cate)): foreach ($article_cate as $k => $v): ?>
                        <ol class="dd-list">
                            <li class="dd-item">
                                <div class="dd-handle">
                                        <span class="label label-info"><i
                                                    class="fa fa-home"></i></span><?php echo $v['name']; ?>
                                    <div class="sort-left">
                                        <button data-pid="<?php echo $v['pid'] ?>" type="button" data-id="<?php echo $v['id'] ?>" data-name="<?php echo $v['name'] ?>" class="btn add btn-outline btn-primary btn-xs btn-mini modal-form" data-toggle="modal" data-model="article" data-target="#modal-form"><i class="fa fa-plus"></i>添加子品牌</button>
                                        <?php if($v['is_show'] == 1):?>
                                            <button data-id="<?php echo $v['id']; ?>" data-action="hide" data_type="brand" class="action btn btn-warning radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">隐藏</span></button>
                                        <?php else:?>
                                            <button data-id="<?php echo $v['id']; ?>" data-action="show" data_type="brand" class="action btn btn-default radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">显示</span></button>
                                        <?php endif;?>

                                        <button data-id="<?php echo $v['id']; ?>" data-toggle="modal" data-target="#cate" data-name="<?php echo $v['name']; ?>" data-model="article" data-sort="<?php echo $v['sort']; ?>" type="button" class="btn update btn-success  btn-outline btn-xs btn-mini"><i class="glyphicon glyphicon-pencil"></i>修改</button>
                                        <button data-id="<?php echo $v['id']; ?>" type="button" data-model="article" class="del btn update btn-outline btn-danger btn-xs btn-mini"><i class="glyphicon glyphicon-trash"></i>删除</button>

                                    </div>
                                </div>

                                <?php if (is_array($v['children'])): foreach ($v['children'] as $k1 => $v1): ?>
                                    <ol class="dd-list">
                                        <li class="dd-item">
                                            <div class="dd-handle">
                                                <i class="fa fa-home"></i><?php echo $v1['name']; ?>
                                                <div class="sort-left">
                                                    <?php if($v1['is_show'] == 1):?>
                                                        <button data-id="<?php echo $v1['id']; ?>" data-action="hide" data_type="brand" class="action btn btn-warning radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">隐藏</span></button>
                                                    <?php else:?>
                                                        <button data-id="<?php echo $v1['id']; ?>" data-action="show" data_type="brand" class="action btn btn-default radius btn-xs btn-outline"  type="button"><i class="glyphicon glyphicon-refresh"></i> <span class="bold">显示</span></button>
                                                    <?php endif;?>

                                                    <button data-id="<?php echo $v1['id']; ?>" data-toggle="modal" data-target="#cate" data-model="article" data-name="<?php echo $v1['name']; ?>" type="button" data-sort="<?php echo $v['sort']; ?>" class="btn update btn-success  btn-outline btn-xs"><i class="glyphicon glyphicon-pencil"></i>修改</button>

                                                    <button data-id="<?php echo $v1['id']; ?>" type="button" data-model="article" class="del btn update btn-danger btn-outline btn-xs"><i class="glyphicon glyphicon-trash"></i>删除</button>
                                                </div>
                                            </div>
                                            <?php if (is_array($v1['children'])): foreach ($v1['children'] as $k2 => $v2): ?>
                                                <ol class="dd-list">
                                                    <li class="dd-item">
                                                        <div class="dd-handle">
                                                            <i class="fa fa-tag"></i><?php echo $v2['name']; ?>
                                                            <div class="sort-left">
                                                                <button data-id="<?php echo $v2['id']; ?>" data-toggle="modal" data-target="#cate" data-name="<?php echo $v2['name']; ?>" data-sort="<?php echo $v['sort']; ?>" type="button" data-model="article" class="btn update btn-success btn-xs">修改</button>
                                                                <button data-id="<?php echo $v2['id']; ?>" type="button" data-model="article" class="del btn update btn-danger btn-xs">删除</button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ol>
                                            <?php endforeach; endif; ?>
                                        </li>
                                    </ol>
                                <?php endforeach; endif; ?>
                            </li>
                        </ol>
                    <?php endforeach; endif; ?>
                </div>
            </div>

        </div>
    </div>


    <!-- 申请的品牌   -->
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><i class="fa fa-cart-plus">　</i>申请品牌</h3>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center"><b>品牌名称</b></th>
                            <th class="text-center"><b>品牌等级</b></th>
                            <th class="text-center"><b>品牌图片</b></th>
                            <th class="text-center"><b>操作</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (is_array($listArticle)): foreach ($listArticle as $k => $v): ?>
                            <tr>
                                <td align="center"><?php echo($v["name"]); ?></td>

                                <td align="center">
                                    <?php if($v["pid"] == 0):?>
                                        <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="#">顶级品牌</a>
                                    <?php else:?>
                                        <a class="btn btn-info btn-rounded btn-outline btn-xs" href="#"> 顶级品牌：<?php echo \backend\models\ArticleCate::return_brand($v["pid"]) ?></a>
                                    <?php endif;?>
                                </td>


                                <td align="center">
                                    <?php if (!empty($v['img'])):?>
                                    <img class="goods_img" src="<?php echo Yii::$app->params['API_HOST'].$v['img']?>">
                                    <?php endif;?>
                                </td>

                                <td align="center">
                                    <a class="btn btn-primary btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['cate/status-brand','id'=>$v['id'],'status'=>1])?>"><i class="fa fa-check"></i>&nbsp;通过审核</a>&nbsp;&nbsp;&nbsp;&nbsp;

                                    <button data-id="<?php echo $v['id'] ?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-outline btn-xs Brand-del btn-rounded"><i class="fa fa-trash-o"></i>&nbsp;删除</button>

                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                    <div class="col-sm-12 page">
                        <div class="pull-right">
                            <?= LinkPager::widget([
                                'pagination' => $pagesArticle,
                                'nextPageLabel' => '下一页',
                                'prevPageLabel' => '上一页',
                                'firstPageLabel' => '首页',
                                'lastPageLabel' => '尾页',
                            ]); ?>
                        </div>
                    </div>
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
                <h4 class="modal-title" id="cate_title">分类添加</h4>
                <h4 id="top_cate"></h4>
                <small id="response_info" class="label label-info"></small>
            </div>
            <form class="form-horizontal myform" onsubmit="return false;">
                <input type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                <input type="hidden" id="cate_id" name="id" value="0">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">分类名称:</label>
                        <input type="hidden" id="cate_pid" name="pid" value="0">
                        <div class="col-sm-8">
                            <input type="text" name="name" id="cate_name" placeholder="分类名称" class="form-control cate_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">排序:</label>
                        <div class="col-sm-8">
                            <input type="number" id="cate_sort" name="sort" placeholder="排序" class="form-control cate_sort">
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


<!--添加商品品牌 弹窗-->
<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <form action="<?php echo Url::to(['cate/add'])?>" method="post" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <h3 class="m-t-none m-b">商品品牌</h3>

                            <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken ?>" />

                            <input type="hidden" id="brand_id" name="id" value=""/>

                            <div class="form-group">
                                <label>父级品牌：</label>
                                <input id="name" type="text" value="" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>添加品牌：</label>
                                <input   type="text"   name="name" placeholder="请输入新品牌名称..." class="form-control">
                            </div>
                            <div>
                                <button id="check" class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>保存</strong></button>
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <p>
                            <div class="file-box" style="margin-top: 10px;width:300px;border: none">
                                <div class="file"><span class="corner"></span>
                                    <div  id="ic" class="icon" style="height:100%;padding: 0px;border: none" onclick="document.getElementById('upload').click()">
                                        <input type="file" id="upload" style="display: none;"  name="files" accept="image/gif,image/jpeg,image/jpg,image/png,image/svg">
                                        <img id="myImage" src="/img/click.png" title="点击上传图片"  style="width:60%;height: 60%;cursor: pointer;border: none">
                                    </div>
                                </div>
                            </div>
                            </p>
                            <P id="texts" style="color: #E2E8EA"></P>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
</script>

<script>
    $(document).ready(function(){var updateOutput=function(e){var list=e.length?e:$(e.target),output=list.data("output");if(window.JSON){output.val(window.JSON.stringify(list.nestable("serialize")))}else{output.val("浏览器不支持")}};$("#nestable").nestable({group:1}).on("change",updateOutput);$("#nestable2").nestable({group:1}).on("change",updateOutput);updateOutput($("#nestable").data("output",$("#nestable-output")));updateOutput($("#nestable2").data("output",$("#nestable2-output")));$("#nestable-menu").on("click",function(e){var target=$(e.target),action=target.data("action");if(action==="expand-all"){$(".dd").nestable("expandAll")}if(action==="collapse-all"){$(".dd").nestable("collapseAll")}})});
</script>
<?php
$js = <<<JS
            //页面加载执行
            $(function(){ 
                $('.hides').click();
            });
    
            //技能图片编辑
            $('#upload').on('change',function (event)
        
            {
        
                console.log(event.target.files);
        
                var allLen=event.target.files.length;
        
                if(allLen >1){
        
                    alert('图片不能多于6张');
        
                    return false;
        
                }
        
                var html = "";
        
                for(var i=0; i<allLen; i++){
        
                    var tmppath = window.webkitURL.createObjectURL(event.target.files[i]);
        
        
                    html+='<img src="'+tmppath+'" alt="" title="点击上传图片"  style="width:100%; height:100%;cursor: pointer;">';
        
                }
        
                $(this).parent('div').find('img').remove();
                $(this).parent('div').append(html);
                //$("#inform_show_img").html(html);
        
            });
        
             //显示品牌
             $(".modal-form").on('click',function() {
                $("#brand_id").val($(this).attr('data-id'));
                $("#name").val($(this).attr('data-name'));
            });
            
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


        $('#nestable').nestable({
                group: 2
            }).on('change', updateOutput);
        
        $('#nestable2').nestable({
            group: 1
        }).on('change', updateOutput);
        
        updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        
        updateOutput($('#nestable').data('output', $('#nestable-output')));

        $('#nestable2-menu').on('click', function (e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('#nestable2').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('#nestable2').nestable('collapseAll');
            }
            
        });
        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'article_expand-all') {
                $('#nestable').nestable('expandAll');
            }
            if (action === 'article_collapse-all') {
                $('#nestable').nestable('collapseAll');
            }
        });
    var url='';
    var model='';
    $("#cate_submit").on("click", function () {
        $(".myform").ajaxSubmit({
            url: url,
            type: "post",
            dataType: "json",
            data:{'model':model},
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
    $(".add").on('click',function() {
        url='/cate/create';
        model=$(this).attr('data-model')!==undefined?'article':'';
        var pid=$(this).attr('data-pid');
        //清空上次写入
        $("#cate_name").val('');
        $("#cate_sort").val('');
        $("#top_cate").html('');
        $("#response_info").text('');
        
        //默认顶级分类
        if (pid!==undefined){
           $("#cate_title").text('添加分类');
           $("#top_cate").html('父级分类为:'+'<span class="label label-primary">'+$(this).attr('data-name')+'</span>');
           $("#cate_pid").val($(this).attr('data-id')); 
        }else{
           $("#cate_title").text('添加顶级分类');
        }
    });

    $(".update").on('click',function() {
        model=$(this).attr('data-model')!==undefined?'article':'';
        url='/cate/update';
      //清空上次父级分类标识
      $("#top_cate").html('');
      $("#response_info").text('');
      
      $("#cate_title").text('修改分类');
      $("#cate_id").val($(this).attr('data-id'));
      $("#cate_name").val($(this).attr('data-name'));
      $("#cate_sort").val($(this).attr('data-sort'));

    });

    
            $(".del").click(function () {
            var del = $(this);
            var id=$(this).attr('data-id');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此分类吗？',
                ok: function () {
                    $.ajax({
                        url: "/cate/delete",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
                            'model':model,
                            '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
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
                content: '您确定要显示此品牌吗？',
                ok: function () {
                    $.ajax({
                        url: "/cate/operation",
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
            
            
            //删除申请的分类
            $(".Apply-del").click(function () {
            var del = $(this);
            var id=$(this).attr('data-id');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此申请分类吗？',
                ok: function () {
                    $.ajax({
                        url: "/cate/del",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
                            'model':model,
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
            
             //删除申请的品牌
            $(".Brand-del").click(function () {
            var del = $(this);
            var id=$(this).attr('data-id');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此申请品牌吗？',
                ok: function () {
                    $.ajax({
                        url: "/cate/del-brand",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
                            'model':model,
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