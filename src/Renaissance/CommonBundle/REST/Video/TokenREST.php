<?php
namespace Renaissance\CommonBundle\REST\Video;

class TokenREST extends VideoBaseREST{
	public function saveToken($token){
		$this->api = "save/videotoken";
		$this->data_field = array(
			"video_token"=>$token,
		);
		$this->execute('POST');
	}

	//获取token
	function getToken($course_id,$user_id,$salt){
		$str = $user_id.$course_id.$salt;
		$token = sha1($str);
		return $token;
	}
}