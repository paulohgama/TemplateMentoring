import { userInfo } from "os";

var tempoDeEspera = 600000;
var timeout = setTimeout(inativo, tempoDeEspera);

function actividade(e) {
    clearInterval(timeout);
    timeout = setTimeout(inativo, tempoDeEspera);
    // só para o exemplo
    console.log('Houve actividade de ' + (e.type == 'keyup' ? 'teclado' : 'ponteiro'));
}

function inativo() {
    // LOGOUT
}

['keyup', 'touchmove' in window ? 'touchmove' : 'mousemove', "onwheel" in document.createElement("div") ? "wheel" : document.onmousewheel !== undefined ? "mousewheel" : "DOMMouseScroll"].forEach(function(ev) {
    window.addEventListener(ev, actividade);
});

window.addEventListener('beforeunload', function() {
    CreateConnectionSocket.emit('disconnect', idUser);
    return true;
});