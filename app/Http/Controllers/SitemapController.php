<?php

namespace App\Http\Controllers;
use App\Helper\Cmf;
use Illuminate\Http\Request;
use App\Models\pets;
use DB;
use Auth;
use App\Models\answerquestions;
use App\Models\onlyanswers;
use App\Models\dynamicpages;
use App\Models\sitemap_blogs;
use App\Models\blogs;
class SitemapController extends Controller
{
    public function questionsitemap()
    {
       $posts = answerquestions::where('visible_status' , 'Published')->where('delete_status' , 'Active')->get();
       return response()->view('sitemap.question', compact('posts'))->header('Content-Type', 'text/xml');
    }
    public function blogpostssitemap()
    {
       $posts = blogs::where('visible_status' , 'Published')->where('delete_status' , 'Active')->get();
       return response()->view('sitemap.index', compact('posts'))->header('Content-Type', 'text/xml');
    }
    public function dynamicpagesitemap()
    {
       $posts = dynamicpages::where('visible_status' , 'Published')->where('delete_status' , 'Active')->get();
       return response()->view('sitemap.dynamicpagesitemap', compact('posts'))->header('Content-Type', 'text/xml');
    }

   public function genratesitemap(Request $request)
    {
      
      ini_set('memory_limit', '-1');
      set_time_limit(20000000000);

      if($request->sitemap == 'singleblog')
      {
         $blogscount = blogs::where('visible_status' , 'Published')->where('delete_status' , 'Active')->where('sitemap_done' , 0)->count();
         if($blogscount > 200)
         {
            $count = $blogscount/200;
            $count = number_format($count, 1);
            for ($i=0; $i < $count+1; $i++) { 
                $this->genratesitemap_function_blogs();
            }
            return redirect()->back()->with('message', 'Sitemap Genrated Successfully');
         }else{
            return redirect()->back()->with('sitemapalert', 'Remaining Url Count is Less then 200 The Limit of Blogs Sitemap Url is 200');
         }
      }


      if($request->sitemap == 'answerquestions')
      {
         ini_set('max_execution_time', 0); // 0 = Unlimited
         ini_set('memory_limit', '-1');
         set_time_limit(20000000000);
         $count = answerquestions::where('visible_status' , 'Published')->where('delete_status' , 'Active')->where('sitemap_done' , 0)->count();
         if($count > 1000)
         {
            $count = $count/1000;
            $count = number_format($count, 1);
            for ($i=0; $i < $count; $i++) { 
                $this->genratesitemap_function_answerquestions();
            }
            return redirect()->back()->with('message', 'Sitemap Genrated Successfully');
         }else{
            return redirect()->back()->with('sitemapalert', 'Remaining Url Count is Less then 1000 The Limit of Answer Questions Sitemap Url is 1000');
         }
      }




      if($request->sitemap == 'posts-tags')
      {
         $count = DB::table('wphj_term_taxonomy')->where('count',0)->where('taxonomy' , 'post_tag')->count();

         if($count > 200)
         {
            $count = $count/200;
            $count = number_format($count, 1);
            for ($i=0; $i < $count+1; $i++) { 
                $this->genratesitemap_function_blogtags();
            }
            return redirect()->back()->with('message', 'Sitemap Genrated Successfully');
         }else{
            return redirect()->back()->with('sitemapalert', 'Remaining Url Count is Less then 200 The Limit of Blogs Tags Sitemap Url is 200');
         }

      }



    }
    public function genratesitemap_function_blogtags()
    {

         $data = DB::table('wphj_term_taxonomy')->where('count',0)->where('taxonomy' , 'post_tag')->limit(200)->get();

         $sitemapptable = $this->function_genratesitemap('post_tag','post_tag');
         foreach ($data as $r) {
            $new = new sitemap_blogs;
            $new->sitemaptable = $sitemapptable;
            $new->siteurls = $r->term_id;
            $new->save();
            $arrayName = array('count' => 1);
            DB::table('wphj_term_taxonomy')->where('term_id' , $r->term_id)->update($arrayName);
         }

    }

    public function genratesitemap_function_answerquestions()
    {

      ini_set('max_execution_time', 0); // 0 = Unlimited
      ini_set('memory_limit', '-1');
      set_time_limit(20000000000);
      $blogscount = answerquestions::where('sitemap_done' , 0)->count();

      if($blogscount > 1000)
      {
      $data = DB::table('answerquestions')->where('sitemap_done' , 0)->limit(1000)->get();
      $sitemapptable = $this->function_genratesitemap('answerquestion','questions');
      foreach ($data as $r) {
         $new = new sitemap_blogs;
         $new->sitemaptable = $sitemapptable;
         $new->siteurls = $r->id;
         $new->save();
         $arrayName = array('sitemap_done' => 1);
         answerquestions::where('id' , $r->id)->update($arrayName);
      }
      }else{
         $data = DB::table('answerquestions')->where('sitemap_done' , 0)->get();
         $sitemapptable = $this->function_genratesitemap('answerquestion','questions');
         foreach ($data as $r) {
            $new = new sitemap_blogs;
            $new->sitemaptable = $sitemapptable;
            $new->siteurls = $r->id;
            $new->save();
            $arrayName = array('sitemap_done' => 1);
            answerquestions::where('id' , $r->id)->update($arrayName);
         }
      }
    }


    public function genratesitemap_function_blogs()
    {

      $blogscount = blogs::where('visible_status' , 'Published')->where('delete_status' , 'Active')->where('sitemap_done' , 0)->count();

      if($blogscount > 200)
      {
      $data = DB::table('blogs')->where('sitemap_done' , 0)->where('visible_status' , 'Published')->where('delete_status' , 'Active')->limit(200)->get();
      $sitemapptable = $this->function_genratesitemap('singleblog','post');
      foreach ($data as $r) {
        if(sitemap_blogs::where('siteurls' , $r->id)->count() == 0)
        {
         $new = new sitemap_blogs;
         $new->sitemaptable = $sitemapptable;
         $new->siteurls = $r->id;
         $new->save();

         $arrayName = array('sitemap_done' => 1);
         blogs::where('id' , $r->id)->update($arrayName);
        }  
      }
      }else{
         return redirect()->back()->with('message', 'Remaining Url Count is Less then 200 The Limit of Blogs Sitemap Url is 200');
      }
    }


    public function function_genratesitemap($modulename ,$urlname)
    {
         ini_set('max_execution_time', 0); // 0 = Unlimited
         ini_set('memory_limit', '-1');
         set_time_limit(20000000000);
           $count = DB::table('sitemaptable')->where('modulename' , $modulename)->count();
           $count = $count+1;
           $url = 'sitemap_'.$urlname.'_'.$count.'.xml';
           $date = date('Y-m-d');
           $data = array('url'=>$url,'modulename'=>$modulename);
           DB::table('sitemaptable')->insert($data);
           Cmf::savesiteurl($url , 'singlesitemap');
           return DB::table('sitemaptable')->orderby('id' , 'DESC')->get()->first()->id;
   }
}
