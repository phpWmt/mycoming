@Echo Off
Title Yii�ű�����     _______By:����
Pushd %~dp0
Rd "%SystemRoot%\system32\CCAV1_Yanu" 2>nul
Md "%SystemRoot%\system32\CCAV1_Yanu" 2>nul||(Echo ���Ҽ�����Ա�������&&Pause >nul&&Exit)
Rd "%SystemRoot%\system32\CCAV1_Yanu" 2>nul
Echo Yii���з����ʼ���&&Pause
Cls
./yii mailer/send
Echo ��������˳����ɣ�&&Pause