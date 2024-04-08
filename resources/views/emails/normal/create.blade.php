@extends(BaseHelper::getAdminMasterLayoutTemplate())

@push('header')
    <link href="{{ asset('filter-multi-select-main/filter_multi_select.css') }}" rel="stylesheet"/>
@endpush
@push('footer')
    @php
        Assets::addScriptsDirectly(config('core.base.general.editor.ckeditor.js'))
            ->addScriptsDirectly('vendor/core/core/base/js/editor.js');

        if (BaseHelper::getRichEditor() == 'ckeditor' && App::getLocale() != 'en') {
            Assets::addScriptsDirectly('https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/translations/' . App::getLocale() . '.js');
        }
    @endphp
    <script src="{{ asset('filter-multi-select-main/filter-multi-select-bundle.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            document.querySelectorAll('select').forEach((el) => {
                $(el).filterMultiSelect();
            })
        });
    </script>
@endpush
@section('content')
    <div class="wrapper-content pd-all-20">
        <form action="{{ route('admin.emails.normal.store') }}" method="post">
            @csrf
            <div class="row">
{{--                @foreach($emails as $key=>$email)--}}
{{--                    <div class="col-12 col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="select_{{ $key }}" class="text-title-field">{{ $key }}</label>--}}
{{--                            <select name="emails[{{ $key }}][]" id="select_{{ $key }}" multiple>--}}
{{--                                @foreach($email as $item)--}}
{{--                                    <option value="{{ $item['email'] }}"--}}
{{--                                            @if(old('emails') && in_array($item['email'],collect(old('emails'))->flatten()->toArray())) selected @endif>{{ $item['email'] }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('select_'.$key)--}}
{{--                            <span class="text-danger">{{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
                <div class="col-12 col-md-4">
                    <div class="mb-3">
                        <label for="select_members" class="text-title-field">News letter</label>
                        <select name="member_emails[]" id="select_members" multiple>
                            @foreach($members as $item)
                                <option value="{{ $item['email'] }}"
                                        @if(old('member_emails') && in_array($item['email'],old('member_emails'))) selected @endif>{{ $item['email'] }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#addUserGroupModal">Add to User Group</button>
                        @error('member_emails')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label for="subject" class="text-title-field">Subject</label>
                        <input type="text" class="form-control next-input @error('subject') is-invalid @enderror"
                               name="subject" id="subject" value="{{ old('subject') }}">
                        @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label for="reply_to" class="text-title-field">Reply to</label>
                        <input type="text" class="form-control next-input @error('reply_to') is-invalid @enderror"
                               name="reply_to" id="reply_to" value="{{ old('reply_to') }}">
                        @error('reply_to')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="body" class="text-title-field">Body</label>
                <textarea name="body" id="body" rows="10"
                          class="form-control editor-ckeditor ays-ignore @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
                @error('body')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="btn btn-success">Send</button>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="addUserGroupModal" tabindex="-1" role="dialog" aria-labelledby="addUserGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserGroupModalLabel">Add User to Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form or input fields for adding user to a group -->
                        <form id="addUserGroupForm">
                            <div class="form-group">
                                <label for="userEmail">User Email</label>
                                <input type="email" class="form-control" id="userEmail" placeholder="Enter user's email">
                            </div>
                            <div class="form-group">
                                <label for="groupName">Group Name</label>
                                <input type="text" class="form-control" id="groupName" placeholder="Enter group name">
                            </div>
                            <!-- Add more fields as necessary -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitAddUserGroupForm()">Add User</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        function submitAddUserGroupForm() {
            var userEmail = document.getElementById('userEmail').value;
            var groupName = document.getElementById('groupName').value;

            // Example AJAX request (You'll need to adjust according to your setup)
            $.ajax({
                url: '/path-to-your-route', // Update this to your server endpoint
                type: 'POST',
                data: {
                    email: userEmail,
                    group: groupName,
                    _token: '{{ csrf_token() }}' // CSRF token for Laravel
                },
                success: function(response) {
                    // Handle success (e.g., close modal, show message)
                    $('#addUserGroupModal').modal('hide');
                    // Optionally refresh parts of your page or notify the user
                },
                error: function(error) {
                    // Handle error
                    console.error("There was an error:", error);
                }
            });
        }
    </script>

@endsection
