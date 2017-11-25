<?php
echo "U cannot hack this one";
//https://api.telegram.org/bot460801714:AAE7e6kNdBcdrLhgisGpWpwEG7LXhN4B97A/setwebhook?url=https://autolist.000webhostapp.com/autolist.v.0.7.php
ob_start();
date_default_timezone_set("Asia/Aden");
include "settings.php";
$update = json_decode(file_get_contents("php://input"));
$msg = $update->message;
$text =$msg->text;
$chat_id = $msg->chat->id;
$from_id = $msg->from->id;
$message_id = $msg->message_id;
$iscommand = array("/start","/setrepost","/setperiod","/starttext","/endtext","/midtext","/getrepost","/getperiod","/getstarttext","/getendtext","/getmidtext","/on","/off","/add","/delete","/sendid","/announce","/dannounce","/dlannounce","/dannounceid","/deleteforward","/recount","/fixed","/unfixed","/settime","gettime","/cancel","/reset","/send","/del");
function message($mchat_id, $mtext)
    {
        global $token;
		$ret=json_decode(file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$mchat_id&text=$mtext&parse_mode=HTML"));
		return $ret;
    }
function deletemessage($dchat_id, $dmsgid)
{
    global $token;
	$ret=json_decode(file_get_contents("https://api.telegram.org/bot$token/deleteMessage?chat_id=$dchat_id&message_id=$dmsgid"));
	return $ret;
}
function refreshvalues()
{
    global $period,$repost,$reposts,$stext,$etext,$midtext,$ison,$isoff,$announceid,$time;
    
	$period=(int)file_get_contents("lib/period.txt");
	$repost=(int)file_get_contents("lib/repost.txt");
	$reposts=$period*(60/$repost);
	$stext=file_get_contents("lib/stext.txt");
	$etext=file_get_contents("lib/etext.txt");
	$midtext=file_get_contents("lib/midtext.txt");
	$ison=file_get_contents("lib/ison.txt");
	$isoff=file_get_contents("lib/isoff.txt");
	$announceid=(int)file_get_contents("lib/announce.txt");
	$time=file_get_contents("lib/time.txt");
}

refreshvalues();

if(in_array($from_id, $sudo))
{
if(in_array($text, $iscommand))
    file_put_contents("lib/command.txt","command");
$commandtype=file_get_contents("lib/command.txt");
	
switch($commandtype)
{
case "command":
{
switch($text)
{
	case "/start":
		// الرسالة الترحيبية
		$welcome="مرحبا بك أنت مدير البوت\n".
		"هذه الأوامر التي يمكنك استخدامها\n".
		"--------------------\n".
		"/setrepost\n".
		"- ضبط فترة اعادة النشر في الارسال المثبت\n".
		"--------------------\n".
		"/setperiod\n".
		"- ضبط فترة النشر\n".
		"--------------------\n".
		"/settime\n".
		"- ضبط وقت النشر\n".
		"--------------------\n".
		"/fixed\n".
		"- تثبيت القائمة\n".
		"--------------------\n".
		"/unfixed\n".
		"- الغاء تثبيت القائمة\n".
		"--------------------\n".
		"/starttext\n".
		"- ضبط نص البداية\n".
		"--------------------\n".
		"/endtext\n".
		"- ضبط نص النهاية\n".
		"--------------------\n".
		"/midtext\n".
		"- ضبط الفاصل بين القنوات\n".
		"--------------------\n".
		"/getrepost\n".
		"- قراءة فترة اعادة النشر في الارسال المثبت\n".
		"--------------------\n".
		"/getperiod\n".
		"- قراءة فترة النشر\n".
		"--------------------\n".
		"/gettime\n".
		"- قراءة وقت النشر\n".
		"--------------------\n".
		"/getstarttext\n".
		"- قراءة نص البداية\n".
		"--------------------\n".
		"/getendtext\n".
		"- قراءة نص النهاية\n".
		"--------------------\n".
		"/getmidtext\n".
		"- قراءة الفاصل بين القنوات\n".
		"--------------------\n".
		"/on\n".
		"- تشغيل النشر\n".
		"--------------------\n".
		"/off\n".
		"- ايقاف النشر\n".
		"--------------------\n".
		"/add\n".
		"- اضافة قناة\n".
		"--------------------\n".
		"/delete\n".
		"- حذف قناة\n".
		"--------------------\n".
		"/recount\n".
		"- تحديث عدد الأعضاء\n".
		"--------------------\n".
		"/sendid\n".
		"- ارسال لقناة محددة\n".
		"--------------------\n".
		"/announce\n".
		"- ارسال تعميم\n".
		"--------------------\n".
		"/dannounce\n".
		"- حذف جميع التعميمات\n".
		"--------------------\n".
		"/dlannounce\n".
		"- حذف التعميم الأخير\n".
		"--------------------\n".
		"/dannounceid\n".
		"- حذف تعميم عن طريق المعرف\n".
		"--------------------\n".
		"/deleteforward\n".
		"- حذف رسالة باعادة التوجيه\n".
		"--------------------\n".
		"/cancel\n".
		"- الغاء العملية الحالية";
		
		message($chat_id,urlencode($welcome));
	break;
	
	
	case "/setperiod":
	//ضبط الفترة الكاملة
	message($chat_id, " أرسل فترة النشر بالساعات");
	file_put_contents("lib/command.txt","period");
	break;
	
	
	case "/setrepost":
	//ضبط الفترة بين المنشورات
		message($chat_id, "أدخل الوقت بين عمليات النشر");
		file_put_contents("lib/command.txt","repost");
	break;
	
	
	case "/starttext":
	//ضبط نص البداية
	message($chat_id, "أدخل نص البداية");
		file_put_contents("lib/command.txt","starttext");
	break;
	
	case "/endtext":
	//ضبط نص النهاية
	message($chat_id, "أدخل نص النهاية");
		file_put_contents("lib/command.txt","endtext");
	break;
	
	case "/midtext":
	//ضبط نص الوسط
	message($chat_id, "أدخل الفاصل بين القنوات");
		file_put_contents("lib/command.txt","midtext");
	break;
	
	case "/sendid":
	message($chat_id, urlencode("أدخل معرف القناة و الرسالة بالطريقة التالية\n @example|الرسالة"));
	file_put_contents("lib/command.txt","sendid");
	break;
	
	case "/getrepost":
	//قراءة الفترة بين المنشورات
	message($chat_id,"$repost دقيقة");
	break;
	
	case "/getperiod":
	//قراءة الفترة الكاملة
	message($chat_id,"$period ساعة");
	break;
	
	case "/getstarttext":
	//قراءة نص البداية
	message($chat_id,"$stext");
	break;
	
	case "/getendtext":
	//قراءة نص النهاية
	message($chat_id,"$etext");
	break;
	
	case "/getmidtext":
	//قراءة نص الوسط
	message($chat_id,"$midtext");
	break;
	
	case "/add":
	//اضافة قناة
	message($chat_id,urlencode("أدخل معرف القناة وعنوانها بالطريقة التالية \n@example|عنوان القناة") );
		file_put_contents("lib/command.txt","add");
	break;
	
	case "/delete":
	//حذف قناة
	message($chat_id, "أدخل معرف القناة" );
		file_put_contents("lib/command.txt","delete");
	break;
	
	
	
	case "/recount":
	//تحديث عدد الأعضاء
		$result=$conn->query("SELECT id FROM Channels");
		while ($row = $result->fetch_assoc()) 
		{
			$count=round(json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMembersCount?chat_id=$row[id]"))->result,-3)/1000;
			$conn->query("UPDATE Channels
			SET members = '$count'
			WHERE id = '$row[id]'");
		}
		if($conn->affected_rows >= 1)
			message($chat_id, "تم تحديث عدد الأعضاء");
		else
			message($chat_id, "لم يتم تحديث عدد الأعضاء");
	break;
	
	case "/announce":
	//ارسال تعميم
	message($chat_id, "أرسل التعميم" );
		file_put_contents("lib/command.txt","announce");
	break;
	
	case "/dannounce":
	//حذف جميع التعميمات
		$result=$conn->query("SELECT chid , msgid FROM Announce");
		while ($row = $result->fetch_assoc()) 
		{
			deletemessage($row[chid],$row[msgid]);
        }
		$conn->query("DELETE FROM Announce");
		if($conn->affected_rows >= 1)
			message($chat_id, "تم حذف التعميمات");
		else
			message($chat_id, "لا يوجد تعميمات لحذفها");
		file_put_contents("lib/announce.txt","0");
	break;
	
	case "/dlannounce":
	//حذف التعميم الأخير
		$result=$conn->query("SELECT chid , msgid FROM Announce WHERE id ='$announceid'");
		while ($row = $result->fetch_assoc()) 
		{
			deletemessage($row[chid],$row[msgid]);
        }
		$conn->query("DELETE FROM Announce WHERE id ='$announceid'");
		if($conn->affected_rows >= 1)
		{
			message($chat_id, "تم حذف التعميم");
			$announceid--;
			file_put_contents("lib/announce.txt",$announceid);
		}
		else
			message($chat_id, "لا يوجد تعميمات لحذفها");
	break;
	
	case "/dannounceid":
	//حذف تعميم بالمعرف
		message($chat_id, "أدخل معرف التعميم" );
		file_put_contents("lib/command.txt","dannounceid");
	break;
	
	case "/deleteforward":
	//حذف منشور بالتوجيه
	message($chat_id, "قم باعادة توجيه الرسالة الى هنا" );
	file_put_contents("lib/command.txt","deleteforward");
	break;
	
	case "/on":
	//تشغيل النشر
	if($isoff)
	{
		file_put_contents("lib/isoff.txt","");
		file_put_contents("lib/ison.txt","t");
		$ison=file_get_contents("lib/ison.txt");
	    message($chat_id, "تم تشغيل النشر" );
		while($ison)
		{
			$time=file_get_contents("lib/time.txt");
		    $nowtime=date("H:m");
		    if($nowtime==$time)
		    {
				$fixed=file_get_contents("lib/fixed.txt");
		        $counter=1;
		        refreshvalues();
		        $result=$conn->query("SELECT members,username,title FROM Channels ORDER BY members + 0 DESC");
	        	while ($row = $result->fetch_assoc()) 
	        	{
	        	    if ($counter & 1)
	        	    {
	        	        $chtext="$row[members]K|$row[username] $row[title]\n";
        			    $ftext=$ftext.$midtext."\n".$chtext;
	        	    }
	        	    else
	        	    {
	        	        $chtext="$row[members]K|$row[username] $row[title]\n";
        			    $ltext=$midtext."\n".$chtext.$ltext;  
	        	    }
	        	    $counter++;
                }
                $post=$stext."\n".$ftext.$ltext.$midtext."\n".$etext;
                $result=$conn->query("SELECT id FROM Channels");
                
				if($fixed)
				{
					for($i=0;$i<$reposts;$i++)
					{
						$counter=1;
						while ($row = $result->fetch_assoc()) 
						{
							$ret = message($row[id],urlencode($post));
							$msgid=$ret->result->message_id;
							$conn->query("INSERT INTO post
							VALUES ('$row[id]','$msgid')");
							//if($counter % 20 == 0)
								//sleep(1);
							//$counter++;
						}
						sleep($repost*60);
						
						$result2=$conn->query("SELECT chid , msgid FROM post");
                		while ($row2 = $result2->fetch_assoc()) 
                		{
                			deletemessage($row2[chid],$row2[msgid]);
                        }
						$conn->query("DELETE FROM post");
					}
				}
                else
				{
					$counter=1;
					while ($row = $result->fetch_assoc()) 
					{
						$ret = message($row[id],urlencode($post));
						$msgid=$ret->result->message_id;
						$conn->query("INSERT INTO post
						VALUES ('$row[id]','$msgid')");
						if($counter%20 == 0)
							sleep(1);
						$counter++;
					}
					sleep($period*3600);
					
					$result=$conn->query("SELECT chid , msgid FROM post");
					while ($row = $result->fetch_assoc()) 
					{
						deletemessage($row[chid],$row[msgid]);
					}
					$conn->query("DELETE FROM post");
				}
		    }
		    sleep(30);
		    $ison=file_get_contents("lib/ison.txt");
		}
		file_put_contents("lib/isoff.txt","t");
		message($chat_id, "تم ايقاف تشغيل النشر" );
	}
	break;
	
	case "/off":
	//ايقاف تشغيل النشر
	file_put_contents("lib/ison.txt","");
	break;
	
	case "/send":
	    $counter=1;
		refreshvalues();
        $result=$conn->query("SELECT members,username,title FROM Channels ORDER BY members + 0 DESC");
    	while ($row = $result->fetch_assoc()) 
    	{
    	    if ($counter & 1)
    	    {
    	        $chtext="$row[members]K|$row[username] $row[title]\n";
			    $ftext=$ftext.$midtext."\n".$chtext;
    	    }
    	    else
    	    {
    	        $chtext="$row[members]K|$row[username] $row[title]\n";
			    $ltext=$midtext."\n".$chtext.$ltext;  
    	    }
    	    $counter++;
        }
        $post=$stext."\n".$ftext.$ltext.$midtext."\n".$etext;
        $result=$conn->query("SELECT id FROM Channels");
	    $counter=1;
		while ($row = $result->fetch_assoc()) 
		{
		$ret = message($row[id],urlencode($post));
		$msgid=$ret->result->message_id;
		$conn->query("INSERT INTO post
		VALUES ('$row[id]','$msgid')");
		if($counter%20 == 0)
		sleep(1);
		$counter++;
		}
	break;
	
	case "/del":
	$result=$conn->query("SELECT chid , msgid FROM post");
	while ($row = $result->fetch_assoc()) 
	{
		deletemessage($row[chid],$row[msgid]);
	}
	$conn->query("DELETE FROM post");
	break;
	
	case "/settime":
	//الغاء العملية
	message($chat_id, "ارسل الوقت بالطريقة التالية 20:00" );
	file_put_contents("lib/command.txt","settime");
	break;
	
	case "/gettime":
	//الغاء العملية
	message($chat_id, "وقت النشر هو $time" );
	break;
	
	case "/fixed":
	//الغاء العملية
	file_put_contents("lib/fixed.txt","t");
	message($chat_id, "تم تثبيت القائمة" );
	break;
	
	case "/unfixed":
	//الغاء العملية
	file_put_contents("lib/fixed.txt","");
	message($chat_id, "تم الغاء تثبيت القائمة" );
	break;
	
	case "/cancel":
	//الغاء العملية
	message($chat_id, "تم الغاء العملية" );
	break;
	
	case "/reset";
	file_put_contents("lib/isoff.txt","t");
	break;
	
	default:
	message($chat_id,"الرجاء ادخال أمر صالح");
}
break;
}
//أوامر رد المستخدم============================================================================================================================================
	case "period":
		$inperiod = (int)$text;
		if($inperiod != 0)
		{
		file_put_contents("lib/period.txt", $inperiod);
		message($chat_id,urlencode( " تم ضبط الفترة\n\n$inperiod ساعة"));
		file_put_contents("lib/command.txt","command");
		}
		else
		{
		message($chat_id, "الرجاء ادخال قيمة عددية");
		}
	break;
	
	case "repost":
		$inrepost = (int)$text;
		if($inrepost != 0)
		{
		file_put_contents("lib/repost.txt", $inrepost);
		message($chat_id,urlencode("تم ضبط فترة اعادة النشرة\n\n$inrepost دقيقة"));
		file_put_contents("lib/command.txt","command");
		}
		else
		{
		message($chat_id, "الرجاء ادخال قيمة عددية");
		}
	break;

	case "starttext":
		file_put_contents("lib/stext.txt", $text);
		message($chat_id,urlencode( " تم ضبط نص البداية\n\n $text"));
		file_put_contents("lib/command.txt","command");
	break;
	
	case "settime":
		file_put_contents("lib/time.txt", $text);
		message($chat_id,urlencode( "تم ضبط وقت النشر \n\n $text"));
		file_put_contents("lib/command.txt","command");
	break;
	
	case "endtext":
		file_put_contents("lib/etext.txt", $text);
		message($chat_id,urlencode( " تم ضبط نص النهاية\n\n $text"));
		file_put_contents("lib/command.txt","command");
	break;
	
	case "midtext":
		file_put_contents("lib/midtext.txt", $text);
		message($chat_id,urlencode( " تم ضبط الفاصل بين القنوات\n\n $text"));
		file_put_contents("lib/command.txt","command");
	break;
	
	case "sendid":
		$ex = explode("|", $text);
		$ret= message($ex[0],$ex[1]);
		if($ret->ok)
			message($chat_id, " تم الارسال");
		else
			message($chat_id, "لا يمكن الارسال");
		file_put_contents("lib/command.txt","command");
	break;
	
	case "add":
		$ex = explode("|", $text);
		$isadmin=json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatAdministrators?chat_id=$ex[0]"));
		if($isadmin->ok and strlen($text) <=25 )
		{
			$count=round(json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMembersCount?chat_id=$ex[0]"))->result,-3)/1000;
			$channelid=json_decode(file_get_contents("https://api.telegram.org/bot$token/getChat?chat_id=$ex[0]"))->result->id;
			$conn->query("INSERT INTO Channels
			VALUES ('$channelid' ,'$count','$ex[0]','$ex[1]')");
			if($conn->affected_rows == 1)
				message($chat_id, " تمت الاضافة");
			else
				message($chat_id, "لم تتم الاضافة ، تأكد من أن القناة ليست مضافة مسبقاً");
		}
		elseif(strlen($text) > 25)
		{
			message($chat_id, "عذراً ، اسم و معرف القناة طويل جدا");
		}
		else
		{
			message($chat_id, "البوت ليس اداري في القناة");
		}
		file_put_contents("lib/command.txt","command");
	break;
	case "delete":
		$conn->query("DELETE FROM Channels
		WHERE username='$text'");
		if($conn->affected_rows == 1)
				message($chat_id, " تم الحذف");
			else
				message($chat_id, "لم يتم الحذف ، تأكد من أن القناة مضافة أم لا ");
		file_put_contents("lib/command.txt","command");
	break;
	
	case "announce":
		$counter=1;
		$announceid++;
		file_put_contents("lib/announce.txt",$announceid);
		$result=$conn->query("SELECT id FROM Channels");
		while ($row = $result->fetch_assoc()) 
		{
			$ret = message($row[id],$text);
			$msgid=$ret->result->message_id;
			$conn->query("INSERT INTO Announce
			VALUES ('$announceid','$row[id]','$msgid')");
			if($counter%20 == 0)
				sleep(1);
			$counter++;
        }
		if($conn->affected_rows >= 1)
			message($chat_id, urlencode("تم الارسال\nمعرف التعميم هو $announceid"));
		else
			message($chat_id, "لم يتم الارسال تأكد من أن هناك قنوات مضافة للبوت");
		file_put_contents("lib/command.txt","command");
	break;
	
	case "dannounceid":
	//حذف تعميم بالمعرف
		$result=$conn->query("SELECT chid , msgid FROM Announce WHERE id ='$text'");
		while ($row = $result->fetch_assoc()) 
		{
			deletemessage($row[chid],$row[msgid]);
        }
    $conn->query("DELETE FROM Announce WHERE id ='$text'");
    if($conn->affected_rows >= 1)
		message($chat_id, "تم حذف التعميم");
	else
		message($chat_id, "لا يوجد تعميمات لحذفها");
	break;
	
	case "deleteforward":
	//حذف تعميم بالمعرف
	$chid=$msg->forward_from_chat->id;
	$msgid=$msg->forward_from_message_id;
    $ret=deleteMessage($chid,$msgid);
	if($ret->ok)
		message($chat_id,"تم الحذف");
	else
		message($chat_id,"لا يمكن الحذف");
	break;
}
}
?>