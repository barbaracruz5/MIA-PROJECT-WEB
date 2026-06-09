function validarForm() {
    let nome = document.getElementById("nome").value;
    let email = document.getElementById("email").value;
    let mensagem = document.getElementById("mensagem").value;

    if (nome.length < 3) {
        alert("Preencha com o seu nome completo");
        return false; 
    }
    if (!email.includes("@")) {
        alert("Email inválido");
        return false;
    }
    if (mensagem.trim() === "") {
        alert("Escreva uma mensagem");
        return false;
    }
    return true; 
}



