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
                alert("Comment Added");
            },
            error: function (error) {
                console.log(error);
                alert("Comment not added");
            },
        });
    });
});
