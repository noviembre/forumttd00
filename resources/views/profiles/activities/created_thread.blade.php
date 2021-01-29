<div class="card">
    <div class="card-header">
        <div class="level">
            <span class="flex">
                {{ $profileUser->name }} published to thread
            </span>
        </div>
    </div>
    <div class="card-body">
        {{ $activity->subject->body }}
    </div>
</div>