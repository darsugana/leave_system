/**
 * Created by developer on 14/09/2015.
 */

$(function () {

    var token = $("html").data("token");

    $(".btn-add-leave-type").click(function () {
        var url  = $(this).data("url");
        var name = prompt("Enter name for the new leave-type").trim();

        if ( ! name) {
            alert("Name must not be empty");
        }

        $.ajax({
            url: url,
            method: "post",
            data: {
                _token: token,
                name: name
            }
        })
            .success(function (result) {
                if (result.success) {
                    var newType = result.data;
                    var tbody   = $("#tbl-leave-types > tbody");
                    var tr      = $("<tr>").appendTo(tbody);

                    tr.append($("<td>").text(newType.name));
                    $("#tr-empty").hide();
                }
                else {
                    var message = result.message ? result.message : "Failed to add new leave-type";
                    alert(message);
                }
            });
    });

});
