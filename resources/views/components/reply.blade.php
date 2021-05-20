<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card mb-3">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">{{$reply->owner->name}}</a>
                    Said {{ $reply->created_at->diffForHumans() }} ...
                </h5>

                <div>
                    <form method="POST" action="{{route('reply.favorite',$reply)}}">
                        @csrf

                        <button type="submit"
                                class="btn btn-outline-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
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

                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>


        @can (['update','delete'], $reply)
            <div class="card-footer level">
                <button class="btn btn-warning btn-sm mr-3" @click="editing = true">Edit</button>
                <form method="POST" action="{{route('replies.delete',$reply)}}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</reply>
