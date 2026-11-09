const sidebar = document.querySelector('#app-sidebar');
const sidebarOverlay = document.querySelector('[data-sidebar-overlay]');
const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
const sidebarClose = document.querySelector('[data-sidebar-close]');

function closeSidebar() {
    sidebar?.classList.add('-translate-x-full');
    sidebarOverlay?.classList.add('hidden');
    sidebarToggle?.setAttribute('aria-expanded', 'false');
    sidebarToggle?.focus({ preventScroll: true });
}

sidebarToggle?.addEventListener('click', () => {
    const isOpen = sidebarToggle.getAttribute('aria-expanded') === 'true';

    if (isOpen) {
        closeSidebar();
        return;
    }

    sidebar?.classList.remove('-translate-x-full');
    sidebarOverlay?.classList.remove('hidden');
    sidebarToggle.setAttribute('aria-expanded', 'true');
});

sidebarClose?.addEventListener('click', closeSidebar);
sidebarOverlay?.addEventListener('click', closeSidebar);

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeSidebar();
    }
});
