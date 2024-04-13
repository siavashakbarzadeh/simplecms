@extends(BaseHelper::getAdminMasterLayoutTemplate())
@push('header')
    <link href="{{ asset('filter-multi-select-main/filter_multi_select.css') }}" rel="stylesheet" />
@endpush
@push('footer')
    <script src="{{ asset('filter-multi-select-main/filter-multi-select-bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            document.querySelectorAll('select').forEach((el) => {
                $(el).filterMultiSelect();
            })
        });
    </script>
@endpush
@section('content')
    <div class="container">
        <h1>Edit Group</h1>
        <form action="{{ route('groups.update', $group->id) }}" method="POST">
            @csrf
            @method('POST')

            <!-- Group Name and Description Fields -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $group->name }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $group->description }}</textarea>
            </div>

            <!-- Member Selection for Adding via Checkboxes -->
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
            <div class="mb-3">
                <label class="form-label">Current Members</label>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th> <!-- Assuming each member has an email attribute -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group->members as $member)
                            <tr id="memberRow{{ $member->id }}">
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="removeMember({{ $group->id }}, {{ $member->id }})"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-success">Update Group</button>
        </form>
    </div>
    <script>
        function removeMember(groupId, memberId) {
            if (confirm('Are you sure you want to remove this member?')) {
                // Example using Fetch API
                fetch(`/groups/${groupId}/remove-member/${memberId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Laravel CSRF token
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            memberId: memberId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Member removed successfully');
                            document.getElementById('memberRow' + memberId)
                                .remove(); // Remove the member row from the table
                        } else {
                            alert('Failed to remove member');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('Failed to remove member');
                    });
            }
        }
    </script>
@endsection
