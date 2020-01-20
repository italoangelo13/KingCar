/*
*    Script:    Mascaras em Javascript
*    Autor:    Matheus Biagini de Lima Dias
*    Data:    26/08/2008
*    Obs:    
*/
/*Função Pai de Mascaras*/
function Mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}

/*Função que Executa os objetos*/
function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}

/*Função que Determina as expressões regulares dos objetos*/
function leech(v) {
    v = v.replace(/o/gi, "0")
    v = v.replace(/i/gi, "1")
    v = v.replace(/z/gi, "2")
    v = v.replace(/e/gi, "3")
    v = v.replace(/a/gi, "4")
    v = v.replace(/s/gi, "5")
    v = v.replace(/t/gi, "7")
    return v
}



/*Função que permite apenas numeros*/
function Integer(v) {
    return v.replace(/\D/g, "")
}

/*Função que padroniza telefone (11) 4184-1241*/
function Telefone(v) {
    var texto = v;

    // Tiro tudo que não é numero

    texto = texto.replace(/[^\d]/g, '');

    // Se tiver alguma coisa    
    if (texto.length > 0) {
        // Ponho o primeiro parenteses do DDD        
        texto = "(" + texto;

        if (texto.length > 3) {
            // Fecha o parenteses do DDD            
            texto = texto.substring(0, 3) + ") " + texto.substring(3);
        }

        if (texto.length > 10) {
            // Se for 13 digitos ( DDD + 9 digitos) ponhe o traço no quinto digito                
            if (texto.length > 13)
                texto = texto.substring(0, 10) + "-" + texto.substring(10);
            else
                // Se for 12 digitos ( DDD + 8 digitos) ponhe o traço no quarto digito                
                texto = texto.substring(0, 9) + "-" + texto.substring(9);
        }

        // Não adianta digitar mais digitos!

        if (texto.length > 15)
            texto = texto.substring(0, 15);

    }

    // Retorna o texto   
    return texto;
}

/*Função que padroniza telefone (11) 41841241*/
function TelefoneCall(v) {
    v = v.replace(/\D/g, "")
    v = v.replace(/^(\d\d)(\d)/g, "($1) $2")
    return v
}

/*Função que padroniza CPF*/
function Cpf(v) {
    v = v.replace(/\D/g, "")
    v = v.replace(/(\d{3})(\d)/, "$1.$2")
    v = v.replace(/(\d{3})(\d)/, "$1.$2")

    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
    return v
}

/*Função que padroniza CEP*/
function Cep(v) {
    v = v.replace(/D/g, "")
    v = v.replace(/^(\d{5})(\d)/, "$1-$2")
    return v
}

/*Função que padroniza CNPJ*/
function Cnpj(v) {
    v = v.replace(/\D/g, "")
    v = v.replace(/^(\d{2})(\d)/, "$1.$2")
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2")
    v = v.replace(/(\d{4})(\d)/, "$1-$2")
    return v
}

/*Função que permite apenas numeros Romanos*/
function Romanos(v) {
    v = v.toUpperCase()
    v = v.replace(/[^IVXLCDM]/g, "")

    while (v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/, "") != "")
        v = v.replace(/.$/, "")
    return v
}

/*Função que padroniza o Site*/
function Site(v) {
    v = v.replace(/^http:\/\/?/, "")
    dominio = v
    caminho = ""
    if (v.indexOf("/") > -1)
        dominio = v.split("/")[0]
    caminho = v.replace(/[^\/]*/, "")
    dominio = dominio.replace(/[^\w\.\+-:@]/g, "")
    caminho = caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g, "")
    caminho = caminho.replace(/([\?&])=/, "$1")
    if (caminho != "") dominio = dominio.replace(/\.+$/, "")
    v = "http://" + dominio + caminho
    return v
}

