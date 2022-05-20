@extends('layout')
@section('title','Users')

@section('css_plugin')
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-vue@2.21.2/dist/bootstrap-vue.css">
@endsection

@section('page_css')
    <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
    <link rel="stylesheet" href="{{asset('assets/css/admin/users.css')}}">
    <style>
        .accordion-body{
            padding: 1rem 0.75rem;
        }
        .accordion-button{
            font-size: 0.8rem;
            border-radius: 5px;
        }

    </style>
    <style scoped>
        /* .b-avatar {
            height: 5.5rem;
            width: 5.5rem;
            border-radius:0 !important;
        } */
    </style>
@endsection

@section('breadcrumb')
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Home</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Profiles</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('main_content')
    <div class="card">
        <div id="app" class="card-body d-none">
            <b-row>
                <b-col cols="auto">
                    <div class="d-flex align-items-center">
                        <label class="d-inline-block col-auto text-sm-start me-3">Per page</label>
                        <b-form-select id="perPageSelect" v-model="perPage" :options="perPageOptions" class="form-select"></b-form-select>
                        <label class="d-inline-block col-auto text-sm-start me-3">&nbsp;/ @{{ total }}</label>
                    </div>
                </b-col>
                <b-col cols>
                    <b-form action="#">
                        <b-input-group>
                            <b-form-input v-model="filters['name']" placeholder="Search By Name/Email"></b-form-input>
                            <b-input-group-append class="bg-primary-2 px-3 py -2 text-white">
                                <i class="bx bx-search" style="margin-top: 10px;"></i>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form>
                </b-col>
                <b-col cols="auto">
                    
                    <button style="border-bottom-width:1px" class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Filters
                    </button>
                </b-col>
            </b-row>

            {{-- Filters Start --}}
            <div class="accordion" id="filters">
                <div class="accordion-item">
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#filters">
                        <div class="accordion-body">
                            <b-form action="#" class="row mt-3">
                                @csrf
                                <div class=" mx-auto">
                                    <div class="row">
                                        <div class="col-12">
                                            <b-row class="row align-items-center bg-light mb-3 py-3 shadow-sm border gy-3">
                                                <b-col cols="12" class="d-flex">
                                                    <div class="h6 me-3 col-auto align-self-center mb-0">Profile Updated:</div>
                                                    <input v-model="filters['profile_update_from']" type="date" class="form-control">
                                                    <input v-model="filters['profile_update_to']" type="date" class="form-control ms-3">
                                                </b-col>
                                                <b-col md="4">
                                                    <v-select
                                                        v-model="filters['dream_colleges']"
                                                        :options="colleges"
                                                        label="name"
                                                        placeholder="Dream Colleges"
                                                        class="form-select"
                                                        taggable
                                                        push-tags
                                                        multiple
                                                        :reduce="option => option.id"
                                                    ></v-select>
                                                </b-col>
                                                <b-col md="4">
                                                    <v-select
                                                        v-model="filters['received_call_colleges']"
                                                        :options="colleges"
                                                        label="name"
                                                        placeholder="Calls Received"
                                                        class="form-select"
                                                        taggable
                                                        push-tags
                                                        multiple
                                                        :reduce="option => option.id"
                                                    ></v-select>
                                                </b-col>
                                                <b-col md="4">
                                                    <v-select
                                                        v-model="filters['converted_call_colleges']"
                                                        :options="colleges"
                                                        label="name"
                                                        placeholder="Converted Calls"
                                                        class="form-select"
                                                        taggable
                                                        push-tags
                                                        multiple
                                                        :reduce="option => option.id"
                                                    ></v-select>
                                                </b-col>
                                                <b-col md="4" cols="6" class="d-flex">
                                                    <v-select
                                                        v-model="filters['states']"
                                                        :options="states"
                                                        label="name"
                                                        placeholder="States"
                                                        class="form-select"
                                                        taggable
                                                        push-tags
                                                        multiple
                                                        :reduce="option => option.id"
                                                    ></v-select>
                                                </b-col>
                                                <b-col md="2" cols="6" class="d-flex">
                                                    <v-select
                                                        v-model="filters['sop_college']"
                                                        :options="colleges"
                                                        label="name"
                                                        placeholder="SOPs"
                                                        class="form-select"
                                                        :clearable="true"
                                                        :reduce="option => option.id"
                                                    ></v-select>
                                                </b-col>
                                                <b-col md="3">
                                                    <div class="h6 mt-3">SOP Reviewed?</div>
                                                    <div class="form-check form-check-inline">
                                                        <input v-model="filters['sop_reviewed']" class="form-check-input" type="radio" name="sop_reviewed" id="isSOPR1" value="yes">
                                                        <label class="form-check-label" for="isSOPR1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input v-model="filters['sop_reviewed']" class="form-check-input" type="radio" name="sop_reviewed" id="isSOPR2" value="no">
                                                        <label class="form-check-label" for="isSOPR2">No</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input v-model="filters['sop_reviewed']" class="form-check-input" type="radio" name="sop_reviewed" id="isSOPR3" value="both">
                                                        <label class="form-check-label" for="isSOPR3">All</label>
                                                    </div>
                                                </b-col>
                                                <b-col md="3">
                                                    <div class="h6 mt-3">CATKing Student?</div>
                                                    <div class="form-check form-check-inline">
                                                        <input v-model="filters['is_catking_student']" class="form-check-input" type="radio" name="is_catking_student" id="isCKS1" value="yes">
                                                        <label class="form-check-label" for="isCKS1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input v-model="filters['is_catking_student']" class="form-check-input" type="radio" name="is_catking_student" id="isCKS2" value="no">
                                                        <label class="form-check-label" for="isCKS2">No</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input v-model="filters['is_catking_student']" class="form-check-input" type="radio" name="is_catking_student" id="isCKS3" value="both">
                                                        <label class="form-check-label" for="isCKS3">All</label>
                                                    </div>
                                                </b-col>
                                                <b-col cols="12">
                                                    <b-row v-for="(exam, index) in filters['exams']" :key="`ex-${index}`" class="border-top pt-2">
                                                        <b-col md="8">
                                                            <b-row>
                                                                <b-col>
                                                                    <v-select
                                                                        v-model="exam['name']"
                                                                        :options="exams"
                                                                        label="name"
                                                                        placeholder="Exam"
                                                                        class="form-select"
                                                                        :reduce="option => option.name"
                                                                    ></v-select>
                                                                </b-col>
                                                                <b-col>
                                                                    <input v-model="exam['score_from']" type="number" placeholder="Score From" class="form-control">
                                                                </b-col>
                                                            </b-row>
                                                            <b-row class="mt-3">
                                                                <b-col>
                                                                    <input v-model="exam['percentile_from']" type="number" placeholder="Percentile From" class="form-control">
                                                                </b-col>
                                                                <b-col>
                                                                    <input v-model="exam['percentile_to']" type="number" placeholder="Percentile To" class="form-control">
                                                                </b-col>
                                                            </b-row>
                                                        </b-col>
                                                        <b-col md="4">
                                                            <input v-model="exam['score_to']" type="number" placeholder="Score To" class="form-control">
                                                            <div class="h6 mt-3">Exam Attempt?</div>
                                                            <div class="form-check form-check-inline">
                                                                <input v-model="exam['attempted']" class="form-check-input" type="radio" name="attempted" id="isEA1" value="yes">
                                                                <label class="form-check-label" for="isEA1">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input v-model="exam['attempted']" class="form-check-input" type="radio" name="attempted" id="isEA2" value="no">
                                                                <label class="form-check-label" for="isEA2">No</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input v-model="exam['attempted']" class="form-check-input" type="radio" name="attempted" id="isEA3" value="both">
                                                                <label class="form-check-label" for="isEA3">All</label>
                                                            </div>
                                                            <button @click.prevent="removeExamFilter(exam, index)" type="button" class="btn btn-outline-danger btn-sm float-end" style="right: 0;top: -20px;position: relative;">Remove</button>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row class="mt-2">
                                                        <b-col md="6">
                                                            <button @click.prevent="addExamFilter" type="button" class="btn btn-dark btn-sm mb-3">Add Exams</button>
                                                        </b-col>
                                                        <b-col md="6" class="text-center text-md-end">
                                                            <button @click.prevent="show_info = !show_info" type="button" class="btn btn-outline-secondary btn-sm">@{{ show_info ? 'Hide': 'Show' }} Info</button>
                                                            <button type="button" class="btn btn-outline-secondary btn-sm"  @click.prevent="resetFilters">Reset Filters</button>
                                                            {{-- <button type="button" class="btn btn-primary btn-sm">Apply Filters</button> --}}
                                                        </b-col>
                                                    </b-row>
                                                </b-col>
                                            </b-row>
                                        </div>
                                    </div>
                                </div>
                            </b-form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Filters Ends --}}

            {{-- Data Table start --}}
            <b-row class="mt-4">
                <b-col cols="12" id="table-container">
                    <b-table
                        ref="refListTable"
                        class="position-relative overflow-hidden"
                        :items="getTableData"
                        responsive
                        :fields="fields"
                        primary-key="id"
                        :sort-by.sync="sortBy"
                        :sort-desc.sync="sortDesc"
                        show-empty
                        empty-text="No matching records found"
                        
                    >
                        <template #cell(name)="data">
                            <b-avatar :src="data.item.avatar" size="50"></b-avatar>
                            <a :href="'{{ route("admin.user-view", "___") }}'.replace('___', data.item.id)" target="_blank"><strong>&nbsp;@{{ data.item.name }}</strong></a>
                        </template>
                        <template #cell(email)="data">@{{ show_info? data.value: (String(data.value).replace(/^(.)(.*)(.@.*)$/, (_, a, b, c) => a + b.replace(/./g, '*') + c)) }}</template>
                        <template #cell(mobile_number)="data">@{{ show_info? data.value: (String(data.value).substring(0, 5)+"XXXXX") }}</template>
                        <template #cell(dream_colleges)="data">@{{ getArrayValues(data.item.dream_colleges, "college_name") }}</template>sopReview
                        <template #cell(received_call_colleges)="data">@{{ getArrayValues(data.item.received_call_colleges, "college_name") }}</template>
                        <template #cell(converted_call_colleges)="data">@{{ getArrayValues(data.item.converted_call_colleges, "college_name") }}</template>
                        <template #cell(sop_college)="data">
                            <div v-if="getFilteredSopCollege(data.item.sop_colleges)">
                                @{{ getFilteredSopCollege(data.item.sop_colleges).review ? 'Yes': 'No' }}
                                <a v-if="getFilteredSopCollege(data.item.sop_colleges).file_link" class="btn btn-sm btn-primary ms-auto" :href="getFilteredSopCollege(data.item.sop_colleges).file_link" target="_blank"><i class="bx bx-show m-0" style="line-height: 0"></i></a>
                                <b-button
                                    v-if='getFilteredSopCollege(data.item.sop_colleges).file_link'
                                    @click.prevent="showSopReviewDetail(getFilteredSopCollege(data.item.sop_colleges).id)"
                                    class="btn btn-sm ms-auto"
                                    ref="btnShow"
                                    :class="getFilteredSopCollege(data.item.sop_colleges).review || review==true ? 'btn-warning':'btn-primary'"><i class="bx bx-star m-0" style="line-height: 0"></i></b-button>
                                <b-button
                                    v-show="getFilteredSopCollege(data.item.sop_colleges).review || show==true"
                                    @click.prevent="sendSopReviewMail(getFilteredSopCollege(data.item.sop_colleges).id)"
                                    class="btn btn-sm btn-dark ms-auto"><i class="bx bx-mail-send m-0" style="line-height: 0" :id="'mail' + getFilteredSopCollege(data.item.sop_colleges).id"></i></b-button>
                            </div>
                            <div v-else>No</div>
                        </template>
                        <template #cell(action)="data">
                            <div class="d-flex align-items-center">
                                <a :href="'{{ route("admin.user-view", "___") }}'.replace('___', data.item.id)" target="_blank" class="btn btn-sm btn-primary ms-auto"><i class="bx bx-show m-0" style="line-height: 0"></i></a>
                            </div>
                        </template>
                        <template #cell()="data">
                            @{{ getFormattedValue(data) }}
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

            <b-modal id="modal-1" title="SOP Review" :hide-footer=true>
                <b-form>
                    <b-row>
                        <b-col>
                            <b-form-group
                            id="input-group-1"
                            label="Reviewed By"
                            label-for="input-1"
                            >
                            <b-form-input
                                id="input-1"
                                type="text"
                                placeholder=""
                                required
                                v-model="modal_data.review_by"
                            >
                            </b-form-input>
                            </b-form-group>

                        </b-col>

                            <b-form-group
                            id="input-group-3"
                            label-for="input-3"
                            >
                            <b-form-input :hidden=true
                                id="input-3"
                                type="text"
                                placeholder=""
                                required
                                v-model="modal_data.id"
                            >
                            </b-form-input>
                            </b-form-group>
                        <b-col>
                            <b-form-group
                            id="input-group-2"
                            label="Review Date"
                            label-for="input-2"
                            >
                            <b-form-input
                                id="input-2"
                                type="date"
                                placeholder=""
                                required
                                v-model="modal_data.review_date"
                            >
                            </b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row class="mt-3">
                        <b-form-group
                        id="input-group-3"
                        label="Review"
                        label-for="input-3"
                        >
                        <b-form-textarea
                            id="input-3"
                            placeholder=""
                            required
                            v-model="modal_data.review"
                            style="height:250px;"
                        >
                        </b-form-textarea>
                        </b-form-group>
                    </b-row>
                    <hr>
                    <b-button class="btn btn-sm mt-3" @click.prevent="sopReview()">
                        Submit
                    </b-button>
                </b-form>
            </b-modal>
            {{-- Data Table Ends --}}
        </div>
    </div>
