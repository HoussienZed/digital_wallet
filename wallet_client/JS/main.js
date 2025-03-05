const navItems = document.querySelector('.nav_items');
const openNavBtn = document.querySelector('#open_nav_btn');
const signUpForm = document.getElementById("signupForm");
const signInForm = document.getElementById("signInForm");
const closeNavBtn = document.querySelector('#close_nav_btn');
const logoutButton = document.getElementById("logoutButton");
const signUpErrorAlert = document.getElementById("signUpErrorAlert");
const signInErrorAlert = document.getElementById("signInErrorAlert");
const signedInNavLinks = document.querySelectorAll("signed_in_nav_links");
const signUpSuccessAlert = document.getElementById("signUpSuccessAlert");


//declaring profile info elements
const email = document.getElementById('email');
const address = document.getElementById('address');
const fullname = document.getElementById('fullname');
const phoneNumber = document.getElementById('phoneNumber');
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
    
    console.log("sending userid: ", userId);
    
    const response =  await axios.post(
        "http://13.39.112.176/digital_wallet/wallet_server/apis/getUser.php", 
        {user: userId}, 
        {headers: {
            'Content-Type': 'application/json' // Request headers
        }})
        
    console.log("sending userid: ", userId);
        
    const detail = response.data;
    console.log("fetch response :" + detail);
    return detail;
}



function updateUserProfile(user) {
    email.textContent = user.email;
    profilePicture.src = user.profile_picture; /* || "default.png"; */ // Use default image if none exists
    address.textContent = user.address;
    fullname.textContent = user.full_name;
    phoneNumber.textContent = user.phone_number;

}

async function checkAuthentication () {
    const authResponse = await axios.post("http://13.39.112.176/digital_wallet/wallet_server/apis/auth.php")

    if(authResponse.data.status === "authorized") {
        let userId = authResponse.data.userId; 
        console.log("check auth", userId); // user id is correct
        
        if(userId) {
            console.log("before fetchuser");
            const response = await fetchUserDetails(userId);
            console.log("after fetchuser so it is working properly");
            console.log("after fetching user response =", response);
            updateUserProfile(response);
        }
    } else {
        console.log("user unauthorized");
    }
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

            const response = await axios.post("http://13.39.112.176/digital_wallet/wallet_server/apis/createUser.php", formData , {
                headers: {
                    "Content-Type" : "multipart/form-data"
                } 
            })
            
            //axios already parses the response makimg it json so no need to add .json() method
            const result = response.data;

            if(result.status === "success") {
                window.location.href = "http://localhost/digital_wallet/wallet_client/signin.html";
            } else {
                document.getElementById("signUpErrorAlert").style.display = "block";
                document.getElementById("signUpErrorAlert").textContent = result.message;
            }
        })
    }

    if (document.body.id === "signInPage") { 
        signInForm.addEventListener("submit", async (event) => {
            event.preventDefault(); // Prevent the form from submitting the default way

            const formData = new FormData(event.target);
            //no need to pass the content type because axios by default deal with it as json object
            const response = await axios.post("http://13.39.112.176/digital_wallet/wallet_server/apis/signin.php", formData)
                
            //axios already parses the response makimg it json so no need to add .json() method
            const result = response.data;
            
            if(result.status === "success") {
                window.location.href = "../wallet_client/dashboard.html";
            } else {
                document.getElementById("signInErrorAlert").style.display = "block";
                document.getElementById("signInErrorAlert").textContent = result.message;
            }
        })
    }
    

    logoutButton.addEventListener("click", async () => {
        if(logoutButton) {
            const response = await axios.post("http://13.39.112.176/digital_wallet/wallet_server/apis/logout.php")
            result = response.data;
            if(result.status === "success") {
                window.location.href = "http://localhost/digital_wallet/wallet_client/signin.html";
            }
        }
    })
})




