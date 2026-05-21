document.addEventListener('DOMContentLoaded', async () => {
    const user = await initPage();

    if (!requireGuest(user)) {
        return;
    }

document.getElementById("loginForm").addEventListener("submit", async e => {
  e.preventDefault();

      const nameInput = document.getElementById("name");
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");

      const data = await SERV.auth.login({
        name: nameInput.value,
        email: emailInput.value,
        password: passwordInput.value,
      });

  if (data.success) {
    console.log("LOGIN RESPONSE:", data);
    localStorage.setItem("IdUser", data.IdUser);
    window.location.href = "account.html";
  } else {
    console.log("oops")
    alert(data.error);
  }
})
});
