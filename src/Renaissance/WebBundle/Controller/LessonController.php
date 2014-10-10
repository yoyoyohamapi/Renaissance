<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LessonController extends Controller
{
    public function showAction($course_id,$lesson_id)
    {
	$curlHelper = $this->get('curlHelper');
    	$api_prefix=array(
    		"getRootFolder"=>"courses/", //course_id 3
    		"listFolder"=>"folders/", //folder_id 4,6
    	);
    	$api_postfix=array(
    		"getRootFolder"=>"/folders/root",
    		"getAllFolder"=>"/folders",
    		"getAllFiles"=>"/files",
    	);

    	$root_folder = $curlHelper->curlGet($api_prefix['getRootFolder'].$course_id.$api_postfix['getRootFolder']);
    	//print_r($root_folder);
                // exception : course not found
    	if (is_null($root_folder)) {
                                return $this->render('RenaissanceWebBundle:Error:404.html.twig', array(
                                        "error_msg"=>"no such course"
                                ));
                }
                $all_folders = $curlHelper->curlGet($api_prefix['listFolder'].$root_folder->id.$api_postfix['getAllFolder']);
    	//print_r($all_folder);
    	$video_folder_id=0;
    	foreach ($all_folders as $folder) {
    		//print_r($folder);
    		if ($folder->name=="video"){
    			//print_r($folder);
    			$video_folder_id=$folder->id;
    		}
    	}
    	// exception : video folder not found -> $video_folder_id=0
                if ($video_folder_id==0) {
                                return $this->render('RenaissanceWebBundle:Error:404.html.twig', array(
                                        "error_msg"=>"no video folder"
                                ));
                }
    	$all_videos = $curlHelper->curlGet($api_prefix['listFolder'].$video_folder_id.$api_postfix['getAllFiles']);
    	//print_r($all_videos);
    	// caution : filename & display name
    	$video_src="default.mp4";
    	foreach ($all_videos as $video) {
    		//print_r($folder);
    		if ($video->display_name==$lesson_id.".mp4"){
    			$video_src=$video->url;
    		}
    	}
                // exception : assume no default.mp4
                if ($video_src=="default.mp4") {
                                return $this->render('RenaissanceWebBundle:Error:404.html.twig', array(
                                        "error_msg"=>"no such video in this lesson"
                                ));
                }
	return $this->render('RenaissanceWebBundle:Lesson:show.html.twig', array(
        		"video_src"=>$video_src
 	   ));   
    }

}
