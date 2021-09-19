<?php

namespace App\Http\Controllers;

use App\Post; // 追記(Postモデルを使う)
use Illuminate\Support\Facades\Auth; // 追記(ログイン機能を使う)

use Illuminate\Http\Request;

use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function index()
    {
        //モデルから投稿を全ぶ取得して表示する
        $posts = Post::all();

        //取得したデータをビューに変数として渡す
        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        // create.blade.phpを表示する
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        //Postモデルのインスタンスを生成
        $post = new Post;

        //ユーザーが入力したリクエストの情報を格納する
        $post->title = $request->title;
        $post->body = $request->body;
        $post->title = $request->title;
        // Auth::id()でログインユーザーのIDが取得できる
        $post->user_id = Auth::id();

        // インスタンスをDBのレコードとして保存
        $post->save();

        // 投稿一覧画面にリダイレクトさせる
        return redirect()->route('post.index');
    }
}
