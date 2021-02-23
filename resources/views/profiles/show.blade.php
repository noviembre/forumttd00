@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <avatar-form :user="{{$profileUser}}"></avatar-form>
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