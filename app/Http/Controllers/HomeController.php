<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use JD\Cloudder\Facades\Cloudder;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::all();
        $posts->load('user');
        // dd($posts);
        return view('home', ['posts' => $posts]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post;
        
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::id();


        if ($image = $request->file('image')) {
            $image_path = $image->getRealPath();
            Cloudder::upload($image_path, null);
            //直前にアップロードされた画像のpublicIdを取得する。
            $publicId = Cloudder::getPublicId();
            $logoUrl = Cloudder::secureShow($publicId, [
                'width'     => 300,
                'height'    => 300
            ]);
            $post->image_path = $logoUrl;
            $post->public_id  = $publicId;
        }

        try {
            //code...
            //登録
            $post->save();
            // dd($post);
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollback();
            abort(500);
        }


        \Session::flash('err_msg', 'あなたの投稿を登録しました。');
        return redirect()->route('home');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        $user = User::find($id);
        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc');
        // dd($posts);

        if (is_null($posts)) {
            \Session::flash('err_msg', 'データがないよ');
            return redirect(route('home'));
        }

        return view('post.user', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postdelete($id)
    {
        if (empty($id)) {
            \Session::flash('err_msg', 'データがないよ');
            return redirect(route('home'));
        }

        $post = Post::find($id);

        if(isset($post->public_id)){
            Cloudder::destroyImage($post->public_id);
        }

        try {
            //code...
            $post->delete($id);
        } catch (\Throwable $th) {
            //throw $th;
            abort(500);
        }

        \Session::flash('err_msg', '削除ができました');
        return redirect()->route('home');
    }

}
