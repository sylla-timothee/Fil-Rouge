document.getElementById("logoutBtn").addEventListener("click", () => {
    logout()
})

async function logout() {
    try {
        await SERV.auth.logout();
    } catch (e) {}
    window.location = 'login.html';
}