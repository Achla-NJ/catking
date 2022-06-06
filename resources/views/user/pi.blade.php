@extends('layout')
@section('title','Personal Interviews')

@section('css_plugin')
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
@endsection

@section('page_css')
    <link rel="stylesheet" href="{{asset('assets/css/profile.css')}}">
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
                <li class="breadcrumb-item active" aria-current="page">Personal Interviews</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('main_content')
    <div class="card">
        <div class="card-body">
            <div class="accordion" id="accordionExample">
                @php
                $count=0;
                    $review = App\Models\Review::query()->where('user_id',Auth::id())->where('type','interview')->orderBy('id','DESC')->get();
                @endphp
                @if (count($review)>0)
                    @foreach ($review as $index => $item)
                    @php
                        $count++;
                    @endphp
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$count}}" aria-expanded="true" aria-controls="collapseOne{{$count}}">
                                Personal Interview #{{$count}}
                            </button>
                            </h2>
                            <div id="collapseOne{{$count}}" class="accordion-collapse collapse {{$count==1?'show':''}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row gy-2 mx-0">
                                        <div class="col-sm-6 ">
                                            <div class="h6">Interviewer</div>
                                            <div>
                                                {{$item->teacher}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="h6">Interview Date</div>
                                            <div>
                                                {{date('d F Y',strtotime($item->date))}}
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

                                        @php
                                            $attributes = json_decode($item->particulars, true);

                                        @endphp
                                        @foreach ($attributes as  $data)
                                            <div class="col-12">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6 py-2">
                                                        <div class="h6 mb-0">{{$data['name']}}</div>
                                                    </div>
                                                    <div class="col-md-6 py-2">
                                                        <div class="star-review">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <span class="star {{$i <= $data['value'] ? 'active': ''}}">
                                                                    <i class="lni lni-star-filled"></i>
                                                                </span>
                                                            @endfor
                                                            <span class="mx-2">{{$data['value']}}</span><span> of 5</span>

                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-12">
                                            <div class="row align-items-center">
                                                <div class="col-md-6 py-2">
                                                    <div class="h6 mb-0">
                                                        Selection Status
                                                    </div>
                                                </div>
                                                <div class="col-md-6 py-2">
                                                    @if ($item->selection =='yes')
                                                        <div class="btn-sm btn-success d-inline-block">
                                                            <i class="bx bx-check m-0"></i>
                                                        </div>
                                                    @else
                                                        <div class="btn-sm btn-danger d-inline-block">
                                                            <i class="bx bx-x m-0"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row align-items-center">
                                                <div class="col-md-6 py-2 align-self-start">
                                                    <div class="h6 mb-0">Remark (if any)</div>
                                                </div>
                                                <div class="col-md-6 py-2">
                                                    <div class="border p-3 bg-body border-primary-3">
                                                        {{$item->remark}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center">
                        <div class="text-center">
                            <img src="{{asset("assets/images/nofound.webp")}}" alt="" style="max-height: 300px" >
                            <h6>No Review Yet.</h6>
                            <p>Update your My Profile section to get your profile reviewed by an expert mentor</p>
                        </div>
                        <div class="h3">
                            Get 1 additional Interview.
                        </div>
                        <a href="https://www.courses.catking.in/cart/" target="_blank" class="btn btn-primary">
                            Buy now
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
@section('js_plugin')
    <script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
@endsection

@section('script')
<script>

</script>
@endsection
