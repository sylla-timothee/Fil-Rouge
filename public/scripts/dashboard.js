import { SERV } from './call_server.js';

const infoContainer = document.getElementById("user-info")

document.addEventListener('DOMContentLoaded', async () => {

    try {
        const data = await SERV.account.get_profile();
        console.log("Données reçues")
    } catch (error) {
        console.error(error.message)
    }

    if (data) {
        document.getElementById("user-name").textContent = data.firstName;
                document.getElementById("user-email").textContent = data.email;
            } else {
                console.error("Erreur de récupération :", data.error);
            }
        })