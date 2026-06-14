import { SERV } from './call_server.js';

document.addEventListener('DOMContentLoaded', async () => {
    try {
        const data = await SERV.account.get_profile();

        const nameElem = document.getElementById("user-name");
        const emailElem = document.getElementById("user-email");

        if (nameElem)  nameElem.textContent = data.first_name;
        if (emailElem) emailElem.textContent = data.email;

    } catch (error) {
        console.error("Erreur lors de la récupération du profil :", error.message);
    }
});