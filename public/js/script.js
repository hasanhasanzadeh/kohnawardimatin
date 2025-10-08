$(document).ready(function () {
    $(".nav-toggler").each(function (_, navToggler) {
        var target = $(navToggler).data("target");
        $(navToggler).on("click", function () {
            $(target).animate({
                height: "toggle",
            });
        });
    });
});
function closeAlert(event){
    let element = event.target;
    while(element.nodeName !== "BUTTON"){
        element = element.parentNode;
    }
    element.parentNode.parentNode.removeChild(element.parentNode);
}