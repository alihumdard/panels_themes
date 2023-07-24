
$(document).ready(function () {
    $(document).on('click', '.add-field', function(e){
        var target = $(this).attr('id');
        var ref = $(this).attr('ref');
        ref++;
        var html = '<div class="row">\n' +
            '           <div class="col-lg-6">\n' +
            '               <div class="form-group">\n' +
            '                   <label for="video_title" class="control-label mb-1">Video Title</label>\n' +
            '                   <input id="video_title_' + ref +'" name="video_title[]" type="text" class="form-control" placeholder="Enter Video Title">\n' +
            '                   <span class="help-block" data-valmsg-for="video_title" data-valmsg-replace="true"></span>\n' +
            '               </div>\n' +
            '           </div>\n' +
            '           <div class="col-lg-6">\n' +
            '               <div class="form-group">\n' +
            '                   <label for="video_link" class="control-label mb-1">Video Link</label>\n' +
            '                   <input id="video_link_' + ref +'" name="video_link[]" type="text" class="form-control" placeholder="Enter Video Link">\n' +
            '                   <span class="help-block" data-valmsg-for="video_link" data-valmsg-replace="true"></span>\n' +
            '               </div>\n' +
            '           </div>\n' +
            '       </div>';

        $('.'+target).append(html);
        $('.'+target).children().last().show('slow');

        $("#target").attr("ref", ref);
    });

    $('#response_type').change( function (e){
        var type = $(this).val();
        if(type == 1){
            $('.option').addClass('hide');

            var json     = {};
            json['type'] = type;
            $.ajax({
                url: "return_option",
                type: "GET",
                data: json,
                dataType: "json",
                success : function(_return)
                {
                    $('#answer').empty();
                    $('#answer').append(_return);
                }
            });

//             var html = ' <option value="">Please Select</option>\n' +
//                 ' <option value="1">True</option>\n' +
//                 ' <option value="2">False</option>\n';
//             $('#answer').empty();
//             $('#answer').append(html);

            $('#option_1').removeAttr('required');
            $('#option_2').removeAttr('required');
            $('#option_3').removeAttr('required');
        }
        else{
            $('.option').removeClass('hide');

            var json     = {};
            json['type'] = type;
            $.ajax({
                url: "return_option",
                type: "GET",
                data: json,
                dataType: "json",
                success : function(_return)
                {
                    $('#answer').empty();
                    $('#answer').append(_return);
                }
            });

            $('#option_1').attr('required', 'required');
            $('#option_2').attr('required', 'required');
            $('#option_3').attr('required', 'required');
        }
    });

    setTimeout(function () {
        $("#flashmessage").fadeOut(3000);
    }, 3000);

    // form validation
    $('#form').validate({ // initialize the plugin
        rules: {
            course_title: {
                required: true
            },
            question_title: {
                required: true
            },
            course_id: {
                required: true
            },
            response_type: {
                required: true
            },
            difficulty_level: {
                required: true
            },
            answer: {
                required: true
            },
            option_1: {
                required: true
            },
            option_2: {
                required: true
            },
            option_3: {
                required: true
            },
            option_4: {
                required: function(element) {
                    return $("#answer").val() == 4 || $("#answer").val() == 5 || $("#option_5").val().length > 0;
                }
            },
            option_5: {
                required: function(element) {
                    return $("#answer").val() == 5;
                }
            },
            batch_title: {
                required: true
            },
            total_questions: {
                required: true,
                digits: true,
                min: 0,
            },
            total_marks: {
                required: true,
                digits: true,
                min: 0,
            },
            time_limit: {
                required: true,
                digits: true,
                min: 0,
            },
            easy_question: {
                required: true,
                digits: true,
                min: 0,
            },
            normal_question: {
                required: true,
                digits: true,
                min: 0,
            },
            hard_question: {
                required: true,
                digits: true,
                min: 0,
                sum_q: true,
            },
            // "video_title[]": {
            //     required: function(element) {
            //         // var count =
            //         return $("#video_link_1").val().length > 0;
            //     }
            // },
            // "video_link[]": {
            //     required: function(element) {
            //         return $("#video_title_1").val().length > 0;
            //     }
            // }
        },
        messages: {
            course_title: "Please enter Course Title",
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }
    });

    // custom validation rule for checking sum of questions
    jQuery.validator.addMethod("sum_q", function() {
        var totalQuestion = $('#total_questions').val();
        var sumOfQuestion = 0;
        $(".sum").each(function(){
            sumOfQuestion += parseInt($(this).val());
        });

        return sumOfQuestion == totalQuestion;
    }, jQuery.validator.format("Sum of Easy, Normal and Hard Question should be equal to Total Questions."));


    $(document).on('click', '#course_button', function(e){
        $('input:text').each(function(index) {
            if($(this).attr('name') == 'search' || $(this).attr('name') == 'course_title'){

            }
            else {
                index = index - 1;
                var id = $(this).attr('id');
                if($('#'+id).val().length > 0){
                    if($('#video_link_'+index).val().length <= 0){
                        alert(22)
                    }
                }
            }
        });
    });

});

$(function () {
    //Course List Datatable
    $('.course-list-table').DataTable({
        processing: true,
        serverSide: true,
        // ajax: "course_list",
        ajax: {
            url: "course_list",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
        ]
    });

    //Course Content List Datatable
    $('.content-list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "content_list",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'course.course_title', name: 'course.course_title' },
            { data: 'title', name: 'title' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    //Question List Datatable
    $('.question-list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "question_list",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'course.course_title', name: 'course.course_title' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    //Question List Datatable
    $('.batch-list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "batch_list",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'course.course_title', name: 'course.course_title' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    //Enrolled User List Datatable
    $('.enrolled-user-list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "enrolled_user",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'username', name: 'username' },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'batch.batch_title', name: 'batch.batch_title' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    //change status
    $(document).on ( 'change', ".status", function(){

        var _status = $(this).val();
        var ref     = $(this).attr('ref');
        var route = window.location.pathname.split("/").pop();

        if(_status == 0)
        {
            $(this).val(1);
            var status_new = 1;
            $(this).prop('checked',true);
        }
        else
        {
            $(this).val(0);
            var status_new = 0;
            $(this).prop('checked',false);
        }

        if(ref != null)
        {
            var json = {};

            json['id']        = ref;
            json['is_enable'] = status_new;
            json['route']     = route;

            $.ajax({
                url: "change_status",
                type: "GET",
                data: json,
                dataType: "json",
                success : function(_return)
                {
                    if(_return > 0)
                    {
                        swal("Success!", "Status changed successfully!", "success");
                        return false;
                    }
                }
            });
        }
    });

});




