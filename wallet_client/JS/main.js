const navItems = document.querySelector('.nav_items');
const openNavBtn = document.querySelector('#open_nav_btn');
const closeNavBtn = document.querySelector('#close_nav_btn');
const signUpForm = document.getElementById("signupForm");
const signInForm = document.getElementById("signInForm");
const signUpSuccessAlert = document.getElementById("signUpSuccessAlert");
const signUpErrorAlert = document.getElementById("signUpErrorAlert");
const signInErrorAlert = document.getElementById("signInErrorAlert");
const signedInNavLinks = document.querySelectorAll("signed_in_nav_links");
const logoutButton = document.getElementById("logoutButton");

//declaring profile info elements
const fullname = document.getElementById('fullname');
const email = document.getElementById('email');
const phoneNumber = document.getElementById('phoneNumber');
const address = document.getElementById('address');
const profilePicture = document.getElementById('profilePicture');

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


async function fetchUserDetails(userId) {
    axios.post("http://localhost/digital_wallet/wallet_server/apis/getUser.php", {userId})
    .then ((response) => {
        const data = response.data;
        console.log("response dta in fetchuser: " + data);
        return response.data;
    }
)}

function updateUserProfile(user) {
    fullname.innerText = user.full_name;
    email.textContent = user.email;
    phoneNumber.textContent = user.phone_number;
    address.textContent = user.address;
    profilePicture.src = user.profile_picture; /* || "default.png"; */ // Use default image if none exists
}

async function checkAuthentication () {
    axios.post("http://localhost/digital_wallet/wallet_server/apis/auth.php")
    .then(async (authResponse) => {
        if(authResponse.data.status === "authorized") {
            let userId = authResponse.data.userId;
            if(userId) {
                let user = await fetchUserDetails(userId);
                console.log("authrespose result: " + user);
                updateUserProfile(user);
            }
        } else {
            console.log("user unauthorized");
        }
    })
}

/* document.addEventListener("DOMContentLoaded", checkAuthentication); */


document.addEventListener("DOMContentLoaded", () => {

    checkAuthentication();

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

                if(result.status === "success") {
                    window.location.href = "http://localhost/digital_wallet/wallet_client/signin.html";
                } else {
                    document.getElementById("signUpErrorAlert").style.display = "block";
                    document.getElementById("signUpErrorAlert").textContent = result.message;
                }
            })
        })
    }

    if (document.body.id === "signInPage") { 
        signInForm.addEventListener("submit", async (event) => {
            event.preventDefault(); // Prevent the form from submitting the default way

            const formData = new FormData(event.target);
            //no need to pass the content type because axios by default deal with it as json object
            axios.post("http://localhost/digital_wallet/wallet_server/apis/signin.php", formData)
            .then((response) => {
                
                //axios already parses the response makimg it json so no need to add .json() method
                const result = response.data;
            
                if(result.status === "success") {
                    window.location.href = "../wallet_client/dashboard.html";
                } else {
                    document.getElementById("signInErrorAlert").style.display = "block";
                    document.getElementById("signInErrorAlert").textContent = result.message;
                }
            })
        })
    }

    logoutButton.addEventListener("click", async () => {
        if(logoutButton) {
            axios.post("http://localhost/digital_wallet/wallet_server/apis/logout.php")
                .then(response => {
                    const result = response.data;
                    if(result.status === "success") {
                        window.location.href = "http://localhost/digital_wallet/wallet_client/signin.html";
                    }
            })
        }
    })
    
})




