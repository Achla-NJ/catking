function openModel(model){
    $("#edu-select").val("");
    $('.modal-loader').addClass('show');
    $(model).modal('show');
    setTimeout(() => {
       $(model+' .multiple-select').select2(
          {
             tags: true
          }
       );
       $('.modal-loader').removeClass('show');
    }, 500);
}        

function removeRow(id,val,item){
 $(id).remove();
 $("#edu-dreamcollege-select").append(`<option value="${val}">${item}</option>`);
}
function removeDreamCollege(id,val,item){
 $(id).remove();
 // $("#edu-dreamcollege-select").append(`<option value="${val}">${item}</option>`);
}
function removeCall(id,val,item){
 $(id).remove();
  $("#edu-call-select").append(`<option value="${val}">${item}</option>`);
}   

function addCall(){
 var college_id = $("#edu-call-select").val();
 var college = $("#edu-call-select :selected").text();
 var _token = $("input[name='_token']").val();
 var converted_call_div = $("div[class*='converted_call_div']").length;
 var converted_call_relation = converted_call_div+1;
var url = $("#add-call").val();
 if(college_id !== ''){
     $.ajax({
         type: "post",
         url,
         data:{
             college_id,college,_token,converted_call_relation
         },
         success:function(response){ 
             $("#call_append").before(response);  
        }, 
        error:function(response){ 
            failMessage('Enter Valid Data')
        }, 
     })
      $('#edu-call-select option:selected').remove();
 }
 
}

function addDreamCollege(){
 var college_id = $("#edu-dreamcollege-select").val();
 var college = $("#edu-dreamcollege-select :selected").text();
 var _token = $("input[name='_token']").val();
 var dream_college_div = $("div[class*='dream_college_div']").length;
 var dream_college_relation = dream_college_div+1;
 var url = $("#add-dream-college").val();
 if(college_id !== ''){
     $.ajax({
         type: "post",
         url,
         data:{
             college_id,college,_token,dream_college_relation
         },
         success:function(response){ 
             $("#dreamcollege_append").before(response);  
             
         }  , 
         error:function(response){ 
            failMessage('Enter Valid Data')
         }, 
     })
      $('#edu-dreamcollege-select option:selected').remove();
 }
}

function saveDreamCollege(){
 var dreamcollegeform = document.getElementById('dream-college-form');
 var fd = new FormData(dreamcollegeform);      
 var url = dreamcollegeform.action;            
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
         var tabNext = $("#profile_stats").attr('tab-next');
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
function removeCollege(id,val,item){
 $(id).remove();
 // $("#edu-college-select").append(`<option value="${val}">${item}</option>`);
}

function getCallfile(event,id,sop_id){
 var sop = new FormData();
 var token = $("input[name='_token']").val();
 sop.append('_token',token);
 sop.append('files',event.files[0]);
 console.log(sop)
 var url = $("#profile-call").val();
// alert(url)
 $.ajax({
     type: "post",
     url,
     data: sop,
     contentType: false,
     processData: false,
     dataType: "json",
     cache:"false",
     success:function(response){                                              
         $(id).val(response.message);    
         $(sop_id).html(`<a href=${response.url} class="btn btn-warning btn-sm" target="_blank" >View</a>`)                                              
     },
     error:function(response){
         failMessage(response.responseJSON.message)
     }
     
 });
}


$('.multiple-select').select2({
         tags: true
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

function educationGap(col){
 $(col).hasClass('d-none') ?$(col).removeClass('d-none') :$(col).addClass('d-none'); 
}