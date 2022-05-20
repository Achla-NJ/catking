@foreach ($data as $key=> $class_type)
    @php
        $edu_name = str_replace('_',' ',$class_type);
        $random = rand(0000,9999);

        if($class_type == "matric" || $class_type == "secondary"){
            $board_name_label = 'Board';
            $other_board_name_label = "Board Name";
            $school_name_label = 'School';
        }
        elseif($class_type == "graduation" || $class_type == "post_graduation"){
            $board_name_label = 'Degree';
            $other_board_name_label = "Course Name";
            $school_name_label = "College";
        }
        elseif($class_type == "diploma" || $class_type == "other"){
            $board_name_label = 'Course';
            $other_board_name_label = "Course Name";
            $school_name_label = "institute";
        }
    @endphp

    <div class="col-12 education_div" id="edu_row_{{$relation}}">
        <input type="hidden" name="educations[{{$relation}}][class_type]" value="{{$class_type}}">
        <input type="hidden" value="other" name="educations[{{$relation}}][class_name]">
        <div class="row align-items-center ">
            <div class="col-12 d-flex col-md mb-4">
                <div class="col me-2 bg-primary-4 font-20 h5  p-2  mb-0">{{App\Models\User::STUDY_CLASSES[$class_type]}}</div>
                <button class="d-block w-auto ms-auto btn btn-danger btn-sm" type="button" onclick="remove_row('#edu_row_{{$relation}}')"><i class="bx bx-trash m-0"></i></button>
            </div>
            @if ($edu_name == 'other')
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Name of certification</label>
                                <select name="educations[{{$relation}}][board_type]" id="other_certification" class="form-control" onchange="addOtherInput('#other_input_{{$relation}}', '{{$relation}}', this, '{{ $other_board_name_label }}')">
                                    <option value="">-Select-</option>
                                    <option value="ca/cs/cfa">CA/CS/CFA</option>
                                    <option value="actuaries">Actuaries</option>
                                    <option value="engage7x">Engage7x</option>
                                    <option value="other">Other certifications</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="educations[{{$relation}}][start_date]" id="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="educations[{{$relation}}][passing_year]" id="completion_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="other_input_{{$relation}}"></div>
                </div>
            @else
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">{{ $board_name_label }}</label>
                                @if ($class_type == 'post_graduation')
                                    <select name="educations[{{$relation}}][board_type]" id="other_certification" class="form-control" onchange="addOtherInput('#other_input_{{$relation}}', '{{$relation}}', this, '{{ $other_board_name_label }}')">
                                        <option value="">-Select-</option>
                                        <option value="mcom">MCom</option>
                                        <option value="mca">MCA</option>
                                        <option value="ma">MA</option>
                                        <option value="mtech">MTech</option>
                                        <option value="other">Other</option>
                                    </select>
                                @else
                                    <input type="text" name="educations[{{$relation}}][board_name]" id="board_name" class="form-control">
                                @endif
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">{{ $school_name_label }}</label>
                                <input type="text" name="educations[{{$relation}}][school]" id="school" class="form-control" >
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Marks(%)</label>
                                <input type="text" name="educations[{{$relation}}][marks]" id="marks" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                            <label class="form-label">CGPA</label>
                            <input type="text" name="educations[{{$relation}}][cgpa]" id="cpga" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Passing Year</label>
                                <input type="number" min="1900" max="2022" step="1"  name="educations[{{$relation}}][passing_year]" id="completion_date" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="other_input_{{$relation}}"></div>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Summary</label>
                            <input type="text" name="educations[{{$relation}}][summary]" id="class" class="form-control">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endforeach
