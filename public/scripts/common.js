import { SERV } from './call_server.js';

async function logout() {
    try {
        await SERV.auth.logout();
    } catch {}
    window.location = 'properties.html';
}

document.addEventListener("DOMContentLoaded", async () => {
    let currentUser;
    try {
        const data = await SERV.auth.session();
        currentUser = data.user ?? null;
    } catch {
        currentUser = null;
    }
    updateNav(currentUser);
    return currentUser;
})

function updateNav(currentUser) {
    const navLinks = document.getElementById('nav-links');
    let nav;
    if (currentUser) {
        nav = `<button><a href="dashboard.html">Dashboard</a></button>
               <button id="logoutBtn">Logout</button>
                `
    } else {
        nav = `<button><a href="login.html">Se connecter</a></button>
                    <button><a href="register.html">S'inscrire</a></button>`
    }

    navLinks.innerHTML = nav

    if (currentUser) {
        document.getElementById("logoutBtn").addEventListener("click", () => {
            logout();
        });
    }
}