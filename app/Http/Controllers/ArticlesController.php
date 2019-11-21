<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;//  引用model

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$articles = Article::orderBy('created_at','desc')->get();

        return view('articles.index', compact('articles'));
       // return view('articles.index');
    }

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:50',
        ]);
		
		//完成文章数据添加
        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);
		
		//重新定向到文章列表页
        return redirect()->route('articles.index');
    }


	 /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		//var_dump($request->title); exit;
        $this->validate($request, [
            'title' => 'required|max:50',
        ]);

        $article = Article::findOrFail($id);
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
		
		return back();
        //return back()->with('success','操作成功');
    }

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return back();
    }

     /**
     * show the detail page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //test reset111
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }
   
    
   /**
    * http://lartest.com/articles/test/1/2
    * [test description]
    * @param  [type] $aa [description]
    * @param  [type] $bb [description]
    * @return [type]     [description]
    */

    public function test()
    {
        // update on git branch dev
        // on branch dev1 vevy good
        //fix bug 101
        return 'testaaaa';

        return view('articles.create');
    }
}