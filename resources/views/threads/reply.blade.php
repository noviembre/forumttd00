<reply :attributes="{{$reply}}" inline-template>
    <div id="reply-{{ $reply->id }}" class="card">

        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a>
                    said {{ $reply->created_at->diffForHumans() }}
                </h5>

                <div>
                    <form method="post" action="/replies/{{$reply->id}}/favorites">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }}
                            {{ str_plural('Favorite', $reply->favorites_count)  }}
                        </button>
                    </form>

                </div>
            </div>

        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-info btn-sm" @click="update">Update</button>
                <button class="btn btn-link btn-sm" @click="editing = false">Cancel</button>

            </div>

            <div v-else>
                {{ $reply->body }}
            </div>
        </div>

        @can('update',$reply)
            <div class="card-footer level">
                <button class="btn btn-info btn-sm mr-1" @click="editing = true">Edit</button>
                <form action="/replies/{{$reply->id}}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>

            </div>
        @endcan
    </div>
</reply>