@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="container">

        <h2>{{ $group->name }}'s Members</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <!-- Add more columns as necessary, for example: -->
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group->members as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                        <!-- Ensure you replace 'email' with actual member attribute you want to display -->
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
