@extends('layout')
@section('title','Profile Review')

@section('css_plugin')
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
@endsection

@section('page_css')
    <link rel="stylesheet" href="{{asset('assets/css/profile.css')}}">
@endsection

@section('breadcrumb')
<div class="page-breadcrumb d-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Profile</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">   @if (Auth::user()->role=="student")
                    <a href="{{route('profile.view')}}"><i class="bx bx-home-alt"></i></a>
                 @else
                    <a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                 @endif
                </li>
                <li class="breadcrumb-item active" aria-current="page">Review</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <div class="row gy-2 mx-0">
                <div class="col-sm-6 ">
                    <div class="h6">Profile Reviewed by</div>
                    <div>
                        John Doe
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="h6">Profile Review Date</div>
                    <div>
                        10 January 2021
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
                        <div class="col-md-6 py-2">
                            <div class="h6 mb-0">Overall Profile (Application form/Resume)</div>
                        </div>
                        <div class="col-md-6 py-2">
                            <div class="star-review">
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-md-6 py-2">
                            <div class="h6 mb-0">Academic Profile</div>
                        </div>
                        <div class="col-md-6 py-2">
                            <div class="star-review">
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-md-6 py-2">
                            <div class="h6 mb-0">Co-Curricular Profile</div>
                        </div>
                        <div class="col-md-6 py-2">
                            <div class="star-review">
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-md-6 py-2">
                            <div class="h6 mb-0">Extra-Curricular Profile</div>
                        </div>
                        <div class="col-md-6 py-2">
                            <div class="star-review">
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-md-6 py-2">
                            <div class="h6 mb-0">NGO Experience</div>
                        </div>
                        <div class="col-md-6 py-2">
                            <div class="star-review">
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-md-6 py-2">
                            <div class="h6 mb-0">Leadership</div>
                        </div>
                        <div class="col-md-6 py-2">
                            <div class="star-review">
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-md-6 py-2">
                            <div class="h6 mb-0">Work Experience</div>
                        </div>
                        <div class="col-md-6 py-2">
                            <div class="star-review">
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star active"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                                <span class="star"><i class="lni lni-star-filled"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-md-6 py-2 align-self-start">
                            <div class="h6 mb-0">Profile Comments & Recommendations</div>
                        </div>
                        <div class="col-md-6 py-2">
                            <div class="border p-3">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel voluptatem, sed odio iure ducimus fugiat molestias numquam reprehenderit nostrum architecto minima earum cum quo aut facere nemo voluptate eligendi sequi animi tempore debitis. Sunt aliquid iusto unde possimus, impedit perspiciatis, neque fugiat ducimus soluta temporibus corporis dolore? Consequuntur optio in, ut corrupti amet eum ullam repellat pariatur vitae quas asperiores hic consectetur voluptas eveniet. Error quisquam sit quidem quibusdam ab voluptates? Aliquam saepe consequatur perferendis optio amet cum, in inventore illum qui error, at corrupti quo recusandae magnam consequuntur id? Quos dolorum molestiae doloremque sapiente velit, veniam ducimus omnis libero sunt tempora suscipit distinctio laborum quae ipsa et, accusamus fugiat magni facilis dicta qui tempore, quis placeat eligendi. Voluptatibus nihil aliquid, dicta dolorem quis enim eaque amet modi inventore ullam labore, voluptatem unde, odit repellat eius voluptatum adipisci quia ipsam possimus ut officiis ad quidem? Ratione magnam libero non laborum!
                            </div>
                        </div>
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
<script>

</script>
@endsection