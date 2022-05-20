@extends('layout')
@section('title','BroadCast Message')

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
					<li class="breadcrumb-item active" aria-current="page">Message</li>
				</ol>
			</nav>
		</div>
	</div>

	<div class="form-loader">
		<button class="btn btn-primary" type="button" disabled>
			<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Please Wait...
		</button>
		<div class="bg-warning mt-4 p-1 text-capitalize">Don’t close window or refresh </div>
	</div>
</div>
@endsection

@section('main_content')
<div class="row profile">
	<div class="col">
		<div class="card">
			<div class="card-body position-relative">
				<div class="col-12">
					<div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 pe-5">
						Message
					</div>
				</div>
				<div class="col-lg-11 mx-auto">
					<form method="post" class="row" action="{{route('admin.update-broadcast-message')}}" id="add-college">
						@csrf
						<div class="col-md-12 ">
							<div class="mb-3">
								<label for="title" class="form-label">Title</label>
								<input type="text" name="title" id="title" class="form-control" value="{{ old('title', $title) }}">
							</div>
							@if($errors->has('title'))
								<div class="error">{{ $errors->first('title') }}</div>
							@endif
						</div>
						<div class="col-12">
							<div class="mb-3">
								<label for="description" class="form-label">Description</label>
								<textarea type="text" style="height: 400px;" name="description" id="description" class="form-control" >{{ old('description', $description) }}</textarea>
							</div>
							@if($errors->has('description'))
								<div class="error">{{ $errors->first('description') }}</div>
							@endif
						</div>
						<div class="col-12">
							<div class="mb-3">
								<button class="btn-primary btn mt-3" type="submit" data-bs-dismiss="modal" aria-label="Close">Add</button>
							</div>
						</div>
						
					</form>
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
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
@endsection

@section('script')
<script>
	CKEDITOR.replace('description');
	</script>
<script>
	function openModel(model) {
		$(model).modal('show');
    }
</script>
@if(Session::has('success'))
<script>
	successMessage("{{ Session::get('success') }}")
</script>
@endif
@endsection