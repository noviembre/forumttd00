<div class="card">
    <div class="card-header">
        <div class="level">

            <img src="{{ asset($thread->creator->avatar_path) }}" width="25" height="25" class="mr-1">
            <span class="flex">
                                <a href="{{ route('profile', $thread->creator) }}">
                                    {{ $thread->creator->name }}
                                </a> Posted by:
                {{ $thread->title }}
                            </span>

            @can('update', $thread)
                <form action="{{ $thread->path() }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">Delete</button>

                </form>
            @endcan

        </div>

    </div>

    <div class="card-body">
        {{ $thread->body }}
    </div>
</div>