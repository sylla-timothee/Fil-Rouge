import { SERV } from './call_server.js';

document.addEventListener('DOMContentLoaded', async () => {
    try {
        await SERV.auth.session();
        window.location.href = 'properties.html';
        return;
    } catch {

    document.getElementById("registerForm").addEventListener("submit", async e => {
        e.preventDefault();

        const msg = document.getElementById("formMessage");

        try {
            const data = await SERV.auth.register({
                firstName : document.getElementById("firstName").value,
                lastName  : document.getElementById("lastName").value,
                email     : document.getElementById("email").value,
                password  : document.getElementById("password").value,
            });

            msg.style.color = 'green';
            msg.textContent = "Compte créé avec succès !";
            setTimeout(() => window.location.href = "login.html", 1500);

        } catch (error) {
            msg.style.color = 'red';
            msg.textContent = error.message;
        }
    });
}
});