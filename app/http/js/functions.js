var BASE_URL = 'http://localhost/api';

function getUrl(url)
{
    return BASE_URL.concat(url);
}

function apiLogin()
{
    try {

        var username = document.getElementById("form-username").value;
        var password = document.getElementById("form-password").value;

        //console.log( username + ' ' + password);

        if(username == "" || password == "") {
            //alert('Please enter both a username and password');
            return;
        }

        let loginCredentials = { username: username, password: password };

        console.log(loginCredentials);

        fetch(getUrl('home/login'), {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(loginCredentials)
         }).then(async res => { 

            //var result = await res.json();

            var data = JSON.parse(await res.json());

            console.log('message data: ' . data['message']);

            var token = data['jwt'];
            sessionStorage.setItem("jwt", token);

            //$("#loginData").value(data); //voor een input-type=hidden op de homepage of in de header ofzo (of beter: dit niet doen en gewoon js session data gebruiken voor toekomtige api calls DAN HEB JE GEEN PHP $_SERVER VARS NODIG VOOR AUTH ZAKEN SANDER! BEGRIJP DAT DAN JIJ SUFFERD DIE JE BENT!!!!)
        
            sessionStorage.setItem("jwtAndUserData", JSON.stringify(result));
    
         });

         return;
    }
    catch(error) {
        console.log('An error occurred: ' + error.message());

        /*var errorSection = document.getElementById("login-error");
        errorSection.style.display = 'inline';*/
        return;
    }
}


function highlightActivePage()
{
    var view_page_element = document.getElementById("nav-current-page");
    var current_page = view_page_element.getAttribute("name");

    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");

    var current_nav_page = document.getElementById(current_page);
    current_nav_page.className += " active";
}