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
    public function show($id)
    {
        // 投稿データのIDでモデルから投稿を1件取得
        $post = Post::findOrFail($id);

        // show.blade.phpを表示する(これから作成)
        return view('posts.show', ['post' => $post]);
    }
    public function edit($id)
    {
        // 投稿データのIDでモデルから同じidのものを取得
        $post = Post::findOrFail($id);

        // 同じ投稿者以外の編集を防ぐ 一致しなければ
        if ($post->user_id !== Auth::id()) {
            return redirect('/');
        }

        return view('posts.edit', ['post' => $post]);
    }

    public function update(PostRequest $request, $id)
    {
        // 投稿データのIDでモデルから同じidのものを取得
        $post = Post::findOrFail($id);

        // 同じ投稿者以外の編集を防ぐ 一致しなければ
        if ($post->user_id !== Auth::id()) {
            return redirect('/');
        }

        // 編集画面から受け取ったデータをインスタンスに反映
        $post->title = $request->title;
        $post->body = $request->body;

        // DBのレコードを更新
        $post->save();

        return redirect('/');
    }

    public function delete($id)
    {
        // 投稿データのIDでモデルから該当の投稿を1件取得
        $post = Post::findOrFail($id);

        // 投稿した者以外から削除を防ぐ
        if ($post->user_id !== Auth::id()) {
            return redirect('/');
        }

        // DBのレコードを削除
        $post->delete();

        return redirect('/');
    }
}
