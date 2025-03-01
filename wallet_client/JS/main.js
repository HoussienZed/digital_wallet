const navItems = document.querySelector('.nav_items');
const openNavBtn = document.querySelector('#open_nav_btn');
const closeNavBtn = document.querySelector('#close_nav_btn');
const signUpForm = document.getElementById("signupForm");
const signUpSuccessAlert = document.getElementById("signUpSuccessAlert");
const signUpErrorAlert = document.getElementById("signUpErrorAlert");


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


document.addEventListener("DOMContentLoaded", () => {
    // Check if we are on the signup page by checking the URL
    if (window.location.pathname.includes("signup.html")) { 
        /* const signUpForm = document.getElementById("signUpForm"); */
        signUpForm.addEventListener("submit", async (event) => {
            event.preventDefault(); // Prevent the form from submitting the default way

            const formData = new FormData(event.target);

            console.log(formData);

            axios.post("http://localhost/digital_wallet/wallet_server/apis/createUser.php", formData , {
                headers: {
                    "Content-Type" : "multipart/form-data"
                }
            })
            .then((response) => {
                const result = response.data;

                if(result.status === "success") {
                    window.location.href = "../wallet_client/signin.html";
                } else {
                    document.getElementById("signUpErrorAlert").style.display = "block";
                    document.getElementById("signUpErrorAlert").textContent = result.message;
                }
            })
            /* .catch((error) => {
                console.error("Error:", error);
                document.querySelector(".alert_message.success").style.display = "none";
                document.querySelector(".alert_message.error").style.display = "block";
                document.querySelector(".error_message").textContent = "An error occurred. Please try again.";
            }); */
        })
    }
})
