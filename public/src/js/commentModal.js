var userId = 0;
var taskId = 0;
$(document).ready(function () {
    $(".commentbtn").click(function (event) {
        event.preventDefault();
        userId = event.target.dataset["user"];
        taskId = event.target.dataset["task"];
        $("#cmntmodal").modal("show");
    });

    $("#modalsave").click(function () {
        $.ajax({
            method: "POST",
            url: urlComment,
            data: {
                userId: userId,
                taskId: taskId,
                comment: $("#comment").val(),
                _token: token,
            },
            success: function (response) {
                $("#cmntmodal").modal("hide");
                // alert("Comment Added");
            },
            error: function (error) {
                console.log(error);
                alert("Comment not added");
            },
        });
    });
});

// update comment
var cmntId = 0;
var taskbody = null;
$(document).ready(function () {
    $(".cmntupbtn").click(function (event) {
        event.preventDefault();
        userId = event.target.dataset["user"];
        taskId = event.target.dataset["task"];
        cmntId = event.target.dataset["comment"];
        taskbody = $("#comment_tag").text();
        $("#updatecomment").val(taskbody);
        $("#cmntupmodal").modal("show");
    });

    $("#modalsavee").click(function () {
        $.ajax({
            method: "POST",
            url: urlUpdateComment,
            data: {
                userId: userId,
                taskId: taskId,
                cmntId: cmntId,
                comment: $("#updatecomment").val(),
                _token: token,
            },
            success: function (response) {
                $("#cmntupmodal").modal("hide");
                alert("Comment updated");
            },
            error: function (error) {
                console.log(error);
                alert("Comment not updated");
            },
        });
    });
});
