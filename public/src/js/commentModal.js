var userId = 0;
var taskId = 0;
$(document).ready(function () {
    function comment(data) {
        $(".test").append(data);
    }
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
                comment(response[0].comment);
                // alert("Comment Added");
                // window.location.reload();
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
        taskbody = event.target.previousElementSibling;
        var cmntdata = taskbody.textContent;
        $("#updatecomment").val(cmntdata);
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
                window.location.reload();
                // alert("Comment updated");
            },
            error: function (error) {
                console.log(error);
                alert("Comment not updated");
            },
        });
    });
});
