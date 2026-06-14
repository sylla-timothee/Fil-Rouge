import { SERV } from './call_server.js';

const isRoot = !window.location.pathname.includes('/pages/');
const BASE   = isRoot ? 'frontend/pages/' : '';
const HOME   = isRoot ? 'index.html'      : '../../index.html';

async function logout() {
    try { await SERV.auth.logout(); } catch {}
    localStorage.removeItem('token');
    window.location.href = BASE + 'login.html';
}

function getCurrentPage() {
    return window.location.pathname.split('/').pop() || 'index.html';
}

function link(href, label, currentPage) {
    const hrefPage = href.split('/').pop();
    const isCurrent = hrefPage === currentPage;
    return `<a href="${href}"${isCurrent ? ' aria-current="page"' : ''}>${label}</a>`;
}

function updateNav(currentUser) {
    const nav = document.getElementById('nav-links');
    if (!nav) return;

    const page = getCurrentPage();

    if (currentUser) {
        nav.innerHTML = `
            ${link(HOME,                    'Accueil',        page)}
            ${link(BASE + 'properties.html','Propriétés',     page)}
            ${link(BASE + 'dashboard.html', 'Tableau de bord',page)}
            <button id="logoutBtn">Déconnexion</button>
        `;
        document.getElementById('logoutBtn').addEventListener('click', logout);
    } else {
        nav.innerHTML = `
            ${link(HOME,                    'Accueil',   page)}
            ${link(BASE + 'login.html',     'Connexion', page)}
            ${link(BASE + 'register.html',  'Inscription',page)}
            ${link(BASE + 'properties.html','Propriétés', page)}
        `;
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    let currentUser = null;
    try {
        const data = await SERV.auth.session();
        currentUser = data.user ?? null;
    } catch {}
    updateNav(currentUser);
});