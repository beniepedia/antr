import './bootstrap';
import "flyonui/flyonui"

const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebar-toggle');
const overlay = document.getElementById('overlay');
const themeToggle = document.getElementById('theme-toggle');
const html = document.documentElement;
const sidebarMenu = document.getElementById('sidebar-menu');

function toggleSidebar() {
    sidebar.classList.toggle('sidebar-closed');
    if (window.innerWidth < 768) {
        overlay.classList.toggle('hidden', sidebar.classList.contains('sidebar-closed'));
    }
}

// Initially hide sidebar on mobile
if (window.innerWidth < 768) {
    setTimeout(() => {
        sidebar.classList.add('sidebar-closed');
        overlay.classList.add('hidden');
    }, 100);
}

sidebarToggle.addEventListener('click', toggleSidebar);
overlay.addEventListener('click', toggleSidebar);

// Theme toggle
themeToggle.addEventListener('click', () => {
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
});

// Active menu item
const currentUrl = window.location.pathname;
const menuLinks = sidebarMenu.querySelectorAll('a');

menuLinks.forEach(link => {
    if (link.getAttribute('href') === currentUrl) {
        link.classList.add('active');
    }
});