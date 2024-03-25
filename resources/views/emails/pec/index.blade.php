@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div id="main">
        <div class="table-wrapper">
            <div class="portlet light bordered portlet-no-padding">
                <div class="portlet-title">
                    <div class="caption">
                        <div class="wrapper-action">
                            <a href="{{ route('admin.emails.pec.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                                Create
                            </a>
                        </div>
                    </div>
                </div>
                <section class="mt-3">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        {{--	                    <form action="{{route('admin.email.search',$scope ?? str_replace('admin.email.', '', request()->route()->getName()))}}" method="GET">--}}
                                        <form action="" method="GET">
                                            <div class="row align-items-center">
                                                <div class="col-lg-5">
                                                    <label CLASS="bg-info"> {{ __('By User/Email/To Recipient Email') }}</label>
                                                    <input type="text" autocomplete="off" name="search" value="" placeholder="@lang('Search with User, Email or To Recipient Email')" class="form-control" id="search" value="{{@$search}}">
                                                </div>
                                                <div class="col-lg-5">
                                                    <label>
                                                        {{ __('By Date') }}
                                                    </label>
                                                    <input type="text" class="form-control datepicker-here" name="date" value="{{@$searchDate}}" data-range="true" data-multiple-dates-separator=" - " data-language="en" data-position="bottom right" autocomplete="off" placeholder="@lang('From Date-To Date')" id="date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <button class="btn btn-info w-100 h-45 mt-4" type="submit">
                                                        <i class="fas fa-search"></i> {{ __('Search')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-2 statusUpdateBtn d-none">
                                    <button class="btn btn--danger w-100 statusupdate text-white"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Status Update"
                                            data-bs-toggle="modal"
                                            data-bs-target="#smsstatusupdate"
                                            type="submit">
                                        <i class="fas fa-gear"></i> {{__('Action')}}
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="card mb-4">
                                    <div class="responsive-table">
                                        <table class="table datatable">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <div class="d-flex align-items-center">
                                                        <input class="form-check-input mt-0 me-2 checkAll"
                                                               type="checkbox"
                                                               value=""
                                                               aria-label="Checkbox for following text input"> <span>#</span>
                                                    </div>
                                                </th>
                                                <th> {{ __('User')}}</th>
                                                <th> {{ __('Sender')}}</th>
                                                <th> {{ __('To')}}</th>
                                                <th> {{ __('Subject')}}</th>
                                                <th> {{ __('Initiated')}}</th>
                                                <th> {{ __('Status')}}</th>
                                                <th> {{ __('Action')}}</th>
                                            </tr>
                                            </thead>
                                            @forelse($emails as $email)
                                                <tr class="@if($loop->even) table-light @endif">
                                                    <td class="d-none d-md-flex align-items-center">
                                                        <input class="form-check-input mt-0 me-2" type="checkbox" name="emaillog" value="{{$email->id}}" aria-label="Checkbox for following text input">
                                                        {{$loop->iteration}}
                                                    </td>

                                                    <td data-label=" {{ __('User')}}">

                                                        @if ($email->user !== null)
                                                            {{$email->user->email}}
                                                          @else
                                                            <span> {{ __('Admin')}}</span>
                                                        @endif

                                                    </td>

                                                    <td data-label=" {{ __('Sender')}}">
                                                        @if ($email->sender!== null)
                                                            {{$email->sender->name}}
                                                        @else
                                                            <span> {{ __('SMTP')}}</span>
                                                        @endif

                                                    </td>

                                                    <td data-label=" {{ __('To')}}">
                                                        {{$email->to}}
                                                    </td>

                                                    <td data-label=" {{ __('Subject')}}">
                                                        {{$email->subject}}
                                                    </td>

                                                    <td data-label=" {{ __('Initiated')}}">
                                                        {{--				                    	{{getDateTime($email->initiated_time)}}--}}
                                                    </td>

                                                    <td data-label=" {{ __('Status')}}">
                                                        @if($email->status == 1)
                                                            <span class="badge badge--primary"> {{ __('Pending ')}}</span>
                                                        @elseif($email->status == 2)
                                                            <span class="badge badge--info"> {{ __('Schedule')}}</span>
                                                        @elseif($email->status == 3)
                                                            <span class="badge badge--danger"> {{ __('Fail')}}</span>
                                                        @else
                                                            <span class="badge badge--success"> {{ __('Delivered')}}</span>
                                                        @endif
                                                        <a class="s_btn--coral text--light statusupdate"
                                                           data-id="{{$email->id}}"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-placement="top" title="Status Update"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#smsstatusupdate"
                                                        ><i class="las la-info-circle"></i></a>
                                                    </td>

                                                    <td data-label=" {{ __('Action')}}">
                                                        @if($email->status == 1)
{{--                                                            <a href="{{route('admin.email.single.mail.send', $email->id)}}" class="btn--warning text--light" data-bs-toggle="tooltip" data-bs-placement="top" title="Resend" ><i class="las la-paper-plane"></i></a>--}}
                                                        @endif
                                                        <a class=" btn btn-primary text-light" href="" target="_blank"
                                                        ><i class="fa fa-desktop"></i></a>
                                                        <a class="btn btn-primary text-light" href="" target="_blank"
                                                        ><i class="fa fa-desktop"></i></a>

                                                        <a  class="btn btn-danger tex-light emaildelete"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#delete"
                                                           data-delete_id="{{$email->id}}"
                                                        ><i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-muted text-center" colspan="100%"> {{ __('No Data Found')}}</td>
                                                </tr>
                                            @endforelse
                                        </table>
                                    </div>
                                    <div class="m-3">
                                        {{--	                	{{$emails->appends(request()->all())->links()}}--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <div class="modal fade" id="smsstatusupdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            {{--			<form action="{{route('admin.email.status.update')}}" method="POST">--}}
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="id">
                                <input type="hidden" name="emaillogid">
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-header bg--lite--violet">
                                            <div class="card-title text-center text--light"> {{ __('Email Status Update')}}</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="status" class="form-label"> {{ __('Status')}} <sup class="text--danger">*</sup></label>
                                                <select class="form-control" name="status" id="status" required>
                                                    <option value="" selected disabled> {{ __('Select Status')}}</option>
                                                    <option value="1"> {{ __('Pending')}}</option>
                                                    <option value="3"> {{ __('Failed')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal_button2">
                                    <button type="button" class="" data-bs-dismiss="modal"> {{ __('Cancel')}}</button>
                                    <button type="submit" class="bg--success"> {{ __('Submit')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="smsdetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header bg--lite--violet">
                                        <div class="card-title text-center text--light"> {{ __('Message')}}</div>
                                    </div>
                                    <div class="card-body mb-3">
                                        <p id="message--text"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="modal_button2">
                                <button type="button" class="w-100" data-bs-dismiss="modal"> {{ __('Cancel')}}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            {{--        	<form action="{{route('admin.email.delete')}}" method="POST">--}}
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="">
                                <div class="modal_body2">
                                    <div class="modal_icon2">
                                        <i class="las la-trash-alt"></i>
                                    </div>
                                    <div class="modal_text2 mt-3">
                                        <h6> {{ __('Are you sure to delete this email from log')}}</h6>
                                    </div>
                                </div>
                                <div class="modal_button2">
                                    <button type="button" class="" data-bs-dismiss="modal"> {{ __('Cancel')}}</button>
                                    <button type="submit" class="bg--danger"> {{ __('Delete')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
