/* Função para aceitar somente números nos inputs */
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    let charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
/* números e ponto*/
function isNumberAndDot(evt) {
    evt = (evt) ? evt : window.event;
    let charCode = (evt.which) ? evt.which : evt.keyCode;
    if(charCode === 46) {
        return true;
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

/* Enviar formulário com tecla Enter */
document.addEventListener('keydown', function(e) {
    if(e.key === 'Enter'){
        document.getElementById("submitWithEnter").click();
    }
});

/* Confirmar logout*/
function confirmlogout(x) {
    if (confirm("Tem certeza que deseja fazer logout?")) {
        location.href= x ;
    }
}
/* Confirmar exclusão do analista */
function confirmremove(x) {
    if (confirm("Tem certeza que deseja excluir sua conta?")) {
        location.href= "removerAnalista.php"+ x ;
    }
}

/** Confere se a senha e confirmacao de senha sao iguais */

function validadePassoword() {

    let senha = document.getElementById('senha');
    let senhaC = document.getElementById('senha-confirma');

    function validarSenha() {
        if (senha.value != senhaC.value) {
            senhaC.setCustomValidity("Senhas diferentes!");
            senhaC.reportValidity();
            return false;
        } else {
            senhaC.setCustomValidity("");
            return true;
        }
    }

    validarSenha();

    // verificar também quando o campo for modificado, para que a mensagem suma quando as senhas forem iguais
    senhaC.addEventListener('input', validarSenha);
}
