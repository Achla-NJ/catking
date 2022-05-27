@php
    $relation = rand(00,99)
@endphp
<div class="card" id="work_row_{{$relation}}">
    <div class="card-body">
        <button class="d-block w-auto ms-auto btn btn-danger btn-sm" type="button" onclick="removeWork('#work_row_{{$relation}}')"><i class="bx bx-trash m-0"></i></button>
        <div class="row" >
            <div class="col-md-6">
            <div class="mb-3">
                    <label for="" class="form-label">Employment Type</label>
                    <select name="works[{{$relation}}][work_type]" id="" class="form-select">
                        <option value="full_time" >Full Time</option>
                        <option value="part_time" >Part Time</option>
                        <option value="internship" >Internship</option>
                    </select>
                </div>

            </div>
            <div class="col-md-6">
               <div class="mb-3">
                    <label for="" class="form-label">Company Name</label>
                    <input type="text" name="works[{{$relation}}][company_name]"  id="company_name" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Designation</label>
                    <input type="text" name="works[{{$relation}}][role]" id="role"  class="form-control">
                </div>

                 <div class="mb-3">
                    <label for="responsibilities" class="form-label">Responsibilities</label>
                    <input type="text" name="works[{{$relation}}][responsibilities]" id="responsibilities" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Start Date</label>
                    <input type="date" name="works[{{$relation}}][join_date]" id="" class="form-control" >
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">End Date</label>
                    <div class="row align-items-center">
                        <div class="col-12 col-md-auto">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="work_present{{$relation}}" name="works[{{$relation}}][working_presently]"  value="yes"onclick="leaveDate('#join_end_{{$relation}}')">
                                <label class="form-check-label" for="work_present{{$relation}}">Working Presently ?</label>
                            </div>
                        </div>
                        <div class="col-12 col-md">
                            <input type="date" name="works[{{$relation}}][leave_date]" id="join_end_{{$relation}}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
