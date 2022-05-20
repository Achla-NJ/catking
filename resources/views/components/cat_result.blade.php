<div class="card">
   <div class="row m-3">
      <div class="col-md-12 col-sm-12">
         @foreach ($result->details as $key => $value)
         <div class="row">
            <div class="col-md-3 col-sm-6"><div class="h6">{{$key}}:- </div ></div>
            <div class="col-md-4 col-sm-6" ><div class="h6"><div >{{$value}}</div > </div ></div>
         </div>
         @endforeach
         
         <div class="row">
            <div class="col-md-3"><div class="h6">Exam Sheet URL:- </div ></div>
            <div class="col-md-4"><div class="h6"><div ><a href="{{$url}}"
               target="_blank" rel="nofollow">Open</a></div > </div ></div>
         </div>
      </div>
   </div>
</div>

<div class="card">
   <div class="row my-3">
      @foreach ($result->sections_marks as $s)
         <div class="col-md-4">
               <div class='bg-primary-2 p-1 text-center'>
                     <h4>Section: {{$s->name}}</h4>
               </div>
               <div class='row p-2 m-2'>
                     <div class='col-md-6'>Total Questions</div>
                     <div class='col-md-6'><span>{{$s->total_questions}}</span></div>
               </div>
               <div class='row p-2 m-2'>
                     <div class='col-md-6'>Attempt Questions</div>
                     <div class='col-md-6'><span>{{$s->attempt_questions}}</span></div>
               </div>
               <div class='row p-2 m-2'>
                     <div class='col-md-6'>Correct Answers</div>
                     <div class='col-md-6'><span>{{$s->correct_answers}}</span></div>
               </div>
               <div class='row p-2 m-2'>
                     <div class='col-md-6'>Wrong Answers</div>
                     <div class='col-md-6'><span>{{$s->wrong_answers}}</span></div>
               </div>
               <div class='row p-2 m-2'>
                     <div class='col-md-6'>Obtain Marks</div>
                     <div class='col-md-6'><span>{{$s->obtain_marks}} / {{$s->total_marks}}</span></div>
               </div>
            </div>
         @endforeach
   </div>
   
</div>

<div class="card">
   <div class="row ">
      <div class="col-md-12 text-center my-3">
         <div class="h4 mb-3">Total Marks Obtained</div>
         <div class='marks'><span class="font-50">{{$result->obtain_marks}} </span><span class="font-22">/{{$result->total_marks}}</span></div>
         <div class="h4">You would get {{$result->percentile}}</div>
      </div>
   </div>
</div>