/*Função que padroniza DATA*/
function Data(v) {
    v = v.replace(/\D/g, "")
    v = v.replace(/(\d{2})(\d)/, "$1/$2")
    v = v.replace(/(\d{2})(\d)/, "$1/$2")
    return v

}
/*Função que padroniza Ano em Mês*/
function AnoMes(v) {
    v = v.replace(/\D/g, "");
    v = v.replace(/(\d{2})(\d)/, "$1/$2");
    return v;
}

/*Função que padroniza Hora*/
function Hora(v) {
    v = v.replace(/\D/g, "")
    v = v.replace(/(\d{2})(\d)/, "$1:$2")
    return v
}

/*Validar hora*/
function Verifica_Hora(campo) {

    hrs = (campo.value.substring(0, 2));
    min = (campo.value.substring(3, 5));
    estado = "";
    if ((hrs < 00) || (hrs > 23) || (min < 00) || (min > 59)) {
        estado = "errada";
    }

    if (campo.value == "") {
        estado = "errada";
    }
    if (estado == "errada") {
        alert("Hora inválida.");
        //campo.focus();  
    }
}

/*Função que padroniza valor monétario*/
function Valor(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/, "$1.$2");
    //v=v.replace(/(\d{3})(\d)/g,"$1,$2")
    v = v.replace(/(\d)(\d{2})$/, "$1.$2") //Coloca ponto antes dos 2 últimos digitos
    return v
}

/*Função que padroniza Area*/
function Area(v) {
    v = v.replace(/\D/g, "")
    v = v.replace(/(\d)(\d{2})$/, "$1.$2")
    return v

}

function validarData(campo) {
    var expReg = /^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[1-2][0-9]\d{2})$/;
    var msgErro = 'Formato inválido de data.';
    if ((campo.value.match(expReg)) && (campo.value != '')) {
        var dia = campo.value.substring(0, 2);
        var mes = campo.value.substring(3, 5);
        var ano = campo.value.substring(6, 10);
        if (((mes == 4) || (mes == 6) || (mes == 9) || (mes == 11)) && (dia > 30)) {
            alert("O mês especificado contém no máximo 30 dias.");
            return false;
        } else {
            if ((ano % 4 != 0) && (mes == 2) && (dia > 28)) {
                alert("O mês especificado contém no máximo 28 dias.");
                return false;
            } else {
                if ((ano % 4 == 0) && (mes == 2) && (dia > 29)) {
                    alert("O mês especificado contém no máximo 29 dias.");
                    return false;
                } else {
                    return true;
                }
            }
        }
    } else {
        alert(msgErro);
        carregaData(campo);
        return false;
    }
}
/*Data Corrente*/
function carregaData(textbox) {
    var dataatual = new Date;
    var dia = dataatual.getDate().toString().length == 1 ? '0' + dataatual.getDate() : dataatual.getDate();
    var mes = (dataatual.getMonth() + 1).toString().length == 1 ? '0' + (dataatual.getMonth() + 1) : (dataatual.getMonth() + 1);
    var ano = dataatual.getFullYear();
    var textboxid = textbox.id;
    document.getElementById(textboxid).value = dia + "/" + mes + "/" + ano;
}

