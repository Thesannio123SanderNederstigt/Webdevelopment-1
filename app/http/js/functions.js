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

        fetch(getUrl('user/login'), {
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


function showSubtableSection(item_id, item_name)
{
    var item_table_section;
    var item_title_id_text;

    //console.log(item_id);
    //console.log(item_name);

    switch(item_name)
    {
        case("bingocard"):
            item_table_section = document.getElementById("bingocards-table-section");
            item_title_id_text = document.getElementById("bingocards-table-title-id-text");

            //getUserBingocards(item_id);
            break;

        case("carditem"):
            item_table_section = document.getElementById("carditems-table-section");
            item_title_id_text = document.getElementById("carditems-table-title-id-text");

            //getBingocardItems(item_id);
            break;

        case("sportsclub"):
            item_table_section = document.getElementById("sportsclubs-table-section");
            item_title_id_text = document.getElementById("sportsclubs-table-title-id-text");

            //getUserSportsclubs(item_id);
            break;
    }

    item_title_id_text.innerText = item_id;
    item_title_id_text.style.cssText = 'margin-left: 0.5rem !important; color: #2F5597 !important';

    item_table_section.style.cssText = 'display: flex !important';

}



/*
function showUserBingocards(user_id) 
{
    //console.log(document.getElementById('tableUserId').value);
    
    var bingocards_table_section = document.getElementById("bingocards-table-section");
    bingocards_table_section.style.cssText = 'display: flex !important';

    
    var bingocards_title_id_text = document.getElementById("bingocards-table-title-id-text");
    bingocards_title_id_text.innerText = user_id;
    bingocards_title_id_text.style.cssText = 'margin-left: 0.5rem !important; color: #2F5597 !important';
}

function showBingocardItems(bingocard_id)
{
    var cardditems_table_section = document.getElementById("carditems-table-section");
    cardditems_table_section.style.cssText = 'display: flex !important';

    var carditems_title_id_text = document.getElementById("carditems-table-title-id-text");
    carditems_title_id_text.innerText = bingocard_id;
    carditems_title_id_text.style.cssText = 'margin-left: 0.5rem !important; color: #2F5597 !important';
}

function showUserSportsclubs(sportsclub_id)
{
    var sportsclub_table_section = document.getElementById("sportsclubs-table-section");
    sportsclub_table_section.style.cssText = 'display: flex !important';

    var sportsclub_title_id_text = document.getElementById("sportsclubs-table-title-id-text");
    sportsclub_title_id_text.innerText = sportsclub_id;
    sportsclub_title_id_text.style.cssText = 'margin-left: 0.5rem !important; color: #2F5597 !important';
}
*/