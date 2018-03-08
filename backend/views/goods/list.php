<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品列表</h3>
                </div>

                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 p-m">
                            <form method="get">
                                <div class="input-group list-group" style="float:left; margin-right: 10px;">
                                        <span style="float:left;">
                                            <select class="form-control" name="cate_id">
                                            <option value="">分类选择</option>
                                                <?php if(is_array($cate)&&!empty($cate)): foreach ($cate as $k=>$v):?>
                                                    <option value="<?php echo $v['id']; ?>" disabled><?php echo $v['name'] ?></option>
                                                    <?php if(!empty($v['children'])): foreach ($v['children'] as $k1=>$v1):?>
                                                        <option value="<?php echo $v1['id']; ?>"><?php echo '　　'.$v1['name'] ?></option>
                                                        <?php if(!empty($v1['children'])): foreach ($v1['children'] as $k2=>$v2):?>
                                                            <option value="<?php echo $v2['id']; ?>"><?php echo '　　　　'.$v2['name'] ?></option>
                                                        <?php endforeach;endif;?>
                                                    <?php endforeach;endif;?>
                                                <?php endforeach;endif;?>
                                            </select>
                                        </span>
                                </div>

                                <div class="input-group list-group" style="float:left; margin-right: 10px;">
                                        <span style="float:left;">
                                            <select class="form-control" name="brand_id">
                                            <option value="">品牌选择</option>
                                                <?php if(is_array($article_cate)&&!empty($article_cate)): foreach ($article_cate as $k=>$v):?>
                                                    <option value="<?php echo $v['id']; ?>" disabled><?php echo $v['name'] ?></option>
                                                    <?php if(!empty($v['children'])): foreach ($v['children'] as $k1=>$v1):?>
                                                        <option value="<?php echo $v1['id']; ?>"><?php echo '　　'.$v1['name'] ?></option>
                                                        <?php if(!empty($v1['children'])): foreach ($v1['children'] as $k2=>$v2):?>
                                                            <option value="<?php echo $v2['id']; ?>"><?php echo '　　　　'.$v2['name'] ?></option>
                                                        <?php endforeach;endif;?>
                                                    <?php endforeach;endif;?>
                                                <?php endforeach;endif;?>
                                            </select>
                                        </span>
                                </div>

                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" name="start_time" placeholder="开始时间"
                                           class="input-sm form-control time">
                                </div>
                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" id="time" name="end_time" placeholder="结束时间"
                                           class="input-sm form-control time">
                                </div>
                                <div class="input-group list-group col-sm-2">
                                    <input type="text" name="keyword" placeholder="请输入商品名称"
                                           class="input-sm form-control">
                                    <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary">搜索</button></span>
                                </div>
                            </form>
                            <a href="<?php echo Url::to(['goods/create']) ?>"><button type="button" class="btn btn-sm btn-primary btn-outline"><i class="glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;添加商品</button></a>
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
                                <th class="text-center"><b>商品名称</b></th>
                                <th class="text-center"><b>商品分类</b></th>
                                <th class="text-center"><b>商品品牌</b></th>
                                <th class="text-center"><b>所属仓库</b></th>
                                <th class="text-center"><b>商品单价</b></th>
                                <th class="text-center"><b>封面图片</b></th>
                                <th class="text-center"><b>创建时间</th>
                                <th class="text-center"><b>商品出入库</th>
                                <th class="text-center"><b>操作</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($list)): foreach ($list as $k => $v): ?>
                                <tr>
                                    <td align="center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" name="check" value="<?php echo $v['id'] ?>">
                                        </label>
                                    </td>
                                    <td align="center"><?php echo($v["title"]); ?></td>
                                    <td align="center">
                                        <a class="btn btn-info btn-rounded btn-outline btn-xs" href="#">     <?php echo($v["cate"]['name']); ?></a>
                                    </td>
                                    <td align="center">
                                        <a class="btn btn-info btn-rounded btn-outline btn-xs" href="#">   <?php echo($v["brand"]['name']); ?></a>
                                    </td>

                                    <td align="center">
                                        <a class="btn btn-default btn-rounded btn-outline btn-xs" href="#"><i class="glyphicon glyphicon-th-list"></i> &nbsp;<?php echo($v["entrepot"]['entrepot_name'] ? $v["entrepot"]['entrepot_name'] : "总仓库" ); ?></a>
                                    </td>

                                    <td align="center"><?php echo($v["list_price"]); ?></td>
                                    <td align="center"><img class="goods_img" src="<?php echo (Yii::$app->params['API_HOST'].$v["cover"]); ?>"></td>

                                    <td align="center"><?php echo($v["create_time"]); ?></td>

                                    <td align="center">
                                        <a href="<?php echo Url::to(['goods/godown','id'=>$v['id']]) ?>">
                                            <button type="button" class="btn btn-success btn-rounded btn-xs btn-outline"><i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;商品出入库</button>
                                        </a>
                                    </td>

                                    <td align="center">

                                        <a href="<?php echo Url::to(['goods/add-list','id'=>$v['id']]) ?>">
                                            <button type="button" class="btn btn-danger btn-outline btn-xs"><i class="fa fa-paste"></i>&nbsp;规格管理</button>
                                        </a>

                                        <a href="<?php echo Url::to(['goods/spec-list','id'=>$v['id']]) ?>">
                                            <button type="button" class="btn btn-info btn-outline btn-xs btn-rounded"><i class="fa fa-paste"></i>&nbsp;规格管理</button>
                                        </a>


                                        <a href="<?php echo Url::to(['goods/update','id'=>$v['id']]) ?>">
                                            <button type="button" class="btn btn-primary btn-outline btn-xs btn-rounded"><i class="fa fa-paste"></i>&nbsp;编辑</button>
                                        </a>

                                        <button data-id="<?php echo $v['id'] ?>" href="javascript:void (0)" type="button" class="btn btn-warning btn-outline btn-xs del btn-rounded "><i class="fa fa-trash-o"></i>&nbsp;回收站</button>

                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                        <div class="col-sm-12 page">
                            <span >共<strong><?php echo $pages->totalCount; ?></strong>条记录</span>
                            <div class="pull-right">
                                <?= LinkPager::widget([
                                    'pagination' => $pages,
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

<?php
$js=<<<JS

        $(".i-checks").iCheck({checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"})
            // 全选
        $('.all-checks').on('ifChecked', function (event) {
            $("input[type='checkbox']").iCheck('check');
        });
        // 反选
        $('.all-checks').on('ifUnchecked', function (event) {
            $("input[type='checkbox']").iCheck('uncheck');
        });
            lay('.time').each(function(index,obj){
                var date_value=index==1?new Date():'';
                laydate.render({
                elem: obj,
                type: 'datetime',
                theme:'molv',//墨绿主题
                trigger: 'click',//日期只读
                value:date_value
                });
            });
            
            //批量删除
            $("#delete_all").click(function () {
            var id='';
            $('input[name="check"]:checked').each(function (i, obj) {
                id=$(obj).val()+','+id;
            });
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: "您确定要批量删除这些商品吗？删除此商品<b>入库商品</b>也将被删除！<br/><b>删除后.不可恢复。</b>",
                ok: function () {
                    $.ajax({
                        url: "/goods/delete",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
                            '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if(data.status === 1) {
                                dialog({content: data.info}).showModal();
                                setTimeout(function (){
                                    window.location.reload();
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
            
            
        $(".del").click(function () {
            var dele = $(this);
            var id=$(this).attr('data-id');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要将此商品放入回收站吗？',
                ok: function () {
                    $.ajax({
                        url: "/goods/update-delete",
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
    
        /* 设置状态 */
        $('.status').click(function () {
            _Itab = $(this).children('i');
            var aid = $(this).attr('aid');
            var status = _Itab.attr('data-status') === '1' ? 2 : 1;
            $.ajax({
                type: "post",
                url: "/admin/status",
                data: {
                    id: aid,
                    status: status,
                    '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.status === 1) {
                        console.log(status);
                        if (status === 2) {
                            _Itab.attr('data-status', 2).removeClass('fa-lock text-warning').addClass('fa-check text-navy');
                            _Itab.attr('title','账号正常');
                        } else {
                            _Itab.attr('data-status', 1).removeClass('fa-check text-navy').addClass('fa-lock text-warning');
                            _Itab.attr('title','账户锁定则不允许登录');
                        }
                        var success=dialog({content: data.info}).showModal();
                        setTimeout(function () {
                            success.close();
                        }, 800);
                    } else {
                        dialog({
                            title: "提示",
                            content: data.info,
                            ok: true
                        }).showModal();
                    }
                }
            });
        });
JS;
$this->registerJs($js);
?>
</body>