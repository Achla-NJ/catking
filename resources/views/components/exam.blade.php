@foreach ($exam as $item)
    @php
    if ($item == 'other'){
       $exm_name = "Other Exams ";
       $display="";
    }else{
        $exm_name =strtoupper($item);
        $display="d-none";
    }     
    $relation_count=$relation++;
    @endphp
    <div class="col-12 exam_div" id="exam_row_{{$relation_count}}">
        <div class="row align-items-center g-2">

            <div class="col-12 d-flex col-md mb-4">
                <div class="col me-2 bg-primary-4 font-20 h5  p-2  mb-0">{{$exm_name}} Result</div>
                <button class="d-block w-auto ms-auto btn btn-danger btn-sm" type="button"onclick="removeExam('#exam_row_{{$relation_count}}','{{$item}}','{{$exm_name}}')"><i class="bx bx-trash m-0"></i></button>
            </div>
          
            <div class="col-12">
                <div class="row">                                
                    @if ($item == 'other')    
                    <div class="col-md-2 cat_{{$item}} {{$display}} ">  
                        <div class="mb-3">    
                            <input type="hidden" value="other" name="exam[{{$relation_count}}][exam_type]">  
                            <label for="" class="form-label">Exam Name</label>
                            <input type="text"  name="exam[{{$relation_count}}][name]"  data-set="cat_{{$item}}" class="form-control"  >   
                        </div>
                    </div>
                    @else
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="" class="form-label">Took {{$exm_name}}</label>
                            <input type="hidden" value="{{$item}}" name="exam[{{$relation_count}}][exam_type]">        
                            
                            <select name="exam[{{$relation_count}}][took_exam]" id="exam_opt_{{$item}}" data-set="cat_{{$item}}" class="form-select">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                    </div>    
                    @endif    
                    <div class="col-md-2 cat_{{$item}} {{$display}} disp">
                        <div class="mb-3">
                            <label for="" class="form-label">Scores <span style="color:red;">*</span></label>
                            <input type="text" name="exam[{{$relation_count}}][score]" id="score" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-auto cat_{{$item}} {{$display}} disp">
                        <div class="mb-3">
                            <label for="" class="form-label">Percentile (if available)</label>
                            <input type="text" name="exam[{{$relation_count}}][percentile]" id="percentile" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg cat_{{$item}} {{$display}} disp">
                        <div class="mb-3">
                            <label for="" class="form-label">Score Card <span style="color:red;">*</span></label>
                            <input type="file"  id="score_card_file" class="form-control" onchange="getScorefile(this,'#card_file_{{$item}}','#sop_card{{$item}}')">
                            <input type="hidden" id="card_file_{{$item}}" name="exam[{{$relation_count}}][score_card]">
                        </div>
                    </div>
                    {{-- <div class="col-md-1 cat_{{$item}} {{$display}} my-auto disp" id="sop_card{{$item}}">
                       
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#exam_opt_{{$item}}').on('change',function(){
            let colSet = $(this).attr('data-set');
            let col = $(`.disp.${colSet}`);
            let inputs = $(`.disp.${colSet} .form-control`);  
            col.hasClass('d-none') ? col.removeClass('d-none') : col.addClass('d-none').find('.form-control').val('');
                    
        });
        </script>
@endforeach