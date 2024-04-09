@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="container">
        <h1>Groups</h1>
        <a href="{{ url('admin/groups/create') }}" class="btn btn-primary">Add User to Group</a>
        <!-- Add more actions as needed -->
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->description }}</td>
                        <td>
                            <a href="{{ url('admin/groups/view', $group->id) }}" class="btn btn-info">View</a>
                            <a href="{{ url('admin/groups/edit', $group->id) }}" class="btn btn-success">Edit</a>
                            <form action="{{ url('admin/groups/delete', $group->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $groups->links() }} <!-- Pagination links -->
    </div>
@endsection
