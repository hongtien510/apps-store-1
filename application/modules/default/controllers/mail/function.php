<?php
public function sendmail($mailto, $nameto, $namefrom, $subject, $noidung, $namereplay, $emailreplay)
	{
		$mail = new PHPMailer();
		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = "smtp.gmail.com"; // specify main and backup server
		$mail->Port = 465; // set the port to use
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->SMTPSecure = 'ssl';
		$mail->Username = "hongtien.51090@gmail.com"; // your SMTP username or your gmail username// Email gui thu
		$mail->Password = "phamhongtien510"; // your SMTP password or your gmail password
		//$from = $mailfrom; // Reply to this email// Email khi reply
        $mail->CharSet="utf-8";
		$from = $emailreplay; // Reply to this email// Email khi reply
		$to= $mailto; // Recipients email ID // Email nguoi nhan
		$name= $nameto; // Recipient's name // Ten cua nguoi nhan
		$mail->From = $from;
		$mail->FromName = $namefrom; // Name to indicate where the email came from when the recepient received// Ten nguoi gui
		$mail->AddAddress($to,$name);
		$mail->AddReplyTo($from,$namereplay);// Ten trong tieu de khi tra loi
		$mail->WordWrap = 50; // set word wrap
		$mail->IsHTML(true); // send as HTML
		$mail->Subject = $subject;
		$mail->Body = $noidung; //HTML Body
		$mail->AltBody = ""; //Text Body

		if(!$mail->Send())
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}