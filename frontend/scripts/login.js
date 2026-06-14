import { SERV } from './call_server.js';

document.addEventListener('DOMContentLoaded', () => { 

    const loginForm = document.getElementById("loginForm");
    const msg = document.getElementById("formMessage");

    // 1. On active l'écouteur du formulaire
    if (loginForm) {
        loginForm.addEventListener("submit", async e => {
            e.preventDefault();

            try {
                const data = await SERV.auth.login({
                    email     : document.getElementById("email").value,
                    password  : document.getElementById("password").value,
                });

                if (data && data.token) {
                    localStorage.setItem('token', data.token);
                }

                msg.style.color = 'green';
                msg.textContent = "Connecté avec succès !";
                
                setTimeout(() => window.location.href = "properties.html", 1500);

            } catch (error) {
                msg.style.color = 'red';
                msg.textContent = error.message;
            }
        });
    }

    const checkActiveSession = async () => {
        try {
            await SERV.auth.session();
            window.location.href = 'properties.html';
        } catch (err) {
            console.log("Aucune session active, veuillez vous connecter.");
        }
    };

    checkActiveSession();
});