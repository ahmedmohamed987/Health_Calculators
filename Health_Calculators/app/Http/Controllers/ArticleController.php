<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Session;



class ArticleController extends Controller
{
    public function AddArticle(Request $request) {

        $request->validate([
            'title'=>['required'],
            'content'=>['required'],
            'image'=>['required']
        ]);

        $all_articles = Article::all();

        if(!$all_articles->isEmpty()) {

            $is_article_exist = false;

            foreach($all_articles as $article) {
                $article_img_name = time(). '.' . $request->image->extension();
                $article_img_path = "/article_images/" . $article_img_name;

                if($article->title == strtolower($request->title)) {

                    if($article->image == $article_img_path) {

                        $article->admin_id = session('logged_in_admin')['id'];
                        $article->content = strtolower($request->content);
                        $article->save();
                        $is_article_exist = true;

                        return redirect()->route('all.articles');
                    }
                    else {

                        $article->admin_id = session('logged_in_admin')['id'];
                        $article->content = strtolower($request->content);
                        $request->image->move(public_path('article_images'), $article_img_name);
                        $article->image = $article_img_path;
                        $article->save();
                        $is_article_exist = true;

                        return redirect()->route('all.articles');
                    }

                }

            }
            if($is_article_exist == false) {

                $new_article = new Article;
                $new_article->admin_id = session('logged_in_admin')['id'];
                $new_article->title = strtolower($request->title);
                $new_article->content = strtolower($request->content);
                $article_img_name = time(). '.' . $request->image->extension();
                $article_img_path = "/article_images/" . $article_img_name;
                $request->image->move(public_path('article_images'), $article_img_name);
                $new_article->image = $article_img_path;
                $new_article->save();

                return redirect()->route('all.articles');
            }

        }
        else {

            $new_article = new Article;
            $new_article->admin_id = session('logged_in_admin')['id'];
            $new_article->title = strtolower($request->title);
            $new_article->content = strtolower($request->content);
            $article_img_name = time(). '.' . $request->image->extension();
            $article_img_path = "/article_images/" . $article_img_name;
            $request->image->move(public_path('article_images'), $article_img_name);
            $new_article->image = $article_img_path;
            $new_article->save();

            return redirect()->route('all.articles');
        }

    }


    public function UpdateArticle($id , Request $request) {

        $request->validate([
            'article_title' => 'required',
            'article_content' => 'required',
        ]);

        $article = Article::find($id);
        $article->admin_id = session('logged_in_admin')['id'];
        $article->title = $request->article_title;
        $article->content = $request->article_content;

        if ($request->hasFile('article_image')) {

            $article_img_name = time() . '.' . $request->article_image->extension();
            $article_img_path = "/article_images/" . $article_img_name;
            $request->article_image->move(public_path('article_images'), $article_img_name);
            $article->image = $article_img_path;
        }

        $article->save();
        return back();

    }


    public function DeleteArticle($id) {

        if(session()->has('logged_in_admin')) {

            $article = Article::find($id);
            $article->delete();

            return redirect()->route('all.articles');
        }
        else{
            return redirect()->back();
        }

    }


    public function ShowAllArticles(Request $request) {

        if($request->search_article == null) {

            $articles = Article::orderBy('id', 'DESC')->paginate(10);
            return view('Public-Views.article')->with('all_articles', $articles);
        }
        else {

            $result = Article::where('title', 'Like', '%' . $request->search_article . '%')
                        ->orwhere('content', 'Like', '%' . $request->search_article . '%')->get();

            if(!$result->isEmpty()) {
                Session::flash('article_result', $result);
                Session::flash('article', $request->search_article);
            }
            else {
                Session::flash('empty_result', "No matched articles here...");
                Session::flash('article', $request->search_article);
            }

            return back();
        }

    }


    public function ReadArticle($id) {

        $article = Article::find($id);
        return view('Public-Views.viewarticle', compact('article'));

    }



}
