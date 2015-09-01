<?php
	//SMTP server settings	
	$host = "smtp.qq.com";
    $port = "25";
    $username = "";
    $password = "";

    if($host=="" or $username=="" or $password==""){
        exit('请设置服务器邮箱信息');
    }

    $messageBody = $subject = "";
    if($_POST['name']!='false'){
        $messageBody .= '<p>联系人: ' . strip_tags($_POST["name"]) . '</p>' . "\n";
    }
    if($_POST['phone']!='false'){
        $messageBody .= '<p>联系电话: ' . strip_tags($_POST['phone']) . '</p>' . "\n";
    }
    if($_POST['message']!='false'){
        $messageBody .= '<p>留言: ' . strip_tags($_POST['message']) . '</p>' . "\n";
    }
    if(trim($_GET['do'])=='contacts'){
        $subject = '【丽江旅游定制平台】'.strip_tags($_POST["name"]).' 发来留言';
    }else if(trim($_GET['do'])=='booking'){
        $subject = '【丽江旅游定制平台】'.strip_tags($_POST["name"]).' 发来预定';
        if($_POST['adults']!='false'){
            $messageBody .= '<p>成人: ' . (strip_tags($_POST["adults"])+0) . '</p>' . "\n";
        }
        if($_POST['children']!='false'){
            $messageBody .= '<p>小孩: ' . (strip_tags($_POST['children'])+0) . '</p>' . "\n";
        }
        if($_POST['bags']!='false'){
            $messageBody .= '<p>行李: ' . (strip_tags($_POST['bags'])+0) . '</p>' . "\n";
        }
        if($_POST['rooms']!='false'){
            $messageBody .= '<p>房间: ' . (strip_tags($_POST['rooms'])+0) . '</p>' . "\n";
        }
    }
	
    require("phpmailer/class.phpmailer.php");
    require("phpmailer/class.smtp.php");

    //以下是实例:
    $mail = new phpmailer(); //建立邮件发送类
    $mail->SetLanguage('zh_cn');
    $mail->Host = $host; // 您的企业邮局域名
    $mail->Port = $port; // 您的企业邮局域名
    $mail->SMTPAuth = true; // 启用SMTP验证功能
    $mail->Username = $username; // 邮局用户名(请填写完整的email地址)
    $mail->Password = $password; // 邮局密码
    $mail->From = $username; //邮件发送者email地址
    $mail->FromName = $username;
    $mail->AddAddress("814420673@qq.com", "814420673");//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
    $mail->IsHTML(true); // set email format to HTML //是否使用HTML格式
    $mail->Subject = $subject; //邮件标题
    $mail->Body = $messageBody; //邮件内容
    $mail->IsSMTP(); // 使用SMTP方式发送
    if(!$mail->Send())
    {
         echo "邮件发送失败: " . $mail->ErrorInfo;
         exit;
    }

    echo "邮件发送成功";
    exit();
?>