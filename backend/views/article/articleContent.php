
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

        p{
            font-size: 14px;
            line-height: 20px;
            text-indent:2em;
            margin : 10px 5px 0px 5px;
        }
        .nav{
            background:#fff;
            height:35px;
            font-size:14px;
            text-decoration: none;
            color: #333333;
            text-align: center;
            position: relative;
            border-bottom: 1px solid #eeeeee;
        }
        .nav a{
            position: absolute;
            left: 0px;
            top:0px;
            width: 30px;
            height: 27px;
            padding-top: 7px;
        }
        .nav p{
            font-size: 15px;
        }
        .nav .title_tx{
            line-height: 35px;
            font-size: 16px;
        }

        body{
            margin:0px 0px 0px 500px;
        }
    </style>
</head>
<body>
<div class="device-ios">
    <div class="device-inner" style="float:left;overflow:auto;">
        <div class="nav" style="padding: 10px">
            <div class="title_tx"><?php echo $content['title']; ?></div>
        </div>
         <?php echo $content['content']; ?>
    </div>
</div>

</body>
</html>
