const navItems = document.querySelector('.nav_items');
const openNavBtn = document.querySelector('#open_nav_btn');
const closeNavBtn = document.querySelector('#close_nav_btn');


//open dropdown
const openNav = () => {
    navItems.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'inline-block'
}

//close nav dropdown
const closeNav = () => {
    navItems.style.display = 'none';
    openNavBtn.style.display = 'inline-block';
    closeNavBtn.style.display = 'none'
}

openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener('click', closeNav);


document.getElementById("signupForm").addEventListener("submit", async (even) => {
    event.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch ('/wallet_server/signup.php', {
            method:'POST',
            body: formData
        });

        const result = await response.json();

        if(result === "success") {
            document.querySelector(".alert_message.success").style.display = "block";
            document.querySelector(".alert_message.error").style.display = "none";
        } else {
            document.querySelector(".alert_message.success").style.display = "none";
            document.querySelector(".alert_message.error").style.display = "block";
            console.error(result.message);
        }

    } catch (error) {
        console.error("Error:", error)
    }
})