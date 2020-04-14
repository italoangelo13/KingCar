$(document).ready(function(){
    
});




function CarregaDdlModelo() {
    let CodMarca = $( "#_ddlMarca option:selected" ).val();//$("#_ddlMarca").val();  
    var obj = {
        CODMARCA: CodMarca,
    };

    //var param = JSON.stringify(obj);

    $.ajax({
        url: "service/BuscaModelos.php?codMarca="+CodMarca,
        type: 'GET',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            debugger;
            console.log(data);
            var selectbox = $('#_ddlModelo');
            selectbox.find('option').remove();
            data.forEach(function(o, index){
                $('<option>').val(o.MODCOD).text(o.MODDESCRICAO).appendTo(selectbox);
            });
            $('<option>').val('0').text('Selecionar').appendTo(selectbox);
            $('#_ddlModelo option[value=0]').attr('selected','selected');
            
        }
    });
}



//Altera Painel
function AlternaPainel(s, h) {
    //s -> Tela a ser mostrada
    //h -> Tela a ser ocultada
    $("#" + h).removeClass("display-show");
    $("#" + h).addClass("display-hide");
    $("#" + s).removeClass("display-hide");
    $("#" + s).addClass("display-show");
}



function SuccessBox(msg) {
    $.alert({
        title: 'KingCar Alerta',
        content: msg,
        type: 'green',
        typeAnimated: true,
    });
}

function WarningBox(msg) {
    $.alert({
        title: 'KingCar Alerta',
        content: msg,
        type: 'orange',
        typeAnimated: true,
    });
}

function ErrorBox(msg) {
    $.alert({
        title: 'KingCar Alerta',
        content: msg,
        type: 'red',
        typeAnimated: true,
    });
}


function DefaultBox(msg) {
    $.alert({
        title: 'KingCar Alerta',
        content: msg,
        type: 'dark',
        typeAnimated: true,
    });
}


function showLoad(msg) {
    if (msg == null || msg == '') {
        msg = 'Carregando...'
    }

    $('body').loading({
        theme: 'dark',
        message: msg
    });
}


function hideLoad() {
    $('body').loading('stop');
}


function showLoadModal(msg,e) {
    if (msg == null || msg == '') {
        msg = 'Carregando...'
    }

    $(e).loading({
        theme: 'dark',
        message: msg
    });
}


function hideLoadModal(e) {
    $(e).loading('stop');
}


function formatReal( int )
{
        var tmp = int+'';
        tmp = tmp.replace(/([0-9]{2})$/g, "0,$1");
        if( tmp.length > 6 )
                tmp = tmp.replace(/([0-9]{10}).([0-9]{2}$)/g, ".$1,$2");
        return tmp;
}