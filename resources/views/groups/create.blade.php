@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="container">
        <h1>Create New Group</h1>
        <form action="{{ route('groups.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Group Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Members</label>
                <div
                    style="height: 150px; overflow-y: auto; border: 1px solid #ced4da; padding: 10px; border-radius: 0.25rem;">
                    @foreach ($allMembers as $member)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $member->id }}"
                                id="member{{ $member->id }}" name="membersToAdd[]">
                            <label class="form-check-label" for="member{{ $member->id }}">
                                {{ $member->email }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create Group</button>
        </form>
    </div>
@endsection
