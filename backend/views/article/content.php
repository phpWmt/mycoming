<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        .device-ios {
            width: 320px;
            height: 548px;
            background: #111;
            border-radius: 55px;
            box-shadow: 0px 0px 0px 2px #aaa;
            padding: 105px 20px;
            position: relative;
            margin-right: 80px;
        }
        .device-ios:before {
            content: '';
            width: 60px;
            height: 10px;
            border-radius: 10px;
            position: absolute;
            left: 50%;
            margin-left: -30px;
            background: #333;
            top: 50px;
        }
        .device-ios:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            left: 50%;
            margin-left: -30px;
            bottom: 20px;
            border-radius: 100%;
            box-sizing: border-box;
            border: 5px solid #333;
        }
        .device-inner {
            background-color: #FFF;
            height: 100%;
        }
        body{
            margin:0px 0px 0px 500px;
        }
    </style>
</head>
<body>
<div class="device-ios">
    <div class="device-inner">
        <?php foreach ($content as $value):?>
            <a style="text-decoration : none" href="http://<?php echo  $_SERVER['SERVER_NAME']?>/article/article-content?id=<?php echo $value['id']?>">
                <div class="text-center article-title" style="padding: 22px;border-bottom: 1px solid #DFDFDF;background: #FCFCFC">
                    <?php echo $value['title']?>
                    <img style="float: right;width: 30px" src="/img/right.png" alt="">
                </div>
            </a>
        <?php endforeach;?>
    </div>
</div>
</body>
</html>