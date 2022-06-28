var userId = 0;
var postId = 0;
$(document).ready(function () {
    $(".commentbtn").click(function (event) {
        event.preventDefault();
        userId = event.target.dataset["user"];
        postId = event.target.dataset["post"];
        $("#cmntmodal").modal("show");
    });

    $("#modalsave").click(function () {
        $.ajax({
            method: "POST",
            url: urlComment,
            data: {
                userId: userId,
                postId: postId,
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
