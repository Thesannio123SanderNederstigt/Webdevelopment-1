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

        if(username == "" || password == "") {
            alert('Please enter both a username and password');
            return;
        }

        
        /*var baseURL = `<?php 
        $dotenv = Dotenv::createImmutable(__DIR__); 
        $dotenv->required('BASEURL');
        $dotenv->load();
        echo $_ENV['BASEURL'] ?>'`;
        */
        
        let loginCredentials = { username: username, password: password };

        fetch(/*baseURL.concat('home/login')*/ getUrl('home/login'), {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(loginCredentials)
         }).then(async res => { 

            //var result = await res.json();

            var data = JSON.parse(await res.json());

            console.log(data['message']); //to test? I guess idk or honestly really care anymore at this point...

            var token = data['jwt'];
            sessionStorage.setItem("jwt", token);

            $("#loginData").value(data); //voor een input-type=hidden op de homepage of in de header ofzo (of beter: dit niet doen en gewoon js session data gebruiken voor toekomtige api calls DAN HEB JE GEEN PHP $_SERVER VARS NODIG VOOR AUTH ZAKEN SANDER! BEGRIJP DAT DAN JIJ SUFFERD DIE JE BENT!!!!)
        
            sessionStorage.setItem("jwtAndUserData", JSON.stringify(result)); //get this data on the home page, put this in a input type=hidden and then set the HTTP_AUTHORIZATION header for PHP sessions? NOPE NIET NODIG GEWOON VANUIT JS GEBRUIKEN SANDER!
    
         });

         return;
    }
    catch(error) {
        console.log(error);

        var errorSection = document.getElementById("login-error");
        errorSection.style.display = 'inline';
        return;
        //print(error);
        //alert(error);
        //return;
    }
}

/*
function display_active_page()
{
  var view_page_element = document.getElementById("nav-current-page");
  var current_page = view_page_element.value;
  
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  
  console.log(current_nav_page);
  var current_nav_page = document.getElementById(current_page);
  current_nav_page.className += " active";
  
  //this.className += " active";
}
*/

//TWEE OPTIES: JS IN PHP GEBRUIKEN, OF (waar ik voor ga kiezen, nummer/optie twee): PHP INSERTEN IN DIT JS SCRIPT (NIET NETJES, MAAR WEL EEN OPLOSSING VOOR NU
//OM PHP ZAKEN (ENV EN SESSIE(s)) TE GEBRUIKEN HIER!!)

/*
fetch("products.json")
  .then((response) => {
    if (!response.ok) {
      throw new Error(`HTTP error: ${response.status}`);
    }
    return response.json();
  })
  .then((json) => initialize(json))
  .catch((err) => console.error(`Fetch error occured: ${err.message}`));
  */