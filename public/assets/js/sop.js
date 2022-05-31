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
 

 function remove_row(id,cid,cname){
    $(id).remove();
    $('#edu-college-select').append(`<option value="${cid}">
                                       ${cname}
                                  </option>`);
 }
  
function getSopfile(event,id,sop_id){
    var sop = new FormData();
    var token = $("input[name='_token']").val();
    sop.append('_token',token);
    sop.append('files',event.files[0]);
    var url = $("#get-sop").val();
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
            $(sop_id).html(`<a href=${response.url} class="btn btn-warning " target="_blank" >View</a>`)                                                
        },
        error:function(response){
            
            let errors = Object.values(response.responseJSON.errors);
            errors.map((er)=>{
                failMessage(er)
            });
        }
        
    });
}

function saveSop(){
    var sopform = document.getElementById('sop-form');
    var fd = new FormData(sopform);     
    var url = sopform.action;             
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
            var tabNext = $("#sops").attr('tab-next');
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
 
 function addCollege(){
    var college = $("#edu-college-select").val();
    var _token = $("input[name='_token']").val();
    var sop_div = $("div[class*='sop_div']").length;
    var sop_relation = sop_div+1;
    var url = $("#add-college").val();
    
        $.ajax({
            type: "post",
            url,
            data:{
                college,_token,sop_relation
            },
            success:function(response){ 
                $("#college_append").before(response);  
            }  ,
            error:function(response){
                failMessage('Enter Valid Data')
            }  
        })
        $('#edu-college-select option:selected').remove();
    
 }
 
 $('a#dream_link').click(()=>{
    setTimeout(() => {
        $('.multiple-select').select2({
            tags: true
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
 