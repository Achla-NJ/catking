@extends('layout')
@section('title','Exams')

@section('css_plugin')
<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
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
					<li class="breadcrumb-item active" aria-current="page">Exam</li>
				</ol>
			</nav>
		</div>
	</div>

	<div class="modal fade" id="add-exam" tabindex="-1" aria-labelledby="add-exam" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-loader">
					<div class="spinner-grow" role="status"> <span class="visually-hidden">Loading...</span>
					</div>
				</div>
				<div class="modal-header">
					<h5 class="modal-title">Add Exam</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{route('admin.insert-exam')}}" id="add-exam-form" onsubmit="return false;">
						@csrf
						<div class="col-md-12">
							<div class="mb-3">
								<label for="name" class="form-label">Name</label>
								<input type="text" name="name" id="name" class="form-control" value="">
							</div>
						</div>
						<button class="btn-primary btn mt-3" type="button" onclick="addExam()" data-bs-dismiss="modal" aria-label="Close">Add</button>
					</form>
				</div>
			</div>
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
				<div class="row">
					<div class="col-md-10 col-6">
						<div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
							Exam List
						</div>
					</div>
					<div class="col-md-2 col-6">
						<button type="button" class="btn btn-dark" onclick="openModel('#add-college')"><i class="bx bx-add-to-queue"></i>Add More
						</button>
					</div>
				</div>
				
				<div class="col-lg-12 mx-auto">
					<div class="row">
						<div class="table-responsive">
							<table class="table b-table table-striped table-bordered" id="example">
								<thead class="table-dark">
									<tr>
										<th style="width:20%;">Sr No.</th>
										<th style="width:20%;">Name</th>
										<th style="width:20%;">Count of students appearing for the exam</th>
										<th style="width:20%;">Status(Active/Inactive)</th>
										<th style="width:20%;">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($exams as $exam)
										<tr>
											<td>{{ $loop->iteration }}</td>
											<td>{{$exam->name}}</td>
											<td>
												@php 	
													$exam_data=App\Models\StudentExam::query()->where('type',$exam->name)->get(); 
													echo count($exam_data);
												@endphp
											</td>
											<td>
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="status{{$exam->id}}" {{($exam->status == 'active') ? 'checked': ''}} onchange="statusChange('{{$exam->id}}')">
												</div>
											</td>
											
											<td>
												<button type="button" class="btn btn-dark btn-sm shadow-sm" onclick="editModel('#edit-exam','{{$exam->id}}')" ><i class="bx bx-edit m-0"></i> </button>
												</form>
												<a href="{{route('admin.delete-exam',$exam->id)}}" class="btn btn-danger btn-sm"  onclick="return confirm('You want to delete this item?')" ><i class="bx bx-trash m-0"></i></a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
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
<div class="modal fade" id="edit-exam" tabindex="-1" aria-labelledby="edit-exam" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-loader">
				<div class="spinner-grow" role="status"> <span class="visually-hidden">Loading...</span>
				</div>
			</div>
			<div class="modal-header">
				<h5 class="modal-title" >Update Exam</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('admin.update-exam')}}" id="edit-exam-form" onsubmit="return false;">
					@csrf
					<div class="col-md-12">
						<div class="mb-3">
							<label for="name" class="form-label">Name</label>
							<input type="text" name="name" id="edit-name" class="form-control" value="">
							<input type="hidden" name="id" id="edit-id" >
						</div>
					</div>
					<button class="btn-primary btn mt-3" type="button" onclick="editExam()" data-bs-dismiss="modal" aria-label="Close">Update</button>
				</form>
			</div>
		</div>
	</div>
</div>

@section('js_plugin')
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
@endsection

@section('script')
<script>
	function openModel(model) {
		$(model).modal('show');
    }

	function addExam(){
		var addexam = document.getElementById('add-exam-form');
		var fd = new FormData(addexam);
		var url = addexam.action;   
		$.ajax({
			type: "post",
			url,
			data: fd,
			contentType: false,
			processData: false,
			dataType: "json",
			cache:"false",
			beforeSend: function() {
				$(".form-loader").addClass('show');
				$('body').addClass('overflow-hidden');     
			},
			success:function(response){                                              
				$(".form-loader").removeClass('show');  
				$('body').removeClass('overflow-hidden'); 
				successMessage(response.message); 
				location.reload();                                             
			},
			error:function(response){
				$(".form-loader").removeClass('show');
				$('body').removeClass('overflow-hidden');
				failMessage(response.responseJSON.message)
			}                                                
		});
	}

	function editModel(model,id) {
		$.ajax({
			type: "get",
			url:"{{route('admin.get-exam')}}",
			data: {
				id
			},
			success:function(response){    
				$("#edit-name").val(response.data.name)
				$("#edit-id").val(response.data.id)
				console.log(response.data);
			}                                              
		});
		$(model).modal('show');
    }
	
	function editExam(){
		var editexam = document.getElementById('edit-exam-form');
		var fd = new FormData(editexam);
		var url = editexam.action;   
		$.ajax({
			type: "post",
			url,
			data: fd,
			contentType: false,
			processData: false,
			dataType: "json",
			cache:"false",
			beforeSend: function() {
				$(".form-loader").addClass('show');
				$('body').addClass('overflow-hidden');     
			},
			success:function(response){                                              
				$(".form-loader").removeClass('show');  
				$('body').removeClass('overflow-hidden'); 
				successMessage(response.message);  
				location.reload();                                              
			},
			error:function(response){
				$(".form-loader").removeClass('show');
				$('body').removeClass('overflow-hidden');
				failMessage(response.responseJSON.message)
			}                                                
		});
	}

	function statusChange(id){
		var url = "{{route('admin.exam-status')}}"; 

		var sts='';
		if($("#status"+id).is(':checked') == false){
			sts = 'deactive';
		}else{
			sts = 'active';
		}
		$.ajax({
			type: "get",
			url,
			data: {
				id,sts
			},
			beforeSend: function() {   
			},
			success:function(response){                  
				successMessage(response.message);                         
			},
			error:function(response){
				failMessage(response.responseJSON.message)
			}                                                
		});
	}


</script>
<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>t>
<script>
	$(document).ready(function() {
		$('#example').DataTable();
	} );
</script>
@endsection