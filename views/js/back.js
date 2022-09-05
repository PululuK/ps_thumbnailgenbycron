$(document).ready(function(){
    $("button[name='submitPs_thumbnailgenbycronModule']").click(function(e)
    {
        e.preventDefault();

        let type = $("select[name='type']").val();
        let format = $("select[name='format_"+type+"']").val();
        let erase = $("input[name='erase']:checked").val();

        let data = {
            type : type,
            format : format,
            erase : erase,
        };

        ajaxQuery(data, ajax_url);
    });

    function ajaxQuery(data, ajax_url)
    {

        $("#overlay").fadeIn(300);

        $.ajax({
            type: 'POST',
            url: ajax_url,
            async: false,
            cache: false,
            dataType: 'json',
            data: data,
            success: function(response){
                console.log(response)
            },
            error: function() {
                alert('Error 505')
            }
        }).done(function() {
            setTimeout(function(){
              $("#overlay").fadeOut(300);
            },500);
        });
    }
});