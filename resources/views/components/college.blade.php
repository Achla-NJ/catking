@foreach ($college as $key=> $item)

@php $clg = App\Models\College::where('id',$item)->get('name');  $clg_name = $clg[0]['name']; @endphp
<div class="card sop_div" id="college_row_{{$item}}">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-12 col-xl order-xl-2">
                 <div class="row align-items-center justify-content-center">
                    <div id="sop_card{{$item}}" class="col-auto"></div>
                     <div class="col-auto">
                        <button class="d-block w-auto ms-auto btn btn-danger btn-sm"  type="button" onclick="remove_row('#college_row_{{$item}}','{{$item}}','{{$clg_name}}')"><i class="bx bx-trash m-0"></i></button>
                     </div>
                 </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                   <div class="col-md-6">
                      <div class="mb-3">
                        <label for="" class="form-label">College Name <span style="color:red;">*</span></label>
                        @php $colleges = App\Models\College::all(); @endphp
                        @foreach ($colleges as $clg)
                            @if ($clg->id == $item || $item == $clg->name)
                                <p class="form-control">{{$clg->name}}</p>
                            @endif
                        @endforeach
                        
                        <input type="hidden" readonly value="{{$item}}" name="sop[{{$item}}][college]" class="form-control">
                      </div>
                   </div>
                   <div class="col-md-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Upload SOP <span style="color:red;">*</span></label>
                        <input type="file" onchange="getSopfile(this,'#sop_file_{{$item}}','#sop_card{{$item}}')" class="form-control">
                            <input type="hidden" name="sop[{{$item}}][sop_file]" id="sop_file_{{$item}}" >
                    </div>
                   </div>
                </div>
            </div>



        {{-- <div class="row align-items-center">
            <div class="col-12 col-sm-auto order-sm-2">
                <button class="d-block w-auto ms-auto btn btn-danger btn-sm"  type="button" onclick="remove_row('#college_row_{{$item}}','{{$item}}','{{$clg_name}}')"><i class="bx bx-trash m-0"></i></button>
            </div> 
            <div class="col"> 
                <div class="row">
                    <div class="col-md-5"> 
                        <div class="mb-3">
                            <label for="" class="form-label">College Name</label>
                            @php $colleges = App\Models\College::all(); @endphp
                            @foreach ($colleges as $clg)
                                @if ($clg->id == $item || $item == $clg->name)
                                    <p class="form-control">{{$clg->name}}</p>
                                @endif
                            @endforeach
                            
                            <input type="hidden" readonly value="{{$item}}" name="sop[{{$item}}][college]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Upload SOP</label>
                            <input type="file" onchange="getSopfile(this,'#sop_file_{{$item}}','#sop_card{{$item}}')" class="form-control">
                            <input type="hidden" name="sop[{{$item}}][sop_file]" id="sop_file_{{$item}}" >
                        </div>
                    </div>
                    <div class="col-md-1  my-auto" id="sop_card{{$item}}"></div>
                </div>
            </div>                                        
        </div> --}}
    </div>
</div>

@endforeach