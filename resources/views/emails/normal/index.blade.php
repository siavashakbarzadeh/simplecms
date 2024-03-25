@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div id="main">
        <div class="table-wrapper">
            <div class="portlet light bordered portlet-no-padding">
                <div class="portlet-title">
                    <div class="caption">
                        <div class="wrapper-action">
                            <a href="{{ route('admin.emails.normal.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                                Create
                            </a>
                        </div>
                    </div>
                </div>
                <form action="" class="pt-3">
                    <div class="row mx-0">
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" id="subject" value="{{ request('subject') }}" class="form-control" placeholder="Subject">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="portlet-body">
                    <div class="table-responsive  table-has-actions   table-has-filter ">
                        <div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <table aria-describedby="botble-member-tables-member-table_info" role="grid"
                                   class="table table-striped table-hover vertical-middle dataTable no-footer dtr-inline">
                                <thead>
                                <tr role="row">
                                    <th title="ID" class="text-center">ID</th>
                                    <th title="Subject" class="text-center">Subject</th>
                                    <th title="Reply to" class="text-center">Reply to</th>
                                    <th title="Created at" class="text-center">Created at</th>
                                    <th title="Operations" class="text-center">Operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($emails as $email)
                                    <tr role="row" class="{{ $loop->odd ? 'odd' : 'even' }}">
                                        <td class="text-center">{{ $email->id }}</td>
                                        <td class="text-center">{{ $email->subject }}</td>
                                        <td class="text-center">{{ $email->reply_to }}</td>
                                        <td class="text-center">{{ $email->created_at->toDateString() }}</td>
                                        <td class="text-center">
                                            <div class="table-actions">

                                                <a href="http://127.0.0.1:8000/admin/members/edit/10"
                                                   class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                                   data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                                <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                                   data-bs-toggle="tooltip"
                                                   data-section="http://127.0.0.1:8000/admin/members/10" role="button"
                                                   data-bs-original-title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $emails->appends(request()->only(['subject']))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

