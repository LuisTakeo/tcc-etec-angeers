const colors = ['#E6E6FA', '#ffffff','#E6E6FA', '#ffffff' ,	'#E6E6FA'];
let currentIndex = 0;

function changeColor() {
    const h1 = document.querySelector('.banner h1');
    h1.style.color = colors[currentIndex];
    currentIndex = (currentIndex + 1) % colors.length;
}

setInterval(changeColor, 1000);
