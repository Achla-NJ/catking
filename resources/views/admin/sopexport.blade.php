@extends('layout')
@section('title','SOP Export')

@section('css_plugin')
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}"  rel="stylesheet" />
@endsection

@section('page_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
    <link rel="stylesheet" href="{{asset('assets/css/admin/users.css')}}">
    <style>
        .users-export .vs__dropdown-toggle {
            border: solid black 1px !important;
        }
    </style>
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
					<li class="breadcrumb-item active" aria-current="page">Export Data</li>
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
<div class="row profile" id="app">
    <div class="col">
       <div class="card">
          <div class="card-body position-relative">
             <div class="col-12">
                <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 pe-5">
                    Export SOP Data
                </div>
             </div>
             <div class="row">
                 <div class="col-lg-11 mx-auto">
                    <form @submit.prevent="submitForm" method="post">
                       @csrf
                       <div class="mb-3 row">
                        <div class="col-md-4">
                            <label for="exampleInputEmail1" class="form-label">Select Date</label>
                            <input id="date-range" type="text" class="form-control" name="daterange">
                        </div> 
                        <div class="col-md-2">
                            <button  class="btn btn-primary btn-sm" style="margin-top:30px;">Export</button>
                        </div>
                       
                      </div>
                    </form>
                 </div>
             </div>
             
          </div>
       </div>

       <div class="card p-4">

        <b-row class="mt-4">
            <b-col cols="12">
                <b-table
                    ref="refListTable"
                    class="position-relative"
                    :items="getTableData"
                    responsive
                    :fields="fields"
                    primary-key="id"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    show-empty
                    empty-text="No matching records found"
                >
                    <template #cell(date)="data">
                        <span> @{{ dateForm(data.item.from_date)+'-'+dateForm(data.item.to_date) }} </span>
                    </template>
                    <template #cell(created_at)="data">
                        <span> @{{ dateTimeForm(data.value) }} </span>
                    </template>
                    <template #cell(download_file_link)="data">
                        <a v-if="data.value" :href="data.value" target="_blank" class="btn btn-warning btn-sm">
                            <i class="bx bx-cloud-download"></i> Download
                        </a>
                        <strong v-else>-</strong>
                    </template>
                    <template #cell(status)="data">
                        <span class="text-capitalize"> @{{data.item.status}} </span>
                    </template>
                    <template #cell(action)="data">
                        <b-button size="sm" class="btn btn-danger" @click.prevent="deleteFile(data.item.id)"><i class="bx bx-trash"></i></b-button>
                    </template>
                </b-table>
            </b-col>
            <b-col class="my-1" cols="auto">
                <div class="d-flex align-items-center">
                    <label class="d-inline-block col-auto text-sm-start me-3">Per page</label>
                    <b-form-select id="perPageSelect" v-model="perPage" :options="perPageOptions" class="form-select"></b-form-select>
                </div>
            </b-col>
            <b-col cols="auto" class="ms-auto" >
                <b-pagination v-model="currentPage" :total-rows="total" :per-page="perPage" align="center"  class="my-0"></b-pagination>
            </b-col>
        </b-row>
    </div>
    </div>
</div>
@endsection

@section('js_plugin')
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>

<script src="https://unpkg.com/babel-polyfill/dist/polyfill.min.js"></script>
<script src="https://unpkg.com/vue@2.6.12/dist/vue.js"></script>
<script src="https://unpkg.com/vue-select@latest"></script>
<script src="https://unpkg.com/bootstrap-vue@2.21.2/dist/bootstrap-vue.js"></script>
@endsection

@section('script')
<script>
	$(function() {
        $('input[name="daterange"]').daterangepicker();
    });
</script>
@if(Session::has('success'))
    <script>
        successMessage("{{ Session::get('success') }}")
    </script>
@endif
    <script>
        const VueSelect = window.VueSelect;
        window.app = new Vue({
            el: "#app",
            data() {
                return {
                    perPage: 10,
                    currentPage: 1,
                    perPageOptions: [10, 25, 50, 100],
                    sortBy: 'id',
                    sortDesc: true,
                    total: 0,
                    loaded: false,
                    fields: [
                        { key: 'id', label:"ID", sortable: true, thClass: 'table-primary' },
                        { key: 'date', label:"Date", sortable: true, thClass: 'table-primary' },
                        { key: 'created_at', label:"Download Date", sortable: true, thClass: 'table-primary' },
                        { key: 'download_file_link', label: "Download", sortable: false, thClass: 'table-primary' },
                        { key: 'status', label:"Status", sortable: false, thClass: 'table-primary' },
                        { key: 'action', label:"Action", sortable: false, thClass: 'table-primary' },
                    ],
                }
            },
            mounted(){
                
            },
            created(){
            }, 
            methods: {  
                
                getTableData(ctx, callback){
                    $.ajax({
                        url: "{{ route('api.admin.get-users-sop-export-table-data') }}",
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        data: JSON.stringify({
                            filters: this.filters,
                            length: this.perPage,
                            page: this.currentPage,
                            column: this.sortBy,
                            dir: this.sortDesc ? 'desc' : 'asc',
                        })
                    }).done(response => {
                        const { data, meta, columns } = response;
                        callback(data)
                        this.total = meta.total
                    });
                },            
                submitForm() {
                    const vue = this;
                    const $ = window.$;
                    const date = $("#date-range").daterangepicker().val();
                    $.ajax({
                        
                        url: "{{ route('api.admin.generate-users-sop-export-file') }}",
                        method: 'POST',
                        data:{
                            date,
                        },
                        dataType: 'json',
                    }).done(response => {
                            if(response.success == true){
                                vue.$refs.refListTable.refresh()
                                successMessage(response.message);
                            }else{
                                failMessage(response.message);
                            }
                    });
                },
                deleteFile(id){
                    const vue = this;
                    if(confirm('Are You Sure?')){
                        $.ajax({
                            url: "{{ route('api.admin.delete-users-sop-export-file') }}/"+id,
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            data: {id},
                        }).done(response => {
                            vue.$refs.refListTable.refresh()
                            successMessage(response.message);
                        });
                    }
                },
                dateForm(param){
                    var day =new Date(param).getDate();
                    var month =new Date(param).getMonth()+1;
                    var year =new Date(param).getFullYear();
                    return day+'/'+month+'/'+year;
                },
                dateTimeForm(param){
                    var day =new Date(param).getDate();
                    var month =new Date(param).getMonth()+1;
                    var year =new Date(param).getFullYear();
                    var hour =new Date(param).getHours();
                    var minute =new Date(param).getMinutes();
                    var format = hour >= 12 ? 'pm' : 'am';
                    return day+'/'+month+'/'+year+' '+hour+":"+minute+" "+format ;
                },
            }
        })

    </script>

@endsection
