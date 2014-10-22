<?php
namespace Renaissance\CommonBundle\REST;
class FileREST extends BaseREST{

	private function getAllFilesByCourseId($id){
		$this->api = "courses/".$id.'/files';
		return $this->execute();
	}

	private function getAllFilesByUserId($id){
		$this->api = "users/".$id.'/files';
		return $this->execute();
	}

	private function getAllFilesByGroupId($id){
		$this->api = "groups/".$id.'/files';
		return $this->execute();
	}

	private function getAllFilesByFolderId($id){
		$this->api = "folders/".$id.'/files';
		return $this->execute();
	}

	private function getFileById($id){
		$this->api = "files/".$id;
		return $this->execute();
	}

	private function getCourseFolder($id,$path){
		$this->api = "courses/".$id.'/folders/by_path/'.$path;
		$folders = $this->execute();
		if(!empty($folders))
			return $folders[count($folders)-1];
		else
			return 0;
	}

	private function getUserFolder($id,$path){
		$this->api = "users/".$id.'/folders/by_path/'.$path;
		$folders = $this->execute();
		if(!empty($folders))
			return $folders[count($folders)-1];
		else
			return 0;
	}

	private function getGroupFolder($id,$path){
		$this->api = "groups/".$id.'/folders/by_path/'.$path;
		$folders = $this->execute();
		if(!empty($folders))
			return $folders[count($folders)-1];
		else
			return 0;
	}

	public function getFileByPath($type,$type_id,$path){
		$type = strtolower($type);
		// 获得文件路径及文件名
		$path_arr = explode("/",$path);
		$file_name = end($path_arr);
		array_pop($path_arr);
		$file_path = implode("/", $path_arr);
		switch ($type) {
			// 获取文件夹
			case 'user':
				$folder = $this->getUserFolder($type_id,$file_path);
				break;
			case 'course':
				$folder = $this->getCourseFolder($type_id,$file_path);
				break;
			case 'group':
				$folder = $this->getGroupFolder($type_id,$file_path);
				break;
			default:
				return null;
		}
		if(!empty($folder)){
			$this->api = 'folders/'.$folder->id.'/files?search_term='.$file_name;
			$file = $this->execute();
			 return $file;
		}
		else
			return null;
	}




}