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
                <label for="select_members" class="text-title-field">Members</label>
                <select name="membersToAdd[]" id="select_members" multiple>
                    @foreach ($allMembers as $member)
                        <option value="{{ $member['id'] }}" @if (old('member') && in_array($member['id'], old('member'))) selected @endif>
                            {{ $member['email'] }}</option>
                    @endforeach
                </select>

                @error('member_emails')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Group</button>
        </form>
    </div>
@endsection
