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
<div class="card bg-light dream_college_div" id="dream_college_row_{{$relation_count}}">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-12 col-sm-auto order-sm-2">
                <button class="d-block w-auto ms-auto btn btn-danger btn-sm"  type="button" onclick="removeRow('#dream_college_row_{{$relation_count}}','{{$item}}','{{$clg_name}}')"><i class="bx bx-trash m-0"></i></button>
            </div>
            <div class="col"> 
                 <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">College Name</label>
                            @php $colleges = App\Models\College::all(); @endphp
                                @foreach ($colleges as $clg)
                                    @if ($clg->id == $cname|| $cname == $clg->name)
                                        <p class="form-control">{{$clg->name}}</p>
                                    @endif
                                @endforeach
                            <input type="hidden" {{$readonly}} value="{{$cname}}" name="interview[{{$relation_count}}][college]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Select Date<span style="color:red;"> *</label></label></label>
                            <input type="date" name="interview[{{$relation_count}}][interview_date]" class="form-control">
                        </div>
                    </div>
                </div>
            </div>                                        
        </div>
    </div>
</div>
@endforeach