@extends('layouts.app')
@section('title', '一覧画面｜')
@section('content')


<!-- Error & Search Message -->
<div class="message m-auto">
@isset($search_result)
    <div class="err_style col-md-4 pt-1 rounded m-auto">
        <p class="text-success text-center fs-5 fw-bold">{{ $search_result }}</p>
    </div>
@endisset

@if (session('err_msg'))
    <div class="err_style col-md-4 pt-1 rounded m-auto">
        <p class="text-success text-center fs-5 fw-bold">
            {{ session('err_msg') }}
        </p>
    </div>
    @endif
</div>



@foreach($posts as $post)
    <div class="container">
        <div class="main-posts">
            <div class="main-post-table rounded my-3 bg-warning">
                <div class="main-left justify-content-around">
                    <div class="first-main-body ">
                    <p class="card-title my-3 fs-5 fw-bold text-center"><a href="{{ route('show', $post->user_id)}}" class="title-name text-decoration-none text-dark">{{ $post->user->name }}</a>
                        </p>
                        <h3 class="text-center text-break">『<span class="span-title  fw-bold">{{ $post->title }}</span>』</h3>
                        <div class="text-center">
                            <img src="{{ $post->image_path }}" alt="画像" class="" style="height: 220px; width: 313px;">
                        </div>
                    </div>


                    <div class="text-center ">
                        <div class="text-dark fw-bold mt-2 text-center">
                            {{ $post->created_at }}
                        </div>  
                        @if(Auth::user()->id == $post->user_id)
                        <form method="POST" action="{{ route('post.delete', $post->id)}}" onSubmit="return experienceDlete()">
                        @csrf
                        <button type="submit" class="btn btn-danger ms-3" onclick=><i class="fas fa-trash-alt"></i></button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function experienceDlete(){
    if(confirm('あなたの体験を削除してもいいかな？')){
        return true;
    } else {
        return false;
        }
    }
</script>

@endsection
