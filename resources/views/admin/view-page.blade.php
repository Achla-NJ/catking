@extends('layout')
@section('title',$page[0]->title)

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
					<li class="breadcrumb-item active" aria-current="page">{{$page[0]->link_text}}</li>
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
				<div class="col-lg-11 mx-auto">
					<div class="row">
					   <div class="col-12">
						  <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2">
							{{$page[0]->title}}
						  </div>
					   </div>
					</div>
					<div class="row">
						<div class="col-lg-12 mx-auto">
							<iframe src="{{route('new-page',$page[0]->id)}}" style="width:100%;height:800px;"></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection