// console.log("Hello");

// constantes para os campos do formulário
const nameField = document.getElementById("nome");
const emailField = document.getElementById("email");
const telefoneField = document.getElementById("telefone");
const cpfField = document.getElementById("cpf");
const senhaField = document.getElementById("senha");
const confirmSenhaField = document.getElementById("Confirmarsenha");
const rankField = document.getElementById("elo");
const msgError = document.getElementById("msg-error");
const form = document.getElementById("form");

rankField.addEventListener("change", (event) => {
  // console.log(event.target.value);
  // console.log(rankField.value);
});

// FUNÇÕES

// função para validar se o campo possui letras minusculas
function hasMinLetters(text) {
  let i = 0;
  while (text[i]) {
    if (text[i] >= "a" && text[i] <= "z") return true;
    i++;
  }
  return false;
}

// função para validar se o campo possui letras maiusculas
function hasMaxLetters(text) {
  let i = 0;
  while (text[i]) {
    if (text[i] >= "A" && text[i] <= "Z") return true;
    i++;
  }
  return false;
}

// função para validar se o campo possui digitos
function hasDigits(text) {
  let i = 0;
  while (text[i]) {
    if (text[i] >= "0" && text[i] <= "9") return true;
    i++;
  }
  return false;
}

// função para validar a senha
// a senha deve ter no mínimo 12 caracteres
// a senha deve ter no mínimo uma letra minuscula
// a senha deve ter no mínimo uma letra maiuscula
// a senha deve ter no mínimo um digito
function validatePassword(password) {
  if (password.length < 12) {
    console.log("Insira uma senha maior");
    // alert("Insira uma senha maior");
    msgError.textContent = "Insira uma senha maior";
    return false;
  }
  if (hasDigits(password) && hasMaxLetters(password) && hasMinLetters(password))
    return true;
  console.log(
    "Insira pelo menos uma letra maiuscula, uma minuscula e um número"
  );
  // alert("Insira pelo menos uma letra maiuscula, uma minuscula e um número")
  msgError.textContent =
    "Insira pelo menos uma letra maiuscula, uma minuscula e um número";
  return false;
}

// console.log(validatePassword("123123aaaaaaABCaaaaa"))

// LISTENERS

// listerner para o evento de submit do formulário
// o evento é capturado e é feito uma verificação se as senhas são iguais
// a qual chama a função de validação da senha
// se a senha for válida o formulário é submetido
form.addEventListener("submit", (event) => {
  event.preventDefault();
  if (senhaField.value !== confirmSenhaField.value) {
    event.preventDefault();
    console.log("senha não batem");
    // alert("senha não batem")
    msgError.textContent = "senha não batem";
    return false;
  }
  if (!validatePassword(senhaField.value)) {
    event.preventDefault();
    return false;
  }

  form.submit();
});
