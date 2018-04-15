<?php
require(__DIR__   .  DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR  .'autoload.php');
include("mysqli.php");

while(true){

$list = scandir(__DIR__ . "/video/baomihua/");
unset($list[0]);
unset($list[1]);
//var_dump($list);

foreach($list as $id){
	echo $id . "\n";
	$titleFile = __DIR__ . "/video/baomihua/$id/$id";
	$title = file_get_contents($titleFile);
	echo $title . "\n";
	$fileList = scandir(__DIR__ . "/video/baomihua/$id/");
	//var_dump($fileList);
	$imageArr = array();
	$videoFile = "";
	foreach($fileList as $file){
		if(strpos($file,"jpg")){
			$imageArr[] = __DIR__ . "/video/baomihua/$id/$file";
		}
		if(strpos($file,"watermark")){
			$videoFile =  __DIR__ . "/video/baomihua/$id/$file";
			echo $videoFile . "\n";
		}
	}
	var_dump($imageArr);

	$sql = "select * from videos where title = '$title'";
	$db = new DB();
	echo "DB connect " . $ret = $db->connect($argv[1],$argv[3],$argv[4],$argv[5],$argv[2]);
	if($ret == false){
		continue;
	}
	echo "\n";
	$db->charset("utf8");
	$ret = $db->query($sql);
	if(empty($ret)){
		echo "check title imageArr videoFile \n";
		if($title == "" || count($imageArr) !== 3 || $videoFile == ""){
			echo "check failed \n";
			continue;
		}
		//upload file to tcloud	
		$region = $argv[6];
		$appId = $argv[7];
		$secretId = $argv[8];
		$secretKey = $argv[9];
		$bucket = $argv[10];
		$cosClient = new Qcloud\Cos\Client(array('region' => $region,
    			'credentials'=> array(
        			'appId' => $appId,
        			'secretId'    => $secretId,
        			'secretKey' => $secretKey)));
		try {
			$result = $cosClient->upload(
				$bucket,
				$key = basename($videoFile),
				$body=fopen($videoFile,'r+'));
			print_r($videoUrl = $result['Location']);
			if(strpos($videoUrl,"http") === false){
				$videoUrl = "http://" . $videoUrl;
			}
    		} catch (\Exception $e) {
			echo "$e\n";
			continue;
		}
		try {
                        $result = $cosClient->upload(
                                $bucket,
                                $key = basename($imageArr[0]),
                                $body=fopen($imageArr[0],'r+'));
                        print_r($imageUrl = $result['Location']);
                } catch (\Exception $e) {
                        echo "$e\n";
			continue;
                }
		$t = time();
		$sql = "insert into videos (title,image_url,video_url,create_ts,video_cat) values ('$title','$imageUrl','$videoUrl',$t,'baomihua_funny')";
		$ret = $db->query($sql);
		echo "inset mysql ret :" . $ret . "\n";      
	}else{
		echo "have exits \n";
		continue;
	}	
	sleep(10);	
}
echo "start sleep can kill\n";
echo "time:" . time() . "\n";
echo "pid:" . getmypid() . "\n"; 
sleep(60*30);
echo "end sleep don't kill\n";
}//while
