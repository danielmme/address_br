(function ($, Drupal) {
    $('#cep').mask('00000-000');
    $("#cep").focusout(function(){
        
        var cep = $('#cep').val();
        cep = cep.replace("-", "");
        console.log(cep);

        var urlStr = "http://viacep.com.br/ws/"+ cep +"/json/";

        $.ajax({
            url : urlStr,
            type: "get",
            dataType: "json",
            success: function(data){
                console.log(data);
                $('#thoroughfare').val(data.logradouro);
                $('#neighborhood').val(data.bairro);
                $('#city').val(data.localidade);
                $('#state').val(data.uf);
            },
            error: function(erro){
                console.log(erro);
            }
        });

    });

    


  })(jQuery, Drupal);