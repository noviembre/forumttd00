@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header bg-success">
                        {{ $profileUser->name }}
                        <small>Since: {{ $profileUser->created_at->diffForHumans() }}</small>
                    </div>

                </div>

                @foreach($threads as $thread)
                    <div class="card">
                        <div class="card-header">
                            <div class="level">

                                <span class="pull-right">
                                    <a href="{{ route('profile', $thread->creator) }}">{{$thread->creator->name}}</a>
                                posted: {{ $thread->title }}
                                </span>
                            </div>

                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                        <div class="card-footer">
                            {{ $thread->created_at->diffForHumans() }}
                        </div>

                    </div>
                @endforeach

                {{$threads->links()}}


            </div>
        </div>
    </div>
@endsection