// Validação CNS
function VerificarCns(cnsParametro) {
    var cns = cnsParametro;
    var cnsInicio = cns.substring(0, 1);

    if (cnsInicio == 0) {
        var tamCNS = cns.length;
        if ((tamCNS) != 15) {
            alert("Tamanho do CNS inválido.");
            //document.getElementById("_edCNS").focus();
            return false;
        }
    }
    else if (cnsInicio == 1 || cnsInicio == 2) {
        validaCNS(cns);
    }
    else if (cnsInicio == 7 || cnsInicio == 8 || cnsInicio == 9) {
        ValidaCNS_PROV(cns);
    }
    else {
        alert("Número de CNS inválido.");
        //document.getElementById("_edCNS").focus();
        return false;
    }
}
function validaCNS(vlrCNS) {
    // Formulário que contem o campo CNS
    var soma = new Number;
    var resto = new Number;
    var dv = new Number;
    var pis = new String;
    var resultado = new String;
    var tamCNS = vlrCNS.length;
    if ((tamCNS) != 15) {
        alert("CNS inválido.");
        //document.getElementById("_edCNS").focus();
        return false;
    }
    pis = vlrCNS.substring(0, 11);
    soma = (((Number(pis.substring(0, 1))) * 15) +
            ((Number(pis.substring(1, 2))) * 14) +
            ((Number(pis.substring(2, 3))) * 13) +
            ((Number(pis.substring(3, 4))) * 12) +
            ((Number(pis.substring(4, 5))) * 11) +
            ((Number(pis.substring(5, 6))) * 10) +
            ((Number(pis.substring(6, 7))) * 9) +
            ((Number(pis.substring(7, 8))) * 8) +
            ((Number(pis.substring(8, 9))) * 7) +
            ((Number(pis.substring(9, 10))) * 6) +
            ((Number(pis.substring(10, 11))) * 5));
    resto = soma % 11;
    dv = 11 - resto;
    if (dv == 11) {
        dv = 0;
    }
    if (dv == 10) {
        soma = (((Number(pis.substring(0, 1))) * 15) +
                ((Number(pis.substring(1, 2))) * 14) +
                ((Number(pis.substring(2, 3))) * 13) +
                ((Number(pis.substring(3, 4))) * 12) +
                ((Number(pis.substring(4, 5))) * 11) +
                ((Number(pis.substring(5, 6))) * 10) +
                ((Number(pis.substring(6, 7))) * 9) +
                ((Number(pis.substring(7, 8))) * 8) +
                ((Number(pis.substring(8, 9))) * 7) +
                ((Number(pis.substring(9, 10))) * 6) +
                ((Number(pis.substring(10, 11))) * 5) + 2);
        resto = soma % 11;
        dv = 11 - resto;
        resultado = pis + "001" + String(dv);
    } else {
        resultado = pis + "000" + String(dv);
    }
    if (vlrCNS != resultado) {
        alert("Número de CNS inválido");
        //document.getElementById("_edCNS").focus();
        return false;
    }
    else {
        if (window.event.keyCode == 13) { window.event.keyCode = 9; }
        return true;
    }
}

function ValidaCNS_PROV(Obj) {
    var pis;
    var resto;
    var dv;
    var soma;
    var resultado;
    var result;
    result = 0;

    var tamCNS = Obj.length;
    if ((tamCNS) != 15) {
        alert("Número de CNS inválido");
        //document.getElementById("_edCNS").focus();
        return false;
    }
    pis = Obj.substring(0, 15);

    if (pis == "") {
        //document.getElementById("_edCNS").focus();
        return false
    }

    if ((Obj.substring(0, 1) != "7") && (Obj.substring(0, 1) != "8") && (Obj.substring(0, 1) != "9")) {
        alert("Atenção! Número Provisório inválido.");
        //document.getElementById("_edCNS").focus();
        return false
    }

    soma = ((parseInt(pis.substring(0, 1), 10)) * 15)
            + ((parseInt(pis.substring(1, 2), 10)) * 14)
            + ((parseInt(pis.substring(2, 3), 10)) * 13)
            + ((parseInt(pis.substring(3, 4), 10)) * 12)
            + ((parseInt(pis.substring(4, 5), 10)) * 11)
            + ((parseInt(pis.substring(5, 6), 10)) * 10)
            + ((parseInt(pis.substring(6, 7), 10)) * 9)
            + ((parseInt(pis.substring(7, 8), 10)) * 8)
            + ((parseInt(pis.substring(8, 9), 10)) * 7)
            + ((parseInt(pis.substring(9, 10), 10)) * 6)
            + ((parseInt(pis.substring(10, 11), 10)) * 5)
            + ((parseInt(pis.substring(11, 12), 10)) * 4)
            + ((parseInt(pis.substring(12, 13), 10)) * 3)
            + ((parseInt(pis.substring(13, 14), 10)) * 2)
            + ((parseInt(pis.substring(14, 15), 10)) * 1);

    resto = soma % 11;

    if (resto == 0) {
        if (window.event.keyCode == 13) { window.event.keyCode = 9; }
        return true;
    }
    else {
        alert("Atenção! Número Provisório inválido.");
        //document.getElementById("_edCNS").focus();
        return false;
    }
}

