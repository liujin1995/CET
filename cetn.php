<?php
header("Content-type: application/json");
$name = $_POST['username'];
$province = $_POST['province'];
$school = $_POST['school'];
$type = $_POST['type'];

if (empty($name) || empty($province) || empty($school) || empty($type)) {
	die("信息不全");
	
}

if($_SERVER["HTTP_REFERER"]!="http://www.unique-liu.com/cet/"){
die();
}
echo "1";
$name = str_replace(" ", "", $name);
$ret = $type == 1 ?
shell_exec("python cetalldata/cet4.py '$province' '$school' '$name'") :
shell_exec("python cetalldata/cet6.py '$province' '$school' '$name'");
/*
$login_url="http://find.cet.99sushe.com/search";
echo $data=$ret;
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL,$login_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt ($ch, CURLOPT_HTTPHEADER , array('Content-Length: '.strlen($data)));
		curl_setopt($ch, CURLOPT_TIMEOUT,1000); 
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		$str=curl_exec($ch);
		curl_close($ch);
$ret=shell_exec("python cadtag/cet.py '$str' '$name'");
*/
print_r($ret);die();
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
			
            $dataa = [               
                    "name" => $ret['name'],
	            "lei"=>$lei,
                    "ticket" => $ret['ticket'],
                    "school" => $ret['school'],
                    "total" => $ret['total'],
                    "writing" => $ret['writing'],
                    "listening" => $ret['listening'],
                    "reading" => $ret['reading'],
                    "comefrom"=>"mine"      
           ];
}else{
$prodata='{
  "11":{"name":"北京", "id":"11"},
  "12":{"name":"天津", "id":"12"},
  "13":{"name":"河北", "id":"13"},
  "14":{"name":"山西", "id":"14"},
  "15":{"name":"内蒙古", "id":"15"},
  "21":{"name":"辽宁", "id":"21"},
  "22":{"name":"吉林", "id":"22"},
  "23":{"name":"黑龙江", "id":"23"},
  "31":{"name":"上海", "id":"31"},
  "32":{"name":"江苏", "id":"32"},
  "33":{"name":"浙江", "id":"33"},
  "34":{"name":"安徽", "id":"34"},
  "35":{"name":"福建", "id":"35"},
  "36":{"name":"江西", "id":"36"},
  "37":{"name":"山东", "id":"37"},
  "41":{"name":"河南", "id":"41"},
  "42":{"name":"湖北", "id":"42"},
  "43":{"name":"湖南", "id":"43"},
  "44":{"name":"广东", "id":"44"},
  "45":{"name":"广西", "id":"45"},
  "46":{"name":"海南", "id":"46"},
  "50":{"name":"重庆", "id":"50"},
  "51":{"name":"四川", "id":"51"},
  "52":{"name":"贵州", "id":"52"},
  "53":{"name":"云南", "id":"53"},
  "54":{"name":"西藏", "id":"54"},
  "61":{"name":"陕西", "id":"61"},
  "62":{"name":"甘肃", "id":"62"},
  "63":{"name":"青海", "id":"63"},
  "64":{"name":"宁夏", "id":"64"},
  "65":{"name":"新疆", "id":"65"}
}';
    $projson = json_decode($prodata,TRUE);	
	$projson =$projson[$province];
	$projson = json_decode(json_encode($projson),TRUE);
	$province=$projson['name'];
	$url = 'http://cet.yunban.com/webservice.php';
	$post = json_encode(array('name'=>$name, 'province'=>$province,'school'=>$school,'type'=>$type,'_url'=>'getTicketAndScore'));
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36');
	curl_setopt($ch,CURLOPT_HTTPHEADER,array('Host: cet.yunban.com',
	'Accept: application/json, text/javascript, */*; q=0.01',
	'Origin: http://cet.yunban.com',
	'Content-Type: application/json',
	'Referer: http://cet.yunban.com/',
	'Content-Type: application/json',
	'X-Requested-With: XMLHttpRequest',
	'Accept-Encoding: gzip, deflate',
	'Content-Length:'.strlen($post)));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data=curl_exec($ch);
	curl_close($ch);
    $de_json = json_decode($data,TRUE);
    if($de_json['status']==200){
		$result=$de_json['result'];		
		$de_json = json_decode(json_encode($result),TRUE);
		$result=$de_json['userInfo'];
		$score=$de_json['scoreDetail'];
		$result = json_decode(json_encode($result),TRUE);
		$score = json_decode(json_encode($score),TRUE);
		$id=$result['num'];
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
        $dataa = array(                
                    "name" => $result['name'],
	                "lei"=>$lei,
                    "ticket" => $result['num'],
                    "school" => $result['school'],
                    "total" => $score['totleScore'],
                    "writing" => $score['xzpyScore'],
                    "listening" => $score['tlScore'],
                    "reading" => $score['ydScore'],
                    "comefrom"=>"zhifubao"             
            );
	}
}
if(!empty($dataa['name'])){
print_r(json_encode($dataa));
}
/*

else{
$data=findt($school,$type,$name);
$h = explode(',',$data);
		$id=$h[8];
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
 $dataa = array(                
                    "name" =>iconv('utf-8','gb2312',$h[6]) ,
	                "lei"=>$lei,
                    "ticket" => $h[8],
                    "school" =>iconv('utf-8','gb2312',$h[5]),
                    "total" => $h[4],
                    "writing" => $h[3],
                    "listening" => $h[1],
                    "reading" => $h[2],
                    "comefrom"=>"find"             
            );
print_r(json_encode($dataa));
}


function findt($school,$type,$name){
$data =json_decode(file_get_contents("schoolcode.json"),true);
foreach($data as $v){
	if($v[0]==$school){
		$code=$v[1];
	}
}

$id=$code."16".(date("m") <6 ? "2" : "1").$type;

for($i=1410;$i<99999;$i++){
	if(strlen($i)==1){
		$a="0000".$i;
	}else if(strlen($i)==2){
		$a="000".$i;
	}else if(strlen($i)==3){
		$a="00".$i;
	}else if(strlen($i)==4){
		$a="0".$i;
	}else{
		$a=$i;
	}
$b=cx($id.$a,$name);
if(substr($b,0,1)!=1&&substr($b,0,1)!=2&&substr($b,0,1)!=3&&substr($b,0,1)!=4&&substr($b,0,1)!=5){
return $b.",".$id.$a;
}
}

}

function curl_request($url,$post=''){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
		curl_setopt($curl, CURLOPT_REFERER, "http://cet.99sushe.com");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Forwarded-For: 127.0.0.1'));
		if($post) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
		}
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		curl_close($curl);
		return $data; 
	}
function cx($id,$name){
		$url = 'http://cet.99sushe.com/getscore'.$id;
		$post['id'] = $id;
		$post['name'] =substr(iconv('utf-8','gb2312',$name),0,4);
		$result = curl_request($url,$post);
		return $result;
	}
*/
?>
