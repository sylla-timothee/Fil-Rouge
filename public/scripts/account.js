import { SERV } from './call_server.js';

document.addEventListener('DOMContentLoaded', async () => {

    try {
        const data = await SERV.account.get_profile();

        document.getElementById("user-name").textContent  = data.firstName;
        document.getElementById("user-email").textContent = data.email;

    } catch (error) {
        console.error(error.message);
    }
});