function Mascara1(tipo, campo, teclaPress) {
    if (window.event) {
        var tecla = teclaPress.keyCode;
    } else {
        tecla = teclaPress.which;
    }

    var s = new String(campo.value);
    // Remove todos os caracteres à seguir: ( ) / - . e espaço, para tratar a string denovo.
    s = s.replace(/(\.|\(|\)|\/|\-| )+/g, '');

    //tam = s.length + 1;
    tam = campo.value.length;
    if (tecla != 9 && tecla != 8) {
        switch (tipo) {
            case 'CentroCusto':


                if (tam == 1)
                    campo.value = campo.value + '.';
                if (tam == 3)
                    campo.value = campo.value + '.';
                if (tam == 6)
                    campo.value = campo.value + '.';
                if (tam == 9)
                    campo.value = campo.value + '.';
                break;

            case 'CPF':

                if (tam == 3)
                    campo.value = campo.value + '.';
                if (tam == 7)
                    campo.value = campo.value + '.';
                if (tam == 11)
                    campo.value = campo.value + '-';

                break;

            case 'CNPJ':

                if (tam > 2 && tam < 6)
                    campo.value = s.substr(0, 2) + '.' + s.substr(2, tam);
                if (tam >= 6 && tam < 9)
                    campo.value = s.substr(0, 2) + '.' + s.substr(2, 3) + '.' + s.substr(5, tam - 5);
                if (tam >= 9 && tam < 13)
                    campo.value = s.substr(0, 2) + '.' + s.substr(2, 3) + '.' + s.substr(5, 3) + '/' + s.substr(8, tam - 8);
                if (tam >= 13 && tam < 15)
                    campo.value = s.substr(0, 2) + '.' + s.substr(2, 3) + '.' + s.substr(5, 3) + '/' + s.substr(8, 4) + '-' + s.substr(12, tam - 12);
                break;

            case 'TEL':
                if (tam > 2 && tam < 4)
                    campo.value = '(' + s.substr(0, 2) + ') ' + s.substr(2, tam);
                if (tam >= 7 && tam < 11)
                    campo.value = '(' + s.substr(0, 2) + ') ' + s.substr(2, 4) + '-' + s.substr(6, tam - 6);
                break;

            case 'DATA':
                if (tam > 2 && tam < 4)
                    campo.value = s.substr(0, 2) + '/' + s.substr(2, tam);
                if (tam > 4 && tam < 11)
                    campo.value = s.substr(0, 2) + '/' + s.substr(2, 2) + '/' + s.substr(4, tam - 4);
                break;

            case 'ISCRICAOMUNICIPAL':
                if (tam == 2)
                    campo.value = campo.value + '.';
                if (tam == 5)
                    campo.value = campo.value + '.';

                break;

            case 'ISCRICAOESTADUAL':
                if (tam == 3)
                    campo.value = campo.value + '.';
                if (tam == 10)
                    campo.value = campo.value + '.';

                break;

            case 'NUMSERIE_CTPS':
                if (tam == 7)
                    campo.value = campo.value + '/';


                break;

            case 'CODIGORCAMENTARIO':
                if (tam == 4)
                    campo.value = campo.value + '.';
                if (tam == 7)
                    campo.value = campo.value + '.';

                break;

            case 'DATAMES':
                if (tam > 2 && tam < 4)
                    campo.value = s.substr(0, 2) + '/' + s.substr(2, tam);
                break;

            case 'CEP':
                if (tam == 5)
                    campo.value = campo.value + '-';
                break;
        }
    }
}


