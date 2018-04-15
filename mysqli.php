<?php
class DB {
	private $mysql = NULL;
	private $isConnected = false;	
	
	private $retryTimes = 0;
	
	// query result types
	const FETCH_RAW = 0;    // return raw mysqli_result
	const FETCH_ROW = 1;    // return numeric array
	const FETCH_ASSOC = 2;  // return associate array
	const FETCH_OBJ = 3;    // return Bd_DBResult object	

	public function __construct(){
		$this->mysql = mysqli_init();
	}

	public function __destruct(){
		$this->close();
	}
	
	private function reinit(){
		$this->mysql->init();
	}
	
	private function close(){
		$this->mysql->close();
	}

	public function connect($host, $uname = null,$passwd = null,$dbname = null,$port = null,$flags = 0, $retry = 0){
		$port = intval($port);
		if(!$port){
			$port = 3306;
		}
		$this->retryTimes = $retry;
		
		for($i=0; $i <= $this->retryTimes; $i++){
			$this->isConnected = $this->mysql->real_connect(
				$host,$uname,$passwd,$dbname,$port,NULL,$flags
			);
			if($this->isConnected){
				return true;
			}
			$this->reinit();
		}	
	}

	public function charset($name = NULL){
		if($name === NULL){
			return $this->mysql->character_set_name();
		}
		$ret = $this->mysql->set_charset($name);
		return $ret;
	}

	/**
	* @brief 查询接口
	*
	* @param $sql 查询sql
	* @param $fetchType 结果集抽取类型 
	* @param $bolUseResult 是否使用MYSQLI_USE_RESULT
	*
	* @return 结果数组：成功；false：失败
	*/
	public function query($sql, $fetchType = DB::FETCH_ASSOC, $bolUseResult = false){
		$res = $this->mysql->query($sql, $bolUseResult?MYSQLI_USE_RESULT:MYSQLI_STORE_RESULT);
		$ret = false;
		if(is_bool($res) || $res === NULL){
			$ret = ($res == true);
		}else{
			$ret = array();
			while($row = $res->fetch_row())
                	{
                        	$ret[] = $row;
			}
			$res->free();
		}
		return $ret;
	}
}

/*$db = new DB();
echo $ret = $db->connect("localhost","root","root","news_video");

$db->charset("utf8");

$sql = "select * from videos";
$ret = $db->query($sql);
var_dump($ret);

$sql = "insert into videos (title,image_url,video_url,create_ts,video_cat) values ('XXXXX','YYYY','10010101',1010010,'CCCC')";
$ret = $db->query($sql);
var_dump($ret);

$sql = "delete from videos where title = 'XXXXX'";
$ret = $db->query($sql);
var_dump($ret);*/

