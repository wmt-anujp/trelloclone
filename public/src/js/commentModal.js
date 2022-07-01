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
    var assign =
        "@foreach($comments as $comment)" +
        "<p><span style='color: green'>Commented By: </span>" +
        "{{ $comment->user->name }}" +
        "</p>" +
        "<div class='d-flex justify-content-between align-items-center web'>" +
        "<p style='margin: 0' id='comment_tag'>" +
        "{{$comment->comment}}" +
        "</p>" +
        "@if ($comment->user_id===$user)" +
        "<a data-task=" +
        "{{$tasks->id}}" +
        "data-user=" +
        "{{$user}}" +
        "data-comment=" +
        "{{$comment->id}}" +
        "class='btn btn-sm btn-outline-info cmntupbtn'>Edit</a>" +
        "@endif" +
        "</div>" +
        "@endforeach";

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
                // $(".web").html(response);
                // comment($(".test"));
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
