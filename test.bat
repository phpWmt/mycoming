@Echo Off
Title Yii脚本测试     _______By:肆意
Pushd %~dp0
Rd "%SystemRoot%\system32\CCAV1_Yanu" 2>nul
Md "%SystemRoot%\system32\CCAV1_Yanu" 2>nul||(Echo 请右键管理员身份运行&&Pause >nul&&Exit)
Rd "%SystemRoot%\system32\CCAV1_Yanu" 2>nul
Echo Yii队列发送邮件。&&Pause
Cls
./yii mailer/send
Echo 按任意键退出即可！&&Pause