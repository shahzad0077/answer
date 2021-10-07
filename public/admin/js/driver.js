function checkslug()
{
	var slug = $('#slug').val();
	var convertedslug = $('#slug').val(convertToSlug(slug)); 
    var mainurl = $('#mainurl').val();
    $.ajax({
        type: "GET",
        url: mainurl+"/checkslug/"+slug,
        success: function(resp) {
            if(resp == 1)
            {
            	$('#slugerror').html('Slug already in use');
            	$('#submitbutton').prop("disabled", true);
            }else{
            	$('#slugerror').html('');
            	$('#submitbutton').prop("disabled", false);
            }
        }
    });
}

function createslug(Text)
{
    $('#slug').val(convertToSlug(Text));    
}

function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}
$(document).ready(function() {
    $("#meta_title").charCount({
        allowed: 60,
        warning: 5,
        counterText: 'Characters left: '
    });

    $("#meta_description").charCount({
        allowed: 150,
        warning: 10,
        counterText: 'Characters left: '
    });

    $("#meta_keywords").charCount({
        allowed: 305,
        warning: 10,
        counterText: 'Characters left: '
    });
});

function answerview(id)
{
    $('#wholebodyloader').addClass('loading');
    var mainurl = $('#mainurl').val();
    $.ajax({
        type: "GET",
        url: mainurl+'/viewsingleanswer/'+id,
        success: function(resp) {
          $('#wholebodyloader').removeClass('loading');
          $('#answer').html(resp.answer);
          $('#answerviewmodal').modal('show');
        }
    });
}
function questionview(id)
{
    $('#wholebodyloader').addClass('loading');
    var mainurl = $('#mainurl').val();
    $.ajax({
        type: "GET",
        url: mainurl+'/viewsinglequestionview/'+id,
        success: function(resp) {
          $('#wholebodyloader').removeClass('loading');
          $('#answer').html(resp.accepted_answer);
          $('#answerviewmodal').modal('show');
        }
    });
}