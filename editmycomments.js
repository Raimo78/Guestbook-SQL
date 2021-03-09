
function editcomment(id) {

   if(confirm("Are you sure you want to edit this comment?")) {

        $.ajax({
        url: "comment-edit.php",
        type: "POST",
        data: 'comment_id='+id,
        success: function(data){
            if (data)
            {
                $("#comment-"+id).remove();
                if($("#count-number").length > 0) {
                    var currentCount = parseInt($("#count-number").text());
                    var newCount = currentCount - 1;
                    $("#count-number").text(newCount)
                }
            }
        }
       });
    }
 }

$(document).ready(function() {

    $("#frmComment").on("submit", function(e) {
            $(".error").text("");
        $('#name-info').removeClass("error");
        $('#message-info').removeClass("error");
        e.preventDefault();
        var name = $('#name').val();
        var message = $('#message').val();
        
        if(name == ""){
                $('#name-info').addClass("error");
        }
        if(message == ""){
                $('#message-info').addClass("error");
        }
        $(".error").text("required");
        if(name && message){
                $("#loader").show();
                $("#submit").hide();
                 $.ajax({
            
             type:'POST',
             url: 'comment-add.php',
             data: $(this).serialize(),
             success: function(response)
                {
                    $("#frmComment input").val("");
                    $("#frmComment textarea").val("");
                     $('#response').prepend(response);

                     if($("#count-number").length > 0) {
                         var currentCount = parseInt($("#count-number").text());
                         var newCount = currentCount + 1;
                         $("#count-number").text(newCount)
                     }
                     $("#loader").hide();
                     $("#submit").show();
                 }
                });
        }
    });
 });
