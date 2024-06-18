document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var errorMessage = document.getElementById('error-message');


    if (username === 'summoner' && password === 'runes') {
        alert('Login bem-sucedido!');
   
        window.location.href = 'main.html';
    } else {
        errorMessage.textContent = 'Usuário ou senha incorretos';
        errorMessage.style.display = 'block';
    }
});
