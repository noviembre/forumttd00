@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $profileUser->name }}</h2>
                    </div>

                    @can ('update', $profileUser)
                        <form method="post" action="{{ route('avatar', $profileUser) }}" enctype="multipart/form-data">
                            @csrf

                            <input type="file" name="avatar">
                            <button type="submit" class="btn btn-primary">Add Avatar</button>

                        </form>
                    @endcan

                    <img src="{{ asset($profileUser->avatar_path) }}" width="150" height="150" title="hola">
                </div>

                @forelse($activities as $date => $activity)
                    <h3>{{ $date }}</h3>

                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach

                @empty

                    <p>There is not activity for this user yet.</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection