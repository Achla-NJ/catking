@foreach ($college_id as $key=> $item)
@php
    $relation_count = $relation++;
@endphp
@php
if($item == 'other')
{
    $cname =""; 
    $readonly = '';
}
else{
    $cname =$item;  
    $readonly = 'readonly';
}
@endphp
@php $clg = App\Models\College::where('id',$item)->get('name');  $clg_name = $clg[0]['name']; @endphp

<div class="card bg-light converted_call_div" id="call_{{$relation_count}}">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-12 col-sm-auto order-sm-2">
                <button class="d-block w-auto ms-auto btn btn-danger btn-sm"  type="button" onclick="removeCall('#call_{{$relation_count}}','{{$item}}','{{$clg_name}}')"><i class="bx bx-trash m-0"></i></button>
            </div>
            <div class="col"> 
                <div class="row">
                    <div class="col-md-6"> 
                        <div class="mb-3">
                            <label for="" class="form-label">College Name</label>
                                @php $colleges = App\Models\College::all(); @endphp
                                @foreach ($colleges as $clg)
                                    @if ($clg->id == $cname || $cname == $clg->name)
                                        <p class="form-control">{{$clg->name}}</p>
                                    @endif
                                @endforeach
                            <input type="hidden" {{$readonly}}  value="{{$cname}}" class="form-control" name="converted_call[{{$relation_count}}][college]">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="" class="form-label">Add Document<span style="color:red;"> *</label></label></label>
                            <input type="file" onchange="getCallfile(this,'#call_file_{{$relation_count}}','#sop_card{{$item}}')" class="form-control">
                            <input type="hidden" name="converted_call[{{$relation_count}}][call_file]" id="call_file_{{$relation_count}}" >
                        </div>
                    </div>
                    <div class="col-md-1 my-auto" id="sop_card{{$item}}"></div>
                </div>
            </div>                                        
        </div>
    </div>
</div>

@endforeach