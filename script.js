/* Função para aceitar somente números nos inputs */
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
/* números e ponto*/
function isNumberAndDot(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
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
function confirmlogout() {
    if (confirm("Tem certeza que deseja fazer logout?")) {
        location.href="../logout.php";
    }
}
function confirmlogout2() {
    if (confirm("Tem certeza que deseja fazer logout?")) {
        location.href="../../logout.php";
    }
}