@extends('layout')
@section('title','User Export')

@section('css_plugin')
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    {{-- <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}"  rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-vue@2.21.2/dist/bootstrap-vue.css">
@endsection

@section('page_css')
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
                        <li class="breadcrumb-item active" aria-current="page">Export Users</li>
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
    <div id="app" class="row profile users-export">
        <div class="col">
            <div class="card">
                <div class="card-body position-relative">
                    <div class="col-12">
                        <div class="border-2 border-bottom border-dark d-inline-block h4 mb-4 pb-2 ">
                            User Export Data
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-11 mx-auto">
                            <form @submit.prevent="submitForm" method="post" data-cbgrp="all">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" data-cbgrp-toggle="all">
                                                Select All
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div data-cbgrp="pi">
                                    <div class="row mb-3 bg-light p-2">
                                        <div class="col-7 col-md-4">
                                            <div class="h6">Personal Information</div>
                                        </div>
                                        <div class="col col col-md-8 text-end">
                                            <div class="form-check d-inline-block">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" data-cbgrp-toggle="pi" type="checkbox">
                                                    Select All
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 col-md">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" v-model="options.personal_info.name" disabled/>
                                                    Name
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md">
                                            <div class="form-check d-inline-block">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" v-model="options.personal_info.email" disabled/>
                                                    Email
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md">
                                            <div class="form-check d-inline-block">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" v-model="options.personal_info.mobile_number" disabled/>
                                                    Mobile Number
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md">
                                            <div class="form-check d-inline-block">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" v-model="options.personal_info.whatsapp_number"/>
                                                    Whatsapp Number
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md">
                                            <div class="form-check d-inline-block">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" v-model="options.personal_info.is_catking_student"/>
                                                    CATKing Student
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md">
                                            <div class="form-check d-inline-block">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" v-model="options.personal_info.state"/>
                                                    State
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-light p-2">
                                    <div class="col-7 col-md-4">
                                        <div class="h6">Education</div>
                                    </div>
                                    <div class="col col col-md-8 text-end">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" v-model="options.education"/>
                                                Select
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-light p-2">
                                    <div class="col-7 col-md-4">
                                        <h6>Work Experience & Internship</h6>
                                    </div>
                                    <div class="col col-md-8 text-end">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" v-model="options.work" />
                                                Select
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-light p-2">
                                    <div class="col-7 col-md-4">
                                        <h6>Co-curricular & Extra-curricular</h6>
                                    </div>
                                    <div class="col col-md-8 text-end">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" v-model="options.curricular" />
                                                Select
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-light p-2" data-cbgrp="dc">
                                    <div class="col-7 col-md-4">
                                        <h6>Dream Colleges</h6>
                                    </div>
                                    <div class="col col-md-8 mb-3 text-end">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    data-cbgrp-toggle="dc"
                                                />
                                                Select All
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <v-select
                                            ref="dream_colleges_sel"
                                            v-model="options.dream_colleges"
                                            :options="colleges"
                                            label="name"
                                            placeholder="Dream Colleges"
                                            taggable
                                            multiple
                                            :reduce="option => option.id"
                                        ></v-select>
                                    </div>
                                </div>

                               

                                <div class="row mb-3 bg-light p-2" data-cbgrp="sop">
                                    <div class="col-7 col-md-4">
                                        <h6>Exam Scores</h6>
                                    </div>
                                    <div class="col col-md-8 mb-3 text-end">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="exam" data-cbgrp-toggle="exam" />
                                                Select All
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <v-select
                                            v-model="options.exams_score"
                                            :options="exams"
                                            label="name"
                                            placeholder="Exams Scores"
                                            taggable
                                            multiple
                                            :reduce="option => option.id"
                                        ></v-select>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-light p-2" data-cbgrp="sop">
                                    <div class="col-7 col-md-4">
                                        <h6>SOPs</h6>
                                    </div>
                                    <div class="col col-md-8 mb-3 text-end">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="sop" data-cbgrp-toggle="sop" />
                                                Select All
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <v-select
                                            v-model="options.sop_colleges"
                                            :options="colleges"
                                            label="name"
                                            placeholder="SOP Colleges"
                                            taggable
                                            multiple
                                            :reduce="option => option.id"
                                        ></v-select>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-light p-2" data-cbgrp="rcc">
                                    <div class="col-7 col-md-4">
                                        <h6>Received Call Colleges</h6>
                                    </div>
                                    <div class="col col-md-8 text-end">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="received_call_colleges" data-cbgrp-toggle="rcc" />
                                                Select All
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <v-select
                                            v-model="options.received_call_colleges"
                                            :options="colleges"
                                            label="name"
                                            placeholder="Received Call Colleges"
                                            taggable
                                            multiple
                                            :reduce="option => option.id"
                                        ></v-select>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-light p-2" data-cbgrp="itd">
                                    <div class="col-7 col-md-4">
                                        <h6>Interview Dates</h6>
                                    </div>
                                    <div class="col col-md-8 mb-3 text-end">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="interview_date_colleges" data-cbgrp-toggle="itd" />
                                                Select All
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <v-select
                                            v-model="options.interview_date_colleges"
                                            :options="colleges"
                                            label="name"
                                            placeholder="Interview Date Colleges"
                                            taggable
                                            multiple
                                            :reduce="option => option.id"
                                        ></v-select>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-light p-2" data-cbgrp="ccc">
                                    <div class="col-7 col-md-4">
                                        <h6>Converted Calls</h6>
                                    </div>
                                    <div class="col col-md-8 text-end">
                                        <div class="form-check d-inline-block">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="converted_call_colleges" data-cbgrp-toggle="ccc" />
                                                Select All
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <v-select
                                            v-model="options.converted_call_colleges"
                                            :options="colleges"
                                            label="name"
                                            placeholder="Converted Call Colleges"
                                            taggable
                                            multiple
                                            :reduce="option => option.id"
                                        ></v-select>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-light p-2">
                                    <div class="col-7 col-md-4">
                                        <button class="btn btn-sm btn-dark">Export</button>
                                    </div>
                                </div>
                            </form>
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
                                <span> @{{ data.value }} </span>
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
    <script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="https://unpkg.com/babel-polyfill/dist/polyfill.min.js"></script>
    <script src="https://unpkg.com/vue@2.6.12/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-select@latest"></script>
    <script src="https://unpkg.com/bootstrap-vue@2.21.2/dist/bootstrap-vue.js"></script>
@endsection

@section('script')
    <script>
			 /*$('.multiple-select').select2({
            tags: true
        });

        function openModel(model) {
            $(model).modal('show');
        }

        function toggleCheckbox() {
        }

        function piSelect(){
            var pi_select=$('.pi_select');
            var pi_select_all=$('#pi_select_all').is(':checked');
            if(pi_select_all){
                for(var i=0; i<pi_select.length; i++){
                    if(pi_select[i].type=='checkbox')
                        pi_select[i].checked=true;
                }
            }
            else{
                for(var i=0; i<pi_select.length; i++){
                    if(pi_select[i].type=='checkbox')
                        pi_select[i].checked=false;

                }
            }

        }

        function dreamSelect(){
            var dream_select_all=$('#dream_select_all').is(':checked');
            if(dream_select_all){
                $("#dream_college > option").prop("selected", true);
                $("#dream_college").trigger("change");
            }
            else{
                $('#dream_college option').prop('selected', false);
                $("#dream_college").trigger("change");
            }
        }


        function sopSelect(){
            var sop_select_all=$('#sop_select_all').is(':checked');
            if(sop_select_all){
                $('#sop_college > option').prop('selected', true);
                $("#sop_college").trigger("change");
            }
            else{
                $('#sop_college > option').prop('selected', false);
                $("#sop_college").trigger("change");
            }
        }

        function receivedSelect(){
            var received_select_all=$('#received_select_all').is(':checked');
            if(received_select_all){
                $('#received_college > option').prop('selected', true);
                $("#received_college").trigger("change");
            }
            else{
                $('#received_college > option').prop('selected', false);
                $("#received_college").trigger("change");
            }
        }

        function interviewSelect(){
            var interview_select_all=$('#interview_select_all').is(':checked');
            if(interview_select_all){
                $('#interview_college > option').prop('selected', true);
                $("#interview_college").trigger("change");
            }
            else{
                $('#interview_college > option').prop('selected', false);
                $("#interview_college").trigger("change");
            }
        }

        function convertedSelect(){
            var converted_select_all=$('#converted_select_all').is(':checked');
            if(converted_select_all){
                $('#converted_college > option').prop('selected', true);
                $("#converted_college").trigger("change");
            }
            else{
                $('#converted_college > option').prop('selected', false);
                $("#converted_college").trigger("change");
            }
        }

        function deselect(){
            window.checkbox_selected_all = !!!window.checkbox_selected_all
            $("input[type=checkbox]").prop("checked", window.checkbox_selected_all)
            $("select > option").prop('selected', window.checkbox_selected_all);
            $("select").trigger("change");
        }*/
        @if(Session::has('success'))
            successMessage("{{ Session::get('success') }}")
        @endif

        window.onload = function () {
            document.getElementById('app').classList.remove('d-none')
        }

        const VueSelect = window.VueSelect;

        Vue.component('v-select', VueSelect.VueSelect)

        window.app = new Vue({
            el: "#app",
            data() {
                return {
                    options: {
                        personal_info: {
                            name: true,
                            email: true,
                            mobile_number: true,
                            whatsapp_number: true,
                            state: true,
                            is_catking_student: true,
                        },
                        education: false,
                        work: false,
                        curricular: false,
                        dream_colleges: [],
                        exams_score: [],
                        sop_colleges: [],
                        received_call_colleges: [],
                        interview_date_colleges: [],
                        converted_call_colleges: [],
                    },
                    colleges: [],
                    exams: [],
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
                        { key: 'download_file_link', label: "Download", sortable: false, thClass: 'table-primary' },
                        { key: 'status', label:"Status", sortable: false, thClass: 'table-primary' },
                        { key: 'action', label:"Action", sortable: false, thClass: 'table-primary' },
                    ],
                }
            },
            mounted(){
                const vue = this;
                const $ = window.$
                $(document).on('click', 'input[data-cbgrp-toggle]', function (){
                    const $this = $(this);
                    const status = !!!$this.data('cbgrp-status')
                    $this.data('cbgrp-status', status)
                    const group = $this.data('cbgrp-toggle')

                    $(`[data-cbgrp=${group}] input[type=checkbox]:not(:disabled)`)
                        .prop("checked", status)
                        .change()

                    $(`[data-cbgrp=${group}] select:not(:disabled) > option`)
                        .prop('selected', status);

                    $("select")
                        .change()
                        .trigger("change");

                    if(group === 'all'){
                        vue.options.curricular = status
                        vue.options.education = status
                        // vue.options.exams_score = status
                        vue.options.work = status
                    }

                    console.log('input[data-cbgrp-toggle]', $this, status, group)
                })

                $(document).on('change', 'input[data-cbgrp-toggle="dc"]', function (){
                    vue.options.dream_colleges = $(this).is(':checked') ? vue.colleges.map(o => o.id) : [];
                })

                $(document).on('change', 'input[data-cbgrp-toggle="sop"]', function (){
                    vue.options.sop_colleges = $(this).is(':checked') ? vue.colleges.map(o => o.id) : [];
                })
                $(document).on('change', 'input[data-cbgrp-toggle="exam"]', function (){
                    vue.options.exams_score = $(this).is(':checked') ? vue.exams.map(o => o.id) : [];
                })

                $(document).on('change', 'input[data-cbgrp-toggle="rcc"]', function (){
                    vue.options.received_call_colleges = $(this).is(':checked') ? vue.colleges.map(o => o.id) : [];
                })
                $(document).on('change', 'input[data-cbgrp-toggle="itd"]', function (){
                    vue.options.interview_date_colleges = $(this).is(':checked') ? vue.colleges.map(o => o.id) : [];
                })
                $(document).on('change', 'input[data-cbgrp-toggle="ccc"]', function (){
                    vue.options.converted_call_colleges = $(this).is(':checked') ? vue.colleges.map(o => o.id) : [];
                })
            },
            created(){
                this.fetchColleges(),
                this.fetchExams()
            },
            methods: {
                cl(...logs){
                    console.log(logs)
                },
                getTableData(ctx, callback){
                    $.ajax({
                        url: "{{ route('api.admin.get-users-export-table-data') }}",
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
                        const { data, meta, columns } = response
                        callback(data)
                        this.total = meta.total
                    });
                },
                fetchColleges(){
                    data={id:0,name:"Other"};
                    const url = new URL("{{ route('api.admin.get-colleges') }}");
                    url.searchParams.append("created_by_user", "no")
                    fetch(url.toString())
                        .then(response => response.json())
                        .then((response) => {
                            this.colleges = response
                            this.colleges.push(data);
                        })
                },
                fetchExams(){
                    data={id:0,name:"Other"};
                    const url = new URL("{{ route('api.admin.get-exams') }}");
                    
                    fetch(url.toString())
                        .then(response => response.json())
                        .then((response) => {
                            this.exams = response
                            this.exams.push(data);
                        })
                },
                submitForm() {
                    const vue = this;
                    // const options = JSON.parse(JSON.stringify(vue.options))
                    // console.log(options);
                    $.ajax({
                        url: "{{ route('api.admin.generate-users-export-file') }}",
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        data: JSON.stringify({options: vue.options}),
                        // dataType: 'json',
                    }).done(response => {
                        vue.$refs.refListTable.refresh()
                        successMessage(response.message);
                    });
                },
                deleteFile(id){
                    const vue = this;
                    if(confirm('Are You Sure?')){
                        $.ajax({
                            url: "{{ route('api.admin.delete-users-export-file') }}/"+id,
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            data: {id},
                        }).done(response => {
                            vue.$refs.refListTable.refresh()
                            successMessage(response.message);
                        });
                    }
                }
            }
        })
    </script>
@endsection
