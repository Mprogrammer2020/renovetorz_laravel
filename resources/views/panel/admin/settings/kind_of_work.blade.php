@extends('panel.layout.app')
@section('title', 'Services')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
					<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.index') ) }}" class="page-pretitle flex items-center">
						<svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
						</svg>
						{{__('Back to dashboard')}}
					</a>
                    <h2 class="page-title mb-2">
                        {{__('Add Kind Of Work')}}
                    </h2>	
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
            <button class="btn btn-primary add-service-btn" onclick="showWorkModal()">Add Work</button>
			<div class="card">
				<div id="table-default" class="card-table table-responsive">
					<table class="table table-vcenter">
						<thead>
						<tr>
							<th>{{__('S.no')}}</th>
							<th>{{__('Name')}}</th>
                            <th>{{__('Description')}}</th>
							<th>{{__('Actions')}}</th> 
						</tr>
						</thead>
						<tbody class="table-tbody">
						@foreach($kindOfWorkList as $key => $kindOfWork)
							<tr>
							<td class="sort-ticketid text-capitalize">{{ $loop->iteration }}</td>

								<td class="sort-Status">{{$kindOfWork->name}}</td>
                                <td class="sort-Status">{{$kindOfWork->description}}</td>
								<td class="!text-start whitespace-nowrap">
										<a href="#" onclick="edit_work({{$kindOfWork->id}},'{{$kindOfWork->name}}','{{$kindOfWork->description}}')" class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white" title="{{__('Edit')}}">
										<svg width="13" height="12" viewBox="0 0 15 14" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M8.71875 2.43988L11.9688 5.58995M10.75 11.4963H14M4.25 13.0714L12.7812 4.80248C12.9946 4.59564 13.1639 4.35009 13.2794 4.07984C13.3949 3.8096 13.4543 3.51995 13.4543 3.22744C13.4543 2.93493 13.3949 2.64528 13.2794 2.37504C13.1639 2.10479 12.9946 1.85924 12.7812 1.6524C12.5679 1.44557 12.3145 1.28149 12.0357 1.16955C11.7569 1.05761 11.458 1 11.1562 1C10.8545 1 10.5556 1.05761 10.2768 1.16955C9.99799 1.28149 9.74465 1.44557 9.53125 1.6524L1 9.92135V13.0714H4.25Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</a>
									<a href="#" onclick="delete_work({{$kindOfWork->id}})" onclick="return confirm('{{__('Are you sure? This is permanent and will delete all documents related to user.')}}')" class="btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white" title="{{__('Delete')}}">
										<svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z"/>
										</svg>
									</a>
								</td>
							</tr>
						@endforeach

						</tbody>
					</table>
					{{ $kindOfWorkList->links() }}
				</div>
			</div>
        </div>
    </div>

@include('panel.service.modal.kind_of_work')
@endsection

@section('script')
    <script src="/assets/js/panel/settings.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
