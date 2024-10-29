console.log("Hello");

const nameField = document.getElementById("nome");
const emailField = document.getElementById("email");
const telefoneField = document.getElementById("telefone");
const cpfField = document.getElementById("cpf");
const senhaField = document.getElementById("senha");
const confirmSenhaField = document.getElementById("Confirmarsenha");
const rankField = document.getElementById("elo");
const msgError = document.getElementById("msg-error");

console.log(nameField);
console.log(emailField);
console.log(telefoneField);
console.log(cpfField);
console.log(rankField);
console.log(senhaField);
console.log(confirmSenhaField);
console.log(msgError);

rankField.addEventListener("change", (event) => {
  console.log(event.target.value);
  console.log(rankField.value);
});

const form = document.getElementById("form");

console.log(form);

function hasMinLetters(text) {
  let i = 0;
  while (text[i]) {
    if (text[i] >= "a" && text[i] <= "z") return true;
    i++;
  }
  return false;
}

function hasMaxLetters(text) {
  let i = 0;
  while (text[i]) {
    if (text[i] >= "A" && text[i] <= "Z") return true;
    i++;
  }
  return false;
}

function hasDigits(text) {
  let i = 0;
  while (text[i]) {
    if (text[i] >= "0" && text[i] <= "9") return true;
    i++;
  }
  return false;
}

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

senhaField.textContent;

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
