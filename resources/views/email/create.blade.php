@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="col-xl">
					<form action="{{ route('email.send') }}" method="POST" enctype="multipart/form-data">
						@csrf
					    <div class="card mb-2">
						    <h6 class="card-header">{{ __('Recipient Set In Different Ways')}}</h6>
						    <div class="card-body">
					    		<div class="row">
									<div class="col-md-6 mb-2">
										<div class="mb-3">
                                            <div class="input-group input-group-merge">
                                                <label class="w-100 d-block">
                                                    <select name="emails[]" multiple="multiple" class="multiple-select">
                                                        @foreach($customers as $customer)
                                                            <option value="{{ $customer->email }}" @if(old('emails') && in_array($customer->email,old('emails'))) selected @endif>{{ $customer->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
										</div>
									</div>
					    		</div>
					      	</div>
					    </div>

					    <div class="card mb-2">
						    <h6 class="card-header">{{ __('Email Header Information')}}</h6>
						    <div class="card-body">
						    	<div class="row">
						    		<div class="col-md-4 mb-2">
					            		<label class="form-label">
					            			{{ __('Subject')}} <sup class="text-danger">*</sup>
					            		</label>
					            		<div class="input-group input-group-merge">
					              			<input type="text"  value="{{old("subject")}}" name="subject" id="subject" class="form-control" placeholder="{{ __('Write email subject here')}}">
					            		</div>
					          		</div>
						    		<div class="col-md-4 mb-2">
										<label class="form-label">
											{{ __('Send From')}}
										</label>
										<div class="input-group input-group-merge">
												<input class="form-control" value="{{old("from_name")}}" placeholder="{{ __('Sender Name (Optional)')}}" type="text" name="from_name" id="from_name">
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<label class="form-label">
											{{ __('Reply To Email')}}
										</label>
										<div class="input-group input-group-merge">
												<input class="form-control" value="{{old("reply_to_email")}}" type="email" placeholder="{{ __('Reply To Email (Optional)')}}" name="reply_to_email" id="reply_to_email">
										</div>
									</div>
						    	</div>
						    </div>
						</div>

					    <div class="card mb-2">
						    <h6 class="card-header">{{ __('Email Body')}}</h6>
						    <div class="card-body">
				          		<div class="row">
					          		<div class="col-12">
					            		<label class="form-label">
					            			{{ __('Message Body')}} <sup class="text-danger">*</sup>
					            		</label>
					            		<div class="input-group">
                                            <label class="w-100 d-block">
                                                <textarea class="form-control w-100" name="message" id="message">{!! old('message') !!}</textarea>
                                            </label>
					            		</div>
					          		</div>
				          		</div>
					      	</div>
					    </div>

					    <div class="card mb-2">
						    <h6 class="card-header">{{ __('Sending Options')}}</h6>
						    <div class="card-body">
				          		<div class="row">
				          			<div class="col-md-6 mb-4">
					            		<label for="schedule" class="form-label">{{ __('Send Email')}} <sup class="text-danger">*</sup></label>
										<div>
											<div class="form-check form-check-inline">
												<input {{old("now") ==  '1'? "checked" :""}} class="form-check-input" type="radio" name="now" id="now" value="1" checked="">
												<label class="form-check-label" for="now">{{ __('Now')}}</label>
											</div>

											<div class="form-check form-check-inline">
												<input  {{old("now") ==  '2'? "checked" :""}} class="form-check-input" type="radio" name="now" id="later" value="2">
												<label class="form-check-label" for="later">{{ __('Later')}}</label>
											</div>
										</div>
					          		</div>
					          		<div class="col-md-6 schedule-date" @if(old("now") !=  '2') style="display:none;" @endif>
                                        <div class="d-flex gap-2 align-items-center w-100">
                                            <label class="d-flex flex-column">
                                                <input type="date" name="schedule_date" value="{{ old('schedule_date') }}" class="form-control" @if(old("now") !=  '2') disabled @endif>
                                                @error('schedule_date')
                                                <span class="text-sm text-danger">{{ $message }}</span>
                                                @enderror
                                            </label>
                                            <label class="d-flex flex-column">
                                                <input type="time" name="schedule_time" value="{{ old('schedule_time') }}" class="form-control" @if(old("now") !=  '2') disabled @endif>
                                                @error('schedule_time')
                                                <span class="text-sm text-danger">{{ $message }}</span>
                                                @enderror
                                            </label>
                                        </div>
                                    </div>
				          		</div>
				          	</div>
				        </div>

					    <button type="submit" class="btn btn-primary me-sm-3 me-1">
							{{__("Submit")}}
						</button>
				    </form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

