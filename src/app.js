// Enhanced Profile Menu with Click Outside
function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    menu.classList.toggle('hidden');
    
    // Close menu when clicking outside
    const closeMenu = (e) => {
        if (!menu.contains(e.target) && !e.target.closest('button')) {
            menu.classList.add('hidden');
            document.removeEventListener('click', closeMenu);
        }
    };
    
    if (!menu.classList.contains('hidden')) {
        setTimeout(() => {
            document.addEventListener('click', closeMenu);
        }, 0);
    }
}

const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const toggleIcon = document.getElementById('toggleIcon');
let isSidebarCollapsed = false;

function toggleSidebar() {
isSidebarCollapsed = !isSidebarCollapsed;
sidebar.classList.toggle('collapsed');
toggleIcon.style.transform = isSidebarCollapsed ? 'rotate(180deg)' : '';
}

function toggleMobileSidebar() {
sidebar.classList.toggle('mobile-open');
overlay.classList.toggle('active');
}

function closeMobileSidebar() {
sidebar.classList.remove('mobile-open');
overlay.classList.remove('active');
}

function toggleSubmenu(id) {
const submenu = document.getElementById(id);
const allSubmenus = document.querySelectorAll('.submenu');
const menuArrow = submenu.previousElementSibling.querySelector('.menu-arrow');

allSubmenus.forEach(menu => {
    if (menu.id !== id && !menu.classList.contains('open')) {
    menu.classList.remove('open');
    const arrow = menu.previousElementSibling.querySelector('.menu-arrow');
    arrow.style.transform = '';
    }
});

submenu.classList.toggle('open');
menuArrow.style.transform = submenu.classList.contains('open') ? 'rotate(180deg)' : '';
}

// Handle window resize
window.addEventListener('resize', () => {
if (window.innerWidth >= 768) {
    closeMobileSidebar();
}
});

