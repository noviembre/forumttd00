@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a> Posted by:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach

                @if(auth()->check())
                    <form method="post" action="{{ $thread->path(). '/replies' }}">
                        @csrf
                        <div class="form-group">
                        <textarea name="body" id="body" rows="5" placeholder="Something to say?" class="form-control">

                        </textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Post</button>

                    </form>

                @else
                    <p class="text-center">Please
                        <a href="{{ route('login') }}">Sign in</a>
                        to participate in this discussion
                    </p>
                @endif

            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">

                    </div>

                    <div class="card-body">
                        <p>This thread was published
                            {{$thread->created_at->diffForHumans()}}
                            by: <a href="#">{{ $thread->creator->name }}</a>,
                            and currently has
                            {{ $thread->replies->count() }} comments.

                        </p>

                    </div>

                </div>

            </div>
        </div>





    </div>
@endsection