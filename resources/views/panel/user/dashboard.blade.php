@extends('panel.layout.app')
@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center justify-between max-md:flex-col max-md:items-start max-md:gap-4">
                <div class="col">
                    <div class="page-pretitle">
                        {{__('User Dashboard')}}
                    </div>
                    <h2 class="mb-2 page-title">
                        {{__('Welcome')}}, {{\Illuminate\Support\Facades\Auth::user()->name}}.
                    </h2>
                </div>
                <div class="col-auto">
                    <div class="btn-list">
                        {{-- <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.documents.all') ) }}" class="btn">
                            {{__('My Documents')}}
                        </a>
                        <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.list') ) }}" class="btn btn-primary items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="!me-2" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            {{__('New')}}
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
   
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
					@include('panel.user.payment.subscriptionStatus')
                </div>

                @if($ongoingPayments != null)
                <div class="col-12">
                    @include('panel.user.payment.ongoingPayments')
                </div>
                @endif

                <div class="col-lg-12">
               
                    <div class="card" style=" padding: 18px;">
                    
                        <!-- <div class="px-10 py-8 card-body">
							<h2 class="mb-[1em]">{{__('Overview')}}</h2>
                            <div class="row">
								<div class="col-auto max-xl:w-full max-xl:mb-5">
									<div class="flex max-sm:flex-col max-sm:mb-4">
										<div class="px-9 !ps-0 border-e border-solid border-t-0 border-b-0 border-s-0 border-[var(--tblr-border-color)] max-sm:border-b max-sm:border-e-0 max-sm:px-0 max-sm:pb-3 max-sm:mb-3">
											<p class="subheader">{{__('Words Left')}}</p>
											<p class="mt-2 h1 text-[30px] font-semibold">
                                                @if(Auth::user()->remaining_words == -1)
                                                    Unlimited
                                                @else
                                                    {{number_format((int)Auth::user()->remaining_words)}}
                                                @endif
                                            </p>
										</div>
										<div class="px-9 border-e border-solid border-t-0 border-b-0 border-s-0 border-[var(--tblr-border-color)] max-sm:border-b max-sm:border-e-0 max-sm:px-0 max-sm:pb-3 max-sm:mb-3">
											<p class="subheader">{{__('Images Left')}}</p>
											<p class="mt-2 h1 text-[30px] font-semibold">
                                                @if(Auth::user()->remaining_images == -1)
                                                    Unlimited
                                                @else
                                                    {{number_format((int)Auth::user()->remaining_images)}}
                                                @endif
                                            </p>
										</div>
										<div class="px-9 max-sm:p-0">
											<p class="subheader">{{__('Hours Saved')}}</p>
											<p class="mt-2 h1 text-[30px] font-semibold">{{number_format($total_words*0.5/60)}}</p>
										</div>
									</div>
								</div>
                                <div class="col max-xl:w-full">
                                    <p class="mb-3">{{__('Your Documents')}}</p>
                                    <div class="mb-3 progress progress-separated">
                                        @if($total_documents != 0)
                                        <div class="progress-bar grow-0 shrink-0 basis-auto bg-primary" role="progressbar" style="width: {{100*(int)$total_text_documents/(int)$total_documents}}%" aria-label="{{__('Text')}}"></div>
                                        @endif
                                        @if($total_documents != 0)
                                        <div class="progress-bar grow-0 shrink-0 basis-auto bg-[#9E9EFF]" role="progressbar" style="width: {{100*(int)$total_image_documents/(int)$total_documents}}%" aria-label="{{__('Images')}}"></div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-auto d-flex align-items-center pe-2">
                                            <span class="legend !me-2 rounded-full bg-primary"></span>
                                            <span>{{__('Text')}}</span>
                                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$total_text_documents}}</span>
                                        </div>
                                        <div class="col-auto px-2 d-flex align-items-center">
                                            <span class="legend !me-2 rounded-full bg-[#9E9EFF]"></span>
                                            <span>{{__('Image')}}</span>
                                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$total_image_documents}}</span>
                                        </div>
                                        <div class="col-auto px-2 d-flex align-items-center">
                                            <span class="legend !me-2 rounded-full bg-success"></span>
                                            <span>{{__('Total')}}</span>
                                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$total_documents}}</span>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div> -->
                        <p class="lead-count-top"> Leads Count : {{ $count }}</p>
                    </div>
                </div>

                <!-- <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-heading">{{__('Documents')}}</h3>
                        </div>
                        <div class="card-table table-responsive">
                            <table class="table table-vcenter">
                                <tbody>
                                @foreach(Auth::user()->openai()->orderBy('created_at', 'desc')->take(4)->get() as $entry)
                                    @if($entry->generator != null)
                                    <tr>
										<td class="w-1 !pe-0">
											<span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px]" style="background: {{$entry->generator->color}}">
												@if ( $entry->generator->image !== 'none' )
												{!! html_entity_decode($entry->generator->image) !!}
												@endif
											</span>
                                        </td>
                                        <td class="td-truncate">
                                            <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.documents.single', $entry->slug) ) }}" class="block text-truncate text-heading hover:no-underline">
                                                <span class="font-medium">{{$entry->generator->slug == 'ai_image_generator' ? $entry->input : $entry->generator->title}}</span>
                                                <br>
                                                <span class="italic text-muted opacity-80 dark:!text-white dark:!opacity-50">{{$entry->generator->description}}</span>
                                            </a>
                                        </td>
                                        <td class="text-nowrap">
											<span class="text-heading">{{__('in Workbook')}}</span>
											<br>
                                            <span class="italic text-muted opacity-80 dark:!text-white dark:!opacity-50">{{$entry->created_at->format('M d, Y')}}</span>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->


                <!-- <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-heading">{{__('Favorite Templates')}}</h3>
                        </div>
                        <div class="card-table table-responsive">
                            <table class="table table-vcenter">
                                <tbody>
                                @foreach(\Illuminate\Support\Facades\Auth::user()->favoriteOpenai as $entry)
                                        <tr>
                                            <td class="w-1 !pe-0">
                                      <span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px]" style="background: {{$entry->color}}">
                                        @if ( $entry->image !== 'none' )
                                            {!! html_entity_decode($entry->image) !!}
                                        @endif

                                        @if($entry->active == 1)
                                            <span class="badge bg-green !w-[9px] !h-[9px]"></span>
                                        @else
                                            <span class="badge bg-red !w-[9px] !h-[9px]"></span>
                                        @endif
										</span>
                                            </td>
                                            <td class="td-truncate">
                                                @if($entry->active == 1)
                                                    <a href="@if($entry->type == 'voiceover'){{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.generator', $entry->slug)) }}@else {{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.generator.workbook', $entry->slug)) }}@endif" class="text-heading hover:no-underline">
                                                        <span class="font-medium">{{$entry->title}}</span>
                                                        <br>
                                                        <span class="block italic text-muted opacity-80 text-truncate dark:!text-white dark:!opacity-50">{{$entry->description}}</span>
                                                    </a>
                                                @else
                                                    <div class="text-heading hover:no-underline">
                                                        <span class="font-medium">{{$entry->title}}</span>
                                                        <br>
                                                        <span class="block italic text-muted opacity-80 text-truncate dark:!text-white dark:!opacity-50">{{$entry->description}}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <span class="text-heading">{{__('in Workbook')}}</span>
                                                <br>
                                                <span class="italic text-muted opacity-80">{{$entry->created_at->format('M d, Y')}}</span>
                                            </td>
                                        </tr>
                                    @if($loop->iteration == 4)
                                        @break
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->



                 <div class="card">
				<div id="table-default" class="card-table table-responsive">
					<table class="table">
						<thead>
						<tr>
                            <th><button class="table-sort" data-sort="sort-name">{{__('Name')}}</button></th>
                            <th><button class="table-sort" data-sort="sort-user">{{__('User Type')}}</button></th>
                            <th><button class="table-sort" data-sort="sort-email">{{__('Email')}}</button></th>
                            <!-- <th><button class="table-sort" data-sort="sort-remaining-words">{{__('Words Left')}}</button></th> -->
                            <!-- <th><button class="table-sort" data-sort="sort-remaining-images">{{__('Images Left')}}</button></th> -->
                            <!-- <th><button class="table-sort" data-sort="sort-country">{{__('Country')}}</button></th> -->
                            <th><button class="table-sort" data-sort="sort-status">{{__('Status')}}</button></th>
                            <th><button class="table-sort" data-sort="sort-phone">{{__('Phone')}}</button></th>
                            <th><button class="table-sort" data-sort="sort-date">{{__('Created At')}}</button></th>
                            <!-- <th class="!text-end">{{__('Actions')}}</th> -->
                        </tr>
						</thead>
						<tbody class="table-tbody align-middle text-heading">

                        <!-- TODO DEMO -->
                        @if(env('APP_STATUS') != 'Demo')
                            @foreach($users as $entry)
                                <tr>
                                    <td class="sort-name">{{$entry->fullName()}}</td>
                                    <td class="sort-user">@if($entry->role_id == 3){{ 'Contractor' }}
										@elseif($entry->role_id == 3){{ 'Contractor' }}
                                    
    									@endif
									</td>
                                    <td class="sort-email">{{$entry->email}}</td>
                                    <!-- <td class="sort-remaining-words">{{$entry->remaining_words}}</td> -->
                                    <!-- <td class="sort-remaining-images">{{$entry->remaining_images}}</td> -->
                                    <!-- <td class="sort-country">{{$entry->country}}</td> -->
                                    <td class="sort-status">{{$entry->status == 1 ? __('Active') : __('InActive') }}</td>
                                    <td class="sort-phone">{{$entry->phone}}</td>
                                    <td class="sort-date" data-date="{{strtotime($entry->created_at)}}">
                                        <p class="m-0">{{date("j.n.Y", strtotime($entry->created_at))}}</p>
                                        <p class="m-0 text-muted">{{date("H:i:s", strtotime($entry->created_at))}}</p>
                                    </td>
                                    <!-- <td class="!text-end whitespace-nowrap">
                                        <a href="{{route('dashboard.admin.users.edit', $entry->id)}}" class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white" title="{{__('Edit')}}">
                                            <svg width="13" height="12" viewBox="0 0 15 14" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.71875 2.43988L11.9688 5.58995M10.75 11.4963H14M4.25 13.0714L12.7812 4.80248C12.9946 4.59564 13.1639 4.35009 13.2794 4.07984C13.3949 3.8096 13.4543 3.51995 13.4543 3.22744C13.4543 2.93493 13.3949 2.64528 13.2794 2.37504C13.1639 2.10479 12.9946 1.85924 12.7812 1.6524C12.5679 1.44557 12.3145 1.28149 12.0357 1.16955C11.7569 1.05761 11.458 1 11.1562 1C10.8545 1 10.5556 1.05761 10.2768 1.16955C9.99799 1.28149 9.74465 1.44557 9.53125 1.6524L1 9.92135V13.0714H4.25Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                        <a href="{{route('dashboard.admin.users.delete', $entry->id)}}" onclick="return confirm('{{__('Are you sure? This is permanent and will delete all documents related to user.')}}')" class="btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white" title="{{__('Delete')}}">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z"/>
                                            </svg>
                                        </a>
                                    </td> -->
                                </tr>
                            @endforeach
                        @else
                            <tr>
                               <td colspan="8">User Informations are hidden in demo due to GDPR. See <a href="https://en.wikipedia.org/wiki/General_Data_Protection_Regulation" target="_blank">What is GDPR</a> </td>
                            </tr>
                            <tr>
                                <td class="sort-name">John Doe</td>
                                <td class="sort-group">User</td>
                                <td class="sort-remaining-words">12.154</td>
                                <td class="sort-remaining-images">940</td>
                                <td class="sort-country">Hungary</td>
                                <td class="sort-status">Active</td>
                                <td class="sort-date" data-date="19-12-2022">
                                    <p class="m-0">19-12-2022</p>
                                    <p class="m-0 text-muted">19-12-2022</p>
                                </td>
                                <td class="!text-end whitespace-nowrap">
                                    <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')" class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white" title="{{__('Edit')}}">
                                        <svg width="13" height="12" viewBox="0 0 15 14" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.71875 2.43988L11.9688 5.58995M10.75 11.4963H14M4.25 13.0714L12.7812 4.80248C12.9946 4.59564 13.1639 4.35009 13.2794 4.07984C13.3949 3.8096 13.4543 3.51995 13.4543 3.22744C13.4543 2.93493 13.3949 2.64528 13.2794 2.37504C13.1639 2.10479 12.9946 1.85924 12.7812 1.6524C12.5679 1.44557 12.3145 1.28149 12.0357 1.16955C11.7569 1.05761 11.458 1 11.1562 1C10.8545 1 10.5556 1.05761 10.2768 1.16955C9.99799 1.28149 9.74465 1.44557 9.53125 1.6524L1 9.92135V13.0714H4.25Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')" class="btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white" title="{{__('Delete')}}">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td class="sort-name">Patricia Foe</td>
                                <td class="sort-group">User</td>
                                <td class="sort-remaining-words">10.154</td>
                                <td class="sort-remaining-images">120</td>
                                <td class="sort-country">Albania</td>
                                <td class="sort-status">Active</td>
                                <td class="sort-date" data-date="19-12-2022">
                                    <p class="m-0">12-12-2022</p>
                                    <p class="m-0 text-muted">19-12-2022</p>
                                </td>
                                <td class="!text-end whitespace-nowrap">
                                    <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')" class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white" title="{{__('Edit')}}">
                                        <svg width="13" height="12" viewBox="0 0 15 14" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.71875 2.43988L11.9688 5.58995M10.75 11.4963H14M4.25 13.0714L12.7812 4.80248C12.9946 4.59564 13.1639 4.35009 13.2794 4.07984C13.3949 3.8096 13.4543 3.51995 13.4543 3.22744C13.4543 2.93493 13.3949 2.64528 13.2794 2.37504C13.1639 2.10479 12.9946 1.85924 12.7812 1.6524C12.5679 1.44557 12.3145 1.28149 12.0357 1.16955C11.7569 1.05761 11.458 1 11.1562 1C10.8545 1 10.5556 1.05761 10.2768 1.16955C9.99799 1.28149 9.74465 1.44557 9.53125 1.6524L1 9.92135V13.0714H4.25Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')" class="btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white" title="{{__('Delete')}}">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endif
						</tbody>
						<tfoot>

						</tfoot>
					</table>
                    <div class="flex items-center border-solid border-t border-r-0 border-b-0 border-l-0 border-[--tblr-border-color] px-[--tblr-card-cap-padding-x] py-[--tblr-card-cap-padding-y] [&_.rounded-md]:rounded-full">
						<ul class="pagination m-0 ms-auto p-0"></ul>
                    </div>
				</div>
            </div>
            </div>
        </div>
    </div>
@endsection
