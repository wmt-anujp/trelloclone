$(document).ready(function () {
    $.validator.addMethod("regex", function (value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    });

    // add task
    $("#addtask").validate({
        rules: {
            title: {
                required: true,
                maxlength: 100,
            },
            description: {
                required: true,
                maxlength: 800,
            },
            emp: {
                required: true,
            },
            deadline: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "Please Enter Title",
                maxlength: "Maximum 100 characters are allowed",
            },
            description: {
                required: "Please Enter Description",
                maxlength: "Maximum 800 characters are allowed",
            },
            emp: {
                required: "Please Select any one employee",
            },
            deadline: {
                required: "Please select the due date",
            },
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            error.addClass("invalid-feedback");
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});
