@extends('layout') @section('title','Profile Review') @section('css_plugin')
<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
@endsection @section('page_css')
<link rel="stylesheet" href="{{asset('assets/css/profile.css')}}" />
@endsection @section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Home</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Profile Review</li>
            </ol>
        </nav>
    </div>
</div>
@endsection @section('main_content')
<div class="row">
    <div class="col-12 ">
        <div class="card">
            <div class="card-body">
            <form action="{{route('admin.search-pi-student')}}" method="post" id="search-form" onsubmit="return false;">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="keyword">Search By Email/MobileNo.</label>
                        <input type="text" class="form-control" id="search"placeholder="Enter Email/MobileNo." name="keyword" value="" />
                        <input type="hidden" class="form-control" name="type" value="profile" />
                    </div>
                    <div class="col-auto text-end my-auto">
                        <button type="button" id="search-form_btn" class="btn btn-dark" style="margin-top:15px;">Go</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card d-none" id="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 text-end mb-3">
                <button class="btn btn-dark" type="button" onclick="addMore()">Add More</button>
            </div>
        </div>
        <div class="accordion" id="accordionExample">
            <input type="hidden" name="review[student_id]" value='' id="student_id">

            <div id="accordion_append"></div>
        </div>
    </div>
</div>
@endsection @section('js_plugin')
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
@endsection @section('script')
<script>
     var inc=0;
    $("#search-form_btn").on("click", function (e) {
        e.preventDefault();
        $("#card").addClass('d-none');$("#accordion_append").html('');
        var keyword = $("#search").val();

        var searchform = document.getElementById("search-form");
        var fd = new FormData(searchform);
        var url = searchform.action;
        if(keyword === ''){
            alert('field is required');
            return false;
        }
        else{
            $("tbody").html('');
            $.ajax({
                type: "post",
                url,
                data: fd,
                contentType: false,
                processData: false,
                dataType: "json",
                cache: "false",
                success: function (response) {
                    if(response.success){
                        //  console.log(response.data.review)
                        $("#card").removeClass("d-none");
                        $("#student_id").val(response.data.user[0].id)
                        // console.log(response.data.review.length);
                        if(response.data.review.length > 0){
                            for (var i = 0; i < response.data.review.length; i++){
                                addMore(response.data.review[i].id,response.data.review[i].student_id,response.data.review[i].teacher,response.data.review[i].particulars,response.data.review[i].date,response.data.review[i].selection,response.data.review[i].type,response.data.review[i].remark,true);
                            }
                        }else{
                            addMore();
                        }
                    }
                    else{
                        failMessage(response.msg);
                    }
                },
                error: function (response) {
                    failMessage(response.responseJSON.message);
                },
            });
        }

    });

    function addMore(sid='',student_id='',teacher='',particulars='',date='',selection='',type='',remark='',haveData=false){
        inc++;
        var id = $("#student_id").val();
        // console.log(id)
        var rate_val=0;
        if(particulars !== ''){
            var attributes = JSON.parse(particulars);
        }


        var counter =Math.floor(Math.random() * 100) +15;
        var html = `
        <div class="accordion-item" id="profile_review_${counter}">
                <h2 class="accordion-header" id="headingOne${counter}">
                    <a href="javascript:void(0)" class="accordion-button col" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne${counter}">
                        Profile Review #${inc}
                    </a>
                </h2>
                <div id="collapseOne${counter}" class="accordion-collapse collapse  show aria-labelledby="headingOne${counter}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="actions mb-3 text-center text-lg-end">
                            ${haveData ? `<button class="btn btn-dark btn-sm ms-2" onclick="editInterview(event,${counter})">Edit</button>`:''} 
                            <button class="btn btn-${(sid == '') ?'dark':'warning'} btn-sm " type="button" onclick="email('${student_id}','Profile')"><i class="bx bx-mail-send"></i></button>
                        ${(sid === '') ? `<button class="btn btn-danger btn-sm" type="button" onclick="remove('#profile_review_${counter}')">X</button>`: `<button class="btn btn-danger btn-sm" type="button" onclick="deleterow('${sid}', '#profile_review_${counter}')">X</button>`}
                        
                        </div>
                        <form action="{{route('admin.store-pi-review')}}" method="post"  id="form${counter}">
                            @csrf
                            <input type="hidden" name="url" value="admin.profile-review">
                            <input type="hidden" name="review[student_id]" value="${student_id}" class="student_id">
                            <input type="hidden" name="review[id]" value="${sid}">
                            <div class="row gy-2 mx-0">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="h6 col-12">Profile Reviewed by</div>
                                        <div class="col-md-6">
                                            <input type="text" name="review[teacher]" id="review" required class="form-control" value="${teacher}"/>
                                            <input type="hidden" name="review[type]" class="form-control" value="profile" value="${type}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="h6 col-12"><label for="pi-date">Profile Review Date</label></div>
                                        <div class="col-md-6">
                                            <input type="date" for="pi-date"  id="date" required name="review[date]" class="form-control" value="${date}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3 bg-primary-4 mx-0 py-2">
                                <div class="col-sm-6">
                                    <div class="h6 m-0">Particulars</div>
                                </div>
                                <div class="col-sm-6 d-none d-sm-flex">
                                    <div class="h6 m-0">Ratings</div>
                                </div>
                            </div>
                            <div class="row mx-0 gy-2 star-col border">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        @php $profile_attr = App\Models\Attribute::query()->where('type','profile')->get(); @endphp
                                            @foreach ($profile_attr as $index=>$profile)
                                            <div class="col-12">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6 py-2">
                                                        <div class="h6 mb-0">{{$profile->attribute}}</div>
                                                    </div>
                                                    <div class="col-md-3 py-2 ">
                                                        <input type="hidden" name="review[attribute][]" value='{{$profile->attribute}}'>

                                                        `
                                                            for (var key in attributes)
                                                            {
                                                                rating = attributes[key];

                                                                if(rating.name == "{{$profile->attribute}}") { rate_val = rating.value; }
                                                            }
                                                            function rating(elem,id){
                                                                var rating = $(elem).val();
                                                                $(id).html(rating);
                                                            }

                                                        html +=    `<input type="range" name="review[rating][]" class="form-range" id="slider{{$index}}${counter}" oninput="rating('#slider{{$index}}${counter}','#show{{$index}}${counter}')" min="0" max="5" step="1" value="${rate_val}" />
                                                    </div>
                                                    <div class="col-md-2 py-2 ">
                                                        <span id="show{{$index}}${counter}">${rate_val}</span><span> of 5</span>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="review[selection]" value="" >
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 py-2 align-self-start">
                                            <div class="h6 mb-0">Profile Comments & Recommendations</div>
                                        </div>
                                        <div class="col-md-6 py-2">
                                            <textarea class="form-control" name="review[remark]">${(remark == null ? '':remark)}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 text-md-end mt-3">
                                <button type="button" onclick="savePInterview('${counter}')" class="btn btn-primary" >Save<span id="save_load"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
        $("#accordion_append").append(html);
        $(".student_id").val(id);
    }
    function rating(elem,id){
        var rating = $(elem).val();
        $(id).html(rating);
    }
    function remove(id){
        $(id).remove();
    }
    function savePInterview(id){
        if($("#review").val() == ''){
            $("#review").focus();
            failMessage('Reviewed By Filed is required ');
            return false;
        }
        if($("#date").val() == ''){
            $("#date").focus();

            failMessage('Date Filed is required ');
            return false;
        }
        var url = "{{route('admin.store-pi-review')}}";
        
        var scoreCard = new FormData(document.getElementById('form'+id));
        var token = $("input[name='_token']").val();
        
        scoreCard.append('_token',token);
        console.log(scoreCard)
        $.ajax({
            type: "post",
            url,
            data: scoreCard,
            contentType: false,
            processData: false,
            dataType: "json",
            cache:"false",
            beforeSend: function() {
                $("#save_load").html("<img src='{{asset('assets/images/loading.gif')}}' style='height: 25px;'>");
            },
            success:function(response){ 
                console.log(response.url);
                                                            
                successMessage(response.message);   
                $("#save_load").html("");                                         
            },
            error:function(response){
                let errors = Object.values(response.responseJSON.errors);
                    errors.map((er)=>{
                        failMessage(er)
                    });
            }
            
        });
    }
    function deleterow(id,row){
       var conf =  confirm('Are You Sure You want to delete this record?');
       if(conf){
                $.ajax({
                type: "get",
                url:"{{route('admin.delete-review')}}",
                data:{
                    id
                },
                success:function(response){
                    successMessage(response.message);
                    $(row).remove();
                }
            })
        }
    }

    function email(id,rtype){
        var id = $("#student_id").val();
        $.ajax({
            type: "get",
            url:"{{route('admin.email-review')}}",
            data:{
                id,rtype
            },
            success:function(response){
                successMessage(response.message);
            }
        })
    }

</script>
@if(Session::has('success'))
<script>
	successMessage("{{ Session::get('success') }}")
</script>
@endif
@endsection
