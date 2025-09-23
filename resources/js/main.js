

document.addEventListener("DOMContentLoaded", () => {
    const html = document.documentElement;

    // Theme toggle
    const savedTheme = localStorage.getItem("theme") || "light";
    html.setAttribute("data-theme", savedTheme);

    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebar-toggle");
    const overlay = document.getElementById("overlay");
    const themeToggle = document.getElementById("theme-toggle");
    const sidebarMenu = document.getElementById("sidebar-menu");

    function toggleSidebar() {
        if (sidebar) {
            sidebar.classList.toggle("hidden");
        }
    }



    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", toggleSidebar);
    }
    if (overlay) {
        overlay.addEventListener("click", toggleSidebar);
    }

    if (themeToggle) {
        themeToggle.addEventListener("click", () => {
            const currentTheme = html.getAttribute("data-theme");
            const newTheme = currentTheme === "black" ? "light" : "black";
            html.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);
        });
    }

    // Active menu item
    if (sidebarMenu) {
        const currentUrl = window.location.pathname;
        const menuLinks = sidebarMenu.querySelectorAll("a");

        menuLinks.forEach((link) => {
            if (link.getAttribute("href") === currentUrl) {
                link.classList.add("active");
            }
        });
    }
});
