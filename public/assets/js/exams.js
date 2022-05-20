function openModel(model){
    $("#edu-select").val("");
    $('.modal-loader').addClass('show');
    $(model).modal('show');
    setTimeout(() => {
       $(model+' .multiple-select').select2(
          {
             tags: false
          }
       );
       $('.modal-loader').removeClass('show');
    }, 500);
}        

function removeExam(id,cid,cname){
 $(id).remove();
 $('#edu-exam-select').prepend(`<option value="${cid}">
 ${cname}
</option>`);
}



function getScorefile(event,id,sop_id){
 var scoreCard = new FormData();
 var token = $("input[name='_token']").val();
 var url = $("#score_card_url").val()
 scoreCard.append('_token',token);
 scoreCard.append('files',event.files[0]);
 console.log(scoreCard)
 $.ajax({
     type: "post",
     url,
     data: scoreCard,
     contentType: false,
     processData: false,
     dataType: "json",
     cache:"false",
     success:function(response){ 
         console.log(response.url);
                                                      
         $(id).val(response.message); 
         $(sop_id).html(`<a href=${response.url} class="btn btn-warning btn-sm" target="_blank" >View</a>`)                                              
     },
     error:function(response){
        let errors = Object.values(response.responseJSON.errors);
            errors.map((er)=>{
                failMessage(er)
            });
     }
     
 });
}

function saveExam(){
 var examform = document.getElementById('exam-form');
 var fd = new FormData(examform); 
 var url = examform.action ;
 let mark_val = 0;
    document.querySelectorAll('.percentile').forEach((el)=>{
        if(($(el).val()) > 100){
            mark_val++;
        }
     });
    if(mark_val > 0){
        failMessage('Percentile Field have invalid value');
        return false;
    }
 $.ajax({
     type: "post",
     url,
     data: fd,
     contentType: false,
     processData: false,
     dataType: "json",
     cache:"false",
     beforeSend: function() {
         $(".form-loader").addClass('show');
         $('body').addClass('overflow-hidden');     
     },
     success:function(response){                                              
         $(".form-loader").removeClass('show');  
         $('body').removeClass('overflow-hidden');  
         var tabNext = $("#exams").attr('tab-next');
         nextTab(tabNext);
         successMessage(response.message);                                               
     },
     error:function(response){
         $(".form-loader").removeClass('show');
         $('body').removeClass('overflow-hidden');
         let errors = Object.values(response.responseJSON.errors);
            errors.map((er)=>{
                failMessage(er)
            });
     }                                                
 });
}

function addExam(){
 var exam_div = $("div[class*='exam_div']").length;
 var exam_relation = exam_div+1;
 var exam = $("#edu-exam-select").val();
 var url = $("#add-exam").val();
 var _token = $("input[name='_token']").val();
 $.ajax({
     type: "post",
     url,
     data:{
         exam,_token,exam_relation
     },
     success:function(response){ 
         $("#exam_append").before(response);  
     }  
 })
 $('#edu-exam-select option:selected').remove();
//  $("#edu-exam-select").val("");
 
}

$('#exam_opt').on('change',function(){
 let colSet = $(this).attr('data-set');
 let col = $(`.col-md-3.${colSet}`);
 let inputs = $(`.col-md-3.${colSet} .form-control`);  
 col.hasClass('d-none') ? col.removeClass('d-none') : col.addClass('d-none').find('.form-control').val('');
         
});
$('a#dream_link').click(()=>{
 setTimeout(() => {
     $('.multiple-select').select2({
         tags: false
     });
 }, 500);
});

$('#basic').click(function(e){
 e.preventDefault();
 
 // enable loader
 $('.form-loader').addClass('show');
 $('body').addClass('overflow-hidden');
 
 // to move next tab
 
 var tabNext = $(this).attr('tab-next');
 nextTab(tabNext);
});
function nextTab(tabNext){
 $('a[href="#'+tabNext+'"]').tab('show');
}