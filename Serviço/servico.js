document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('scrollButton').addEventListener('click', scrollToServices);
});

function scrollToServices() {
    document.getElementById('services').scrollIntoView({ behavior: 'smooth' });
}
