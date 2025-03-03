const navItems = document.querySelector('.nav_items');
const openNavBtn = document.querySelector('#open_nav_btn');
const closeNavBtn = document.querySelector('#close_nav_btn');
const signUpForm = document.getElementById("signupForm");
const signInForm = document.getElementById("signInForm");
const signUpSuccessAlert = document.getElementById("signUpSuccessAlert");
const signUpErrorAlert = document.getElementById("signUpErrorAlert");
const signInErrorAlert = document.getElementById("signInErrorAlert");
/* const signInPage = document.getElementById("signInPage");
const signUpPage = document.getElementById("signUpPage") */;


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
    if (document.body.id === "signUpPage") { 
        /* const signUpForm = document.getElementById("signUpForm"); */
        signUpForm.addEventListener("submit", async (event) => {
            event.preventDefault(); // Prevent the form from submitting the default way

            const formData = new FormData(event.target);

            console.log("event loaded successfully");

            axios.post("http://localhost/digital_wallet/wallet_server/apis/createUser.php", formData , {
                headers: {
                    "Content-Type" : "multipart/form-data"
                } 
            })
            .then((response) => {
                //axios already parses the response makimg it json so no need to add .json() method
                const result = response.data;

                console.log(typeof(result));

                if(result.status === "success") {
                    console.log("iam above window .location");
                    window.location.href = "http://localhost/digital_wallet/wallet_client/signin.html";
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


document.addEventListener("DOMContentLoaded", () => {
    if (document.body.id === "signInPage"/*  && signInForm */) { 
        signInForm.addEventListener("submit", async (event) => {
            event.preventDefault(); // Prevent the form from submitting the default way

            const formData = new FormData(event.target);


            //no need to pass the content type because axios by default deal with it as json object
            axios.post("http://localhost/digital_wallet/wallet_server/apis/signin.php", formData/*  , {
                headers: {
                    "Content-Type" : "application/json"
                }
            } */)
            .then((response) => {
                //axios already parses the response makimg it json so no need to add .json() method
                const result = response.data;

                console.log(result);

                if(result.status === "success") {
                    window.location.href = "../wallet_client/dashboard.html";
                } else {
                    document.getElementById("signInErrorAlert").style.display = "block";
                    document.getElementById("signInErrorAlert").textContent = result.message;
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