@endsection

@section('js_plugin')
    <script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
    <script src="https://unpkg.com/babel-polyfill/dist/polyfill.min.js"></script>
    <script src="https://unpkg.com/vue@2.6.12/dist/vue.js"></script>
    <script src="https://unpkg.com/bootstrap-vue@2.21.2/dist/bootstrap-vue.js"></script>
    <script src="https://unpkg.com/bootstrap-vue@2.21.2/dist/bootstrap-vue-icons.js"></script>
    <script src="https://unpkg.com/vue-select@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/Draggable.min.js"></script>

@endsection

@section('script')
    <script>
        window.onload = function () {
            document.getElementById('app').classList.remove('d-none')
        }
        const VueSelect = window.VueSelect;

        Vue.component('v-select', VueSelect.VueSelect)

        new Vue({
            el: "#app",
            data() {
                return {
                    filters: {
                        name: '',
                        profile_update_from: '',
                        profile_update_to: '',
                        dream_colleges: [],
                        received_call_colleges: [],
                        converted_call_colleges: [],
                        sop_college: null,
                        sop_reviewed: 'both',
                        states: [],
                        is_catking_student: 'both',
                        exams: [],
                    },
                    blankExamFilter: {
                        name: '',
                        score_to: '',
                        score_from: '',
                        percentile_from: '',
                        percentile_to: '',
                        attempted: '',
                    },
                    perPage: 10,
                    currentPage: 1,
                    perPageOptions: [10, 25, 50, 100],
                    sortBy: 'id',
                    sortDesc: false,
                    total: 0,
                    loaded: false,
                    fields: [],
                    colleges: [],
                    states: [],
                    exams: [],
                    is_default_load: true,
                    default_filters: {!! json_encode(\App\Models\User::DEFAULT_FILTERS) !!},
                    default_college: 17,
                    default_college_name: "SP Jain",
                    show_info: false,
                    modal_data:[],
                    show:false,
                    review:false,
                };
            },
            computed: {
                filtersWatcher(){
                    return JSON.stringify([this.currentPage, this.perPage, this.filters]);
                },
                dataMeta(){
                    const localItemsCount = this.$refs.refListTable ? this.$refs.refListTable.localItems.length : 0
                    return {
                        from: this.perPage * (this.currentPage - 1) + (localItemsCount ? 1 : 0),
                        to: this.perPage * (this.currentPage - 1) + localItemsCount,
                        of: this.total,
                    }
                }
            },
            watch: {
                filters: {
                    handler: function (oldVal, newVal) {
                        this.is_default_load = false;
                    },
                    deep: true
                },
                filtersWatcher: function (oldVal, newVal) {
                    this.sortBy = 'id';
                    this.refreshData();
                }
            },
            created(){
                this.fetchColleges()
                this.fetchStates()
                this.fetchExams()
            },
            methods: {
                
                filterItem(data, key, value){
                    // console.log(data, key, value);
                    let result = false;
                    data.filter((x) => {
                        if(x[key] == value){
                            // console.log(x, key, value, x[key]);
                            result = x;
                        }
                    });
                    return result;
                    // USE OF THIS :value="$root.filterItem(rolesAll, 'id', item.gen_default_user_role).title"
                },
                getArrayValues(data, key, unique = true, joinBy = ", "){
                    let result = data.map(c => c[key]);
                    if(unique){
                        result = result.filter((v, i, a) => a.indexOf(v) === i);
                    }
                    if(typeof joinBy === "string"){
                        result = result.join(joinBy);
                    }
                    return result;
                },
                getFormattedValue(data){
                    let val = String(data.field.key).split('.').reduce(this.dotToObj, data.item)
                    if(val){
                        return val;
                    }
                    return data.value;
                },
                dotToObj(obj,i) {return obj[i]},
                fetchExams(){
                    fetch("{{ route('api.admin.get-exams') }}")
                        .then(response => response.json())
                        .then((response) => {
                            this.exams = response
                        })
                },
                fetchColleges(){
                    fetch("{{ route('api.admin.get-colleges') }}")
                        .then(response => response.json())
                        .then((response) => {
                            this.colleges = response
                        })
                },
                fetchStates(){
                    fetch("{{ route('api.admin.get-states') }}")
                        .then(response => response.json())
                        .then((response) => {
                            this.states = response
                        })
                },
                refreshData(){
                    this.$refs.refListTable.refresh()
                },
                getTableData(ctx, callback) {
                    $.ajax({
                        url: "{{ route('api.admin.get-users-table-data') }}",
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        data: JSON.stringify({
                            is_default_load: this.is_default_load,
                            filters: this.filters,
                            length: this.perPage,
                            page: this.currentPage,
                            column: this.sortBy,
                            dir: this.sortDesc ? 'desc' : 'asc',
                        })

                    })
                        .done(response => {
                            const { data, meta, columns } = response
                            callback(data)
                            this.total = meta.total
                            //console.log(response)
                            this.fields = columns
                        } );
                },
                addExamFilter(){
                    this.filters['exams'].push(JSON.parse(JSON.stringify(this.blankExamFilter)))
                },
                removeExamFilter(_exam, _index){
                    const exams = JSON.parse(JSON.stringify(this.filters['exams']));
                    const newExams = [];
                    exams.map((exam, index) => {
                        if(index !== _index){
                            newExams.push(exam)
                        }
                    })
                    this.filters['exams'] = newExams;
                },
                showSopReviewDetail(id){
                    $.ajax({
                        url: "{{ route('api.admin.get-users-sop-data') }}",
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        data: JSON.stringify({
                            id
                        })
                    })
                    .done(response => {
                        if(response[0] !==  undefined){
                            this.modal_data = response[0];
                            // console.log(this.modal_data);
                        }else{
                            this.modal_data = [];
                        }
                    } );

                    this.$root.$emit('bv::show::modal', 'modal-1', '#btnShow')
                },
                sopReview(){
                    $.ajax({
                        url: "{{ route('api.admin.sop-review') }}",
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        data: JSON.stringify({
                            modal_data:this.modal_data
                        })
                    })
                    .done(response => {
                        this.$root.$emit('bv::hide::modal', 'modal-1', '#btnShow')
                        this.show=true;
                        this.review=true;
                        successMessage(response.message);
                    });
                },
                sendSopReviewMail(id){
                    $.ajax({
                        url: "{{ route('api.admin.sop-mail') }}",
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        data: JSON.stringify({
                           id
                        })
                    })
                    .done(response => {
                        successMessage(response.message);
                    });
                },
                getSelectedSopCollegeId(){
                    return this.filters.sop_college?this.filters.sop_college:this.default_college;
                },
                getFilteredSopCollege(sop_colleges){
                    return this.filterItem(sop_colleges, 'college_id', this.getSelectedSopCollegeId());
                },
                resetFilters(){
                    this.filters.name= '';
                    this.filters.profile_update_from= '';
                    this.filters.profile_update_to= '';
                    this.filters.dream_colleges= [];
                    this.filters.received_call_colleges= [];
                    this.filters.converted_call_colleges= [];
                    this.filters.sop_college= null;
                    this.filters.sop_reviewed= 'both';
                    this.filters.states= [];
                    this.filters.is_catking_student= 'both';
                    this.filters.exams= [];
                },
            },
            
        });

    </script>
    <script>
        gsap.registerPlugin(Draggable);
        Draggable.create('#table-container .table-responsive table',{
            bounds:document.getElementById('table-container'),
            type:'x',
            //autoScroll:1,
        })
    </script>
@endsection

