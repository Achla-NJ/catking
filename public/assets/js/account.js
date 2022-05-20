function editForm(e){
    $(".tab-pane  input").attr('disabled', false);
    $(".tab-pane  select").attr('disabled', false);
    $(".tab-pane  button").removeClass('d-none');
    $(".avatar-update").removeClass('d-none');
    $(e).hide()
}

$(document).ready(function(){
     $(".tab-pane  input").attr('disabled', true);
     $(".tab-pane  select").attr('disabled', true);
     $(".tab-pane  button").addClass('d-none');
     $(".avatar-update").addClass('d-none');
})

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

function avatarSave(){
    var obj = document.getElementById('avatar');
    var form = document.getElementById('avatar-form');
    var avatarForm = new FormData(form)
    var file = $("#avatar").get(0).files[0];
    var url = form.action;

    $.ajax({
        type: "post",
        url,
        data: avatarForm,
        contentType: false,
        processData: false,
        dataType: "json",
        cache:"false",
        beforeSend: function() {
            $(".avatar-loader").addClass('show');
        },
        success:function(response){
            $(".avatar-loader").removeClass('show');

            var reader = new FileReader();
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
            reader.readAsDataURL(file);

            successMessage(response.message);
        },
        error:function(response){
            $(".avatar-loader").removeClass('show');
            let errors = Object.values(response.responseJSON.errors);
            errors.map((er)=>{
                failMessage(er)
            });
        }

    });
 }

 function savePersonalInfo(){
    var personalinfo = document.getElementById('first-step');
    var url = personalinfo.action;
    var fd = new FormData(personalinfo);
    console.log(fd);
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
            var tabNext = $("#first").attr('tab-next');
            nextTab(tabNext);
            successMessage(response.message);
        },
        error:function(response){
            $(".form-loader").removeClass('show');
            $('body').removeClass('overflow-hidden');
            failMessage(response.responseJSON.message)
        }
    });
 }


function addEducation(){
    var education_div = $("div[class*='education_div']").length;
    var education_relation = education_div+1;
    var education = $("#edu-select").val();
    var url = $("#add-education").val();
    //var education_relation = $("#education_relation").val();
    var _token = $("input[name='_token']").val();
    $.ajax({
          type: "post",
          url,
          data:{
             education,_token,education_relation
          },
          success:function(response){
             $("#edu_append").before(response);

          }
       })
 }

 function saveEducation(){;
    var education = document.getElementById('second-step');
    var fd = new FormData(education);
    var url = education.action;
    //console.log(fd);
    let mark_val = 0;
    document.querySelectorAll('.marks').forEach((el)=>{
        if(($(el).val()) > 100){
            mark_val++;
        }
     });
    if(mark_val > 0){
        failMessage('Marks Field have invalid value');
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
            var tabNext = $("#edu").attr('tab-next');
            nextTab(tabNext);
            successMessage(response.message);
        },
        error:function(response){
            $(".form-loader").removeClass('show');
            $('body').removeClass('overflow-hidden');
            failMessage(response.responseJSON.message)
        }
    });
 }

 function addWork(){
    var work_div = $("div[class*='work_div']").length;
    var work_relation = work_div+1;
    var _token = $("input[name='_token']").val();
    var url = $("#add-work").val();
    $.ajax({
          type: "post",
          url,
          data:{
             _token,work_relation
          },
          success:function(response){
             $("#work_append").before(response);

          }
       })
 }

 function saveWorkExperience(){
    var workexaperience = document.getElementById('third-step');
    var fd = new FormData(workexaperience);
    var url = workexaperience.action;
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
            var tabNext = $("#work").attr('tab-next');
            nextTab(tabNext);
            successMessage(response.message);
        },
        error:function(response){
            $(".form-loader").removeClass('show');
            $('body').removeClass('overflow-hidden');
            failMessage(response.responseJSON.message)
        }
    });
 }

function AddCurricular(rel){
    var url = $("#add-curricular").val();
    var _token = $("input[name='_token']").val();
    $.ajax({
          type: "post",
          url,
          data:{
             _token,rel
          },
          success:function(response){
             $(`.curricular_append_${rel}`).before(response);
          }
       })
 }


function saveCurricular(){

    var curricular = document.getElementById('curricular-form');
    var fd = new FormData(curricular);
    var url =curricular.action;
    console.log(fd);
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
            var tabNext = $("#work").attr('tab-next');
            nextTab(tabNext);
            successMessage(response.message);
        },
        error:function(response){
            $(".form-loader").removeClass('show');
            $('body').removeClass('overflow-hidden');
            failMessage(response.responseJSON.message)
        }
    });
 }

 function addOtherInput(id,relation,el, inputLabel = 'Board Name'){
    $(id).html('')
    if(el.value === 'other'){
        $(id).append(`
        <div class="mb-3 mt-2">
            <label class="form-label">${inputLabel}</label>
            <input type="text" name="educations[${relation}][board_name]" class="form-control"/>
        </div>
        `)
    }
 }

 function removeWork(id){
    $(id).remove();
 }
 function removeExam(id){
    $(id).remove();
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
            failMessage(response.responseJSON.message)
        }
    });
 }

 function leaveDate(id){
    console.log(id)
    let input = $(id);
    input.hasClass('d-none')? input.removeClass('d-none').removeAttr('disabled') : input.addClass('d-none').attr({disabled:'disabled',value:''});
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

 function educationGap(col){
    $(col).hasClass('d-none') ?$(col).removeClass('d-none') :$(col).addClass('d-none');
 }

 function remove_row(id){
    $(id).remove()
 }
