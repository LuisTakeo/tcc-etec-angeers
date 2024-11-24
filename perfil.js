const list = document.querySelector(".header__box__options");
const perfilLink = document.querySelector(".perfil");
perfilLink.addEventListener("click", () => {
  list.classList.toggle("active");
});

const originalSrc = document.getElementById("preview").src;

function validateImage(event) {
  const file = event.target.files[0];
  const validExtensions = [
    "image/jpeg",
    "image/png",
    "image/gif",
    "image/bmp",
    "image/webp",
    "image/tiff",
  ];

  if (!file.type.startsWith("image/")) {
    alert("Invalid file type. Only image files are allowed.");
    resetImage();
    return;
  }

  previewImage(event);
}

function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function () {
    const output = document.getElementById("preview");
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}

function resetImage() {
  const output = document.getElementById("preview");
  output.src = originalSrc;
  document.querySelector(".account-settings-fileinput").value = "";
}
