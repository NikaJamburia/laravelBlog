$(document).ready(function(){

    $('#imgInput').on('change', function(event){

        console.log($(this));

        fileName = $(this).val();

        $('#img').attr('src', URL.createObjectURL(event.target.files[0]));
    });

    $('#CategorySelector').on('change', function(){

        if($(this).val() == 'def'){
            window.location.replace('/posts');
        }
        else{
            window.location.replace('/posts/category/'+$(this).val());
        }

    });
  
  });

function showForm(e, n){
    e.target.classList.add('d-none');
    $('#replyForm'+n).removeClass('d-none');
    $('#replyForm'+n).addClass('d-block');
}