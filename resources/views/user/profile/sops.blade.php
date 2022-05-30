@extends('layout')
@section('title','SOPs/Forms')

@section('css_plugin')
<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('page_css')

@endsection

@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center mb-3">
	<div class="breadcrumb-title pe-3">Home</div>
	<div class="ps-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0 p-0">
				<li class="breadcrumb-item">   @if (Auth::user()->role=="student")
					<a href="{{route('profile.view')}}"><i class="bx bx-home-alt"></i></a>
				 @else
					<a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
				 @endif
				</li>
				<li class="breadcrumb-item active" aria-current="page">SOPs/Forms</li>
			</ol>
		</nav>
	</div> 
</div>
@endsection

@section('main_content')
<div class="row profile">
	<div class="col">
		<div class="card">
			<div class="card-body position-relative">
				<div class="col-lg-10 mx-auto">
                    <div class="row">
                       <div class="col-12">
                          <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2">
                             	SOP/Form Details
                          </div>
                       </div>
                    </div>
                </div>
				<form class="col-lg-10 mx-auto" id="sop-form" action="{{route('profile.update-sop')}}">
					@csrf
					<input type="hidden" value="{{$user_id}}" name="user_id" id="user_id">
					@foreach ($user['sop_colleges'] as $sop_key => $sop)
                  @php
                     $college = $sop->college->name;
                     $sop_file = $sop->file;
                     $sop_review = $sop->review;
					 $clg_id=$sop->college_id;
                  @endphp
                  <div class="card sop_div" id="college_row_{{$sop_key}}">
                     <div class="card-body">
                        <div class="row align-items-center">
                           <div class="col-12 col-xl order-xl-2">
								<div class="row align-items-center justify-content-center">
									<div class="col-auto">
										@if(!empty($sop_file))
										<a href="{{route('user-files', $sop_file)}}" class="btn btn-warning btn-sm" target="_blank" >view</a>
										@endif
									</div>
									@if (!empty($sop_review))									
									<div class="col-auto">
										<a role="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$sop_key}}"class="btn btn-dark btn-sm" target="_blank" >View Review</a>
										<div class="modal fade" id="staticBackdrop{{$sop_key}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
											<div class="modal-dialog">
											  <div class="modal-content">
												<div class="modal-header">
												  <h5 class="modal-title" id="staticBackdropLabel">{{$college}} Review</h5>
												  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													<div class="mb-3">
														<div class="row">
															<div class="col-md-6">
																<div class="row">
																	<div class="col-md-6"><b>Reviewd By:</b></div>
																	<div class="col-md-6"><p>{{$sop->review_by}}</p></div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="row">
																	<div class="col-md-6"><b>Review Date</b></div>
																	<div class="col-md-6"><p>{{date('d M, Y',strtotime($sop->review_date))}}</p></div>
																</div>
															</div>
															<div class="col-md-12"><b>Review</b></div>
															<div class="col-md-12"><p>{{$sop->review}}</p></div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
												  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
												</div>
											  </div>
											</div>
										  </div>
										
									</div>
									@endif
									<div class="col-auto">
										<button class="d-block w-auto ms-auto btn btn-danger btn-sm" type="button" onclick="remove_row('#college_row_{{$sop_key}}','{{$clg_id}}','{{$college}}')"><i class="bx bx-trash m-0"></i>
										</button>
									</div>
								</div>
                           </div>
                           <div class="col-lg-8">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="mb-3">
                                       <label for="" class="form-label">College Name <span style="color:red;">*</span></label>
									   <p class="form-control">{{$college}}</p>
                                       <input type="hidden" name="sop[{{$sop_key}}][college]" readonly value="{{$sop->college_id}}" class="form-control">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="mb-3">
                                       <label for="" class="form-label">Upload SOP <span style="color:red;">*</span></label>
                                       <input type="file" onchange="getSopfile(this,'#sop_file_{{$sop_key}}')" class="form-control">
                                       <input type="hidden" name="sop[{{$sop_key}}][sop_file]" id="sop_file_{{$sop_key}}" value="{{$sop_file}}">
                                    </div>									
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
					@endforeach
					<div id="college_append"></div>
					<input type="hidden" value="{{route('profile.sop')}}" id="get-sop">
					@if (Auth::user()->role !='teacher' )
					<div class="row">
						<div class="col-12 d-flex justify-content-between">
							<button class="btn btn-dark" type="button" onclick="openModel('#sops-modal')"><i class="bx bx-add-to-queue"></i>Add More</button>
							<button id="sops" type="button" onclick="saveSop()" tab-next="profile_dreamcolleges" class="btn btn-primary"><i class="bx bx-cloud-upload"></i> Save</button>
						</div>
					</div>
					@endif
					<!-- model -->
					<div class="modal fade" id="sops-modal" tabindex="-1" aria-labelledby="sops" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-loader">
									<div class="spinner-grow" role="status"> <span class="visually-hidden">Loading...</span>
									</div>
								</div>
								<div class="modal-header">
									<h5 class="modal-title" id="edu-model">Please Select</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<select name="" id="edu-college-select" class="multiple-select form-control" multiple="multiple">
										{{-- {{ $college = App\Models\College::all() }}
										@foreach ($college as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach --}}

										@php
											$user_college_ids = collect($user['sop_colleges'] ?? [])->pluck('college_id')->toArray();
											$college = App\Models\College::where('created_by_user','no')->where('status','active')->get();
											@endphp
											@foreach ($college as $key => $item)
												@if(!in_array($item->id, $user_college_ids))
													<option value="{{$item->id}}">{{$item->name}}</option>
												@endif	
											@endforeach
										
									</select>
									<input type="hidden" value="{{route('profile.add-college')}}" id="add-college">
									<button class="btn-primary btn mt-3" onclick="addCollege()" data-bs-dismiss="modal" aria-label="Close">Add</button>
								</div>
							</div>
						</div>
					</div>
				</form>

				<div class="form-loader">
					<button class="btn btn-primary" type="button" disabled>
						<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Please Wait...
					</button>
					<div class="bg-warning mt-4 p-1 text-capitalize">Don’t close window or refresh </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js_plugin')
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
@endsection

@section('script')
<script src="{{asset('assets/js/sop.js')}}"></script>
@endsection