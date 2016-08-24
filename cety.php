<?php

header("Content-type: application/json");
$name = $_POST['username'];
$ticket = $_POST['ticket'];



if (empty($name) || empty($ticket)) {
	echo "信息不全";
	return;
}

if($_SERVER["HTTP_REFERER"]!="http://www.unique-liu.com/cet/"){
die();
}


$name = str_replace(" ", "", $name);
$ret = shell_exec("python cetalldata/cet4.py '$ticket' '$name'");
  $ret = json_decode($ret, true);

        if ($ret['name'] !== null) {
			$id=$ret['ticket'];
	$ye="20".substr($id,6,2)."年";
		$mo=(substr($id,8, 1) == 1 ? "6" : "12")."月";
		$leiid=substr($id,9,1);
	        switch ($leiid) {
            case "1": $lei=$ye.$mo." 英语四级";break;
            case "2": $lei=$ye.$mo." 英语六级";break;
            case "3": $lei=$ye.$mo." 日语四级";break;
            case "4": $lei=$ye.$mo." 日语六级";break;
            case "5": $lei=$ye.$mo." 德语四级";break;
            case "6": $lei=$ye.$mo." 德语六级";break;
            case "7": $lei=$ye.$mo." 俄语四级";break;
            case "8": $lei=$ye.$mo." 俄语六级";break;
            case "9": $lei=$ye.$mo." 法语四级";break;
            default: $lei="";
        }
			
            $data = [         
"total" => $ret['total'],
                    "writing" => $ret['writing'],
                    "listening" => $ret['listening'],
                    "reading" => $ret['reading'],      
                    "name" => $ret['name'],
	            "lei"=>$lei,
                    "ticket" => $ret['ticket'],
                    "school" => $ret['school'],
                    "comefrom"=>"mine"          
           ];
print_r(json_encode($data));
}else{
$ip2id= round(rand(600000, 2550000) / 10000); //第一种方法，直接生成 
$ip3id= round(rand(600000, 2550000) / 10000); 
$ip4id= round(rand(600000, 2550000) / 10000); 
//下面是第二种方法，在以下数据中随机抽取 
$arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211"); 
$randarr= mt_rand(0,count($arr_1)-1); 
$ip1id = $arr_1[$randarr]; 
$ip=$ip1id.".".$ip2id.".".$ip3id.".".$ip4id; 
$id=$ticket;
$ye="20".substr($id,6,2)."年";
		$mo=(substr($id,8, 1) == 1 ? "6" : "12")."月";
		$leiid=substr($id,9,1);
	        switch ($leiid) {
            case "1": $lei=$ye.$mo." 英语四级";break;
            case "2": $lei=$ye.$mo." 英语六级";break;
            case "3": $lei=$ye.$mo." 日语四级";break;
            case "4": $lei=$ye.$mo." 日语六级";break;
            case "5": $lei=$ye.$mo." 德语四级";break;
            case "6": $lei=$ye.$mo." 德语六级";break;
            case "7": $lei=$ye.$mo." 俄语四级";break;
            case "8": $lei=$ye.$mo." 俄语六级";break;
            case "9": $lei=$ye.$mo." 法语四级";break;
            default: $lei="";
        }

$url="http://www.chsi.com.cn/cet/query?zkzh={$ticket}&xm={$name}";
$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36');
	curl_setopt($ch,CURLOPT_HTTPHEADER,array('Referer: http://www.chsi.com.cn/cet/',
	'Accept-Encoding: deflate',
	'X-Forwarded-For: '.$ip));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data=curl_exec($ch);
	curl_close($ch);
$data=substr($data,strpos($data,'<table border="0" align="center" cellpadding="0" cellspacing="6" class="cetTable">'));
$data=get_td_array($data);
$data = [         
					"total" => $data[5][1],
                    "writing" => $data[5][8],
                    "listening" => $data[5][4],
                    "reading" => $data[5][6],      
                    "name" => $data[0][1],
					"lei"=>$lei,
                    "ticket" => $ticket,
                    "school" => $data[1][1],
			"comefrom"=>"xuexin"           
           ];
print_r(json_encode($data));
}
function get_td_array($table) {    
        $table = preg_replace("/<table[^>]*?>/is","",$table);
		$table = preg_replace("/<tr[^>]*?>/si","",$table);
		$table = preg_replace("/<th[^>]*?>/si","",$table);
		$table = preg_replace("/<td[^>]*?>/si","",$table);
		$table = str_replace("</tr>","{tr}",$table);
		$table = str_replace("</th>","{td}",$table);
		$table = str_replace("<br />","{td}",$table);
		$table = str_replace("</span>","{td}",$table);
		$table = str_replace("</td>","{td}",$table);
		$table = str_replace("<br><br>","\n\n",$table);
		$table = str_replace("<br>","\n",$table);
		//去掉 HTML 标记
		$table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table);
		//去掉空白字符
		$table = preg_replace("'([rn])[s]+'","",$table);
		$table = str_replace(" ","",$table);
		$table = str_replace(" ","",$table);
		$table = str_replace("&nbsp;","",$table);
		$table = explode('{tr}', $table);
		array_pop($table);
		foreach ($table as $key=>$tr) {
			$tr=trim($tr);
			$td = explode('{td}', $tr);
			$td = explode('{td}', $tr);

			array_pop($td);
			$td_array[] = $td;
		}
		return $td_array;} 
?>
