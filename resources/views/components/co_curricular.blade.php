@php
    $random = rand(000,999)
@endphp
<div class="row mb-3 curricular_co_div" id="co_div_{{$random}}">
    <div class="col-md-11">
       <input type="text"  name="curricular[{{$relation}}][]" class="form-control">
    </div>
    <div class="col-md-1">      
        <button class=" btn btn-danger btn-sm" type="button"onclick="removeExam('#co_div_{{$random}}')"><i class="bx bx-trash m-0"></i></button>
    </div>
    
 </div> 