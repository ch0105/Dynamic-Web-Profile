// Toggle class active
const sidebar = document.querySelector('.aside');

// Ketika hamburger menu di klik
document.querySelector('#hamburger-menu').onclick = () => {
    sidebar.classList.toggle('active');
};

// Klik di luar sidebar
const hamburger = document.querySelector('#hamburger-menu');

document.addEventListener('click', function(e) {
    if(!hamburger.contains(e.target) && !sidebar.contains(e.target)) {
        sidebar.classList.remove('active');
    };
});
