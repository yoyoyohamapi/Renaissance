<?php

namespace Renaissance\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class LessonController extends Controller
{
    public function showAction($course_id,$chapter_id,$lesson_id)
    {
            try{
                //echo $course_id.$chapter_id.$lesson_id;
	$curlHelper = $this->get('curlHelper');

                // api : http://localhost:3000/api/v1/courses/4
                $course=  $curlHelper->curlGet("courses/".$course_id);
                if(is_null($course) ){
                                throw new \Exception("no such course");
                }
                $course_name=$course->name;
                //
                // api : http://localhost:3000/api/v1/courses/4/modules
                $all_modules=  $curlHelper->curlGet("courses/".$course_id."/modules");
                if(is_null($all_modules) || empty($all_modules)){
                                throw new \Exception("no module available");
                }
                $module_name=null;
                foreach ($all_modules as $module) {
                                if ($module->id==$chapter_id){
                                        $module_name=$module->name;
                                }
                }
                if(is_null($module_name)){
                                throw new \Exception("no such module(chapter)");
                }
                //
                // api : http://localhost:3000/api/v1/courses/4/modules/3/items
                $all_items=$curlHelper->curlGet("courses/".$course_id."/modules/".$chapter_id."/items");
                if(is_null($all_items) || empty($all_items)){
                                throw new \Exception("no lesson available");
                }
                $SubHeader_name=null;
                foreach ($all_items as $item ) {
                                if( $item->id==$lesson_id && $item->type=="SubHeader" ){
                                            $SubHeader_name=$item->title;
                                }
                }
                if(is_null($SubHeader_name)){
                                throw new \Exception("no such subHeader(lesson)");
                }
                //
                // api : http://localhost:3000/api/v1/courses/4/folders/by_path/resource/第一章/环境搭建  // return every parent folder
    	$resource_folder = $curlHelper->curlGet("courses/".$course_id."/folders/by_path/resource/".$module_name."/".$SubHeader_name);
    	if (is_null($resource_folder)) {
                                throw new \Exception("no such resource_folder");
                }
               // echo end($resource_folder)->files_url; //
                //
                // api :  http://localhost:3000/api/v1/folders/18/files?content_types[]=video/mp4 // convention  type=video/mp4 and quantity=1
                $video = $curlHelper->curlGet("folders/".end($resource_folder)->id."/files?content_types[]=video/mp4"); // actually return a array of videos
                if(is_null($video) || empty($video)){
                                throw new \Exception("no video available");
                }
                return $this->render('RenaissanceWebBundle:Lesson:show.html.twig', array(
                            "video_src"=>$video[0]->url,
                            "course_id"=>$course_id,
                            "course_name"=>$course_name,
                            "chapter_id"=>$chapter_id,
                            "chapter_name"=>$module_name,
                            "lesson_id"=>$lesson_id,
                            "lesson_name"=>$SubHeader_name
                   ));
            }catch (\Exception $e){
                //echo "error:".$e->getMessage();
                return $this->render('RenaissanceWebBundle:Error:404.html.twig', array(
                        "error_msg"=>$e->getMessage()
                ));
            }
    }

}
