@extends('layout')
@section('title','Pages')

@section('css_plugin')
<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
@endsection

@section('page_css')

@endsection

@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center mb-3" style="justify-content: space-between;">
	<div class="d-flex">
		<div class="breadcrumb-title pe-3">Home</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Pages</li>
				</ol>
			</nav>
		</div>
	</div>

</div>
@endsection

@section('main_content')
<div class="row profile">
	<div class="col">
		<div class="card">
			<div class="card-body position-relative">
				<div class="row">
					<div class="col-10">
						<div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2">
							College cut-offs and Interview Preparation resources
						</div>
					</div>
					<div class="col-2">
						<a href="{{route('admin.custom-page')}}" class="btn btn-dark" ><i class="bx bx-add-to-queue"></i>Add More
						</a>
					</div>
				</div>
				<div class="row">
				<div class="col-lg-12 mx-auto">
					
						<table class="table b-table table-striped table-bordered">
							<thead class="table-dark">
								<tr>
									<th>Sr No.</th>
									<th>Title</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($pages as $page)
								<tr>
									<td>{{$page->id}}</td>
									<td>{{$page->title}}</td>
									<td>
                                        <a href="{{route('view-page',$page->slug)}}" target="_blank" class="btn btn-primary btn-sm shadow-sm" ><i class="bx                                bx-link-external m-0"></i> </a>
                                        <a href="{{route('admin.get-page',$page->id)}}" class="btn btn-dark btn-sm shadow-sm" ><i class="bx bx-edit m-0"></i> </a>
                                        @if($page->id !='1')<a href="{{route('admin.delete-page',$page->id)}}" class="btn btn-danger btn-sm"  onclick="return confirm('You want to delete this item?')" ><i class="bx bx-trash m-0"></i></a>
										@else
										<span>(Fixed Page)</span>
										
										@endif
                                    </td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

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
@endsection

@section('script')
@if(Session::has('success'))
<script>
	successMessage("{{ Session::get('success') }}")
</script>
@endif
@endsection