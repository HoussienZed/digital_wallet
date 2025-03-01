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


document.getElementById("signupForm").addEventListener("submit", async (event) => {
    event.preventDefault(); // Prevent the form from submitting the default way

    const formData = new FormData(event.target);

    axios.post("../wallet_server/apis/createUser.php", formData , {
        headers: {
            "Content-Type" : "multipart/form-data"
        }
    })
    .then((response) => {
        const result = response.data;

        if(result.status === "success") {
            document.querySelector(".alert_message.success").style.display = "block"; //i may delete this line later
            document.querySelector(".alert_message.error").style.display = "none";
            document.querySelector(".success_message").textContent = result.message;
        } else {
            document.querySelector(".alert_message.success").style.display = "none"; //i may delete this line later
            document.querySelector(".alert_message.error").style.display = "block";
            document.querySelector(".error_message").textContent = result.message;
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        document.querySelector(".alert_message.success").style.display = "none";
        document.querySelector(".alert_message.error").style.display = "block";
        document.querySelector(".error_message").textContent = "An error occurred. Please try again.";
    });
})