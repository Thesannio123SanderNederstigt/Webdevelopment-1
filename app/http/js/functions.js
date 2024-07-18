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
            alert('Vul a.u.b. zowel een gebruikersnaam als wachtwoord in');
            return;
        }

        let loginCredentials = { username: username, password: password };

        fetch(getUrl('/user/login'), {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(loginCredentials)
         }).then(async res => { 

            var result = await res.json();
            var token = result.jwt;

            sessionStorage.setItem("auth", `Bearer ${token}`);
            sessionStorage.setItem("tokenAndUserData", JSON.stringify(result));    
         });

         return;
    }
    catch(error) {
        console.log('An error occurred: ' + error.message());
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

    switch(item_name)
    {
        case("bingocard"):
            item_table_section = document.getElementById("bingocards-table-section");
            item_title_id_text = document.getElementById("bingocards-table-title-id-text");

            getUserBingocards(item_id);
            break;

        case("carditem"):
            item_table_section = document.getElementById("carditems-table-section");
            item_title_id_text = document.getElementById("carditems-table-title-id-text");

            getBingocardItems(item_id);
            break;

        case("sportsclub"):
            item_table_section = document.getElementById("sportsclubs-table-section");
            item_title_id_text = document.getElementById("sportsclubs-table-title-id-text");

            getUserSportsclubs(item_id);
            break;
    }

    item_title_id_text.innerText = item_id;
    item_title_id_text.value = item_id;
    item_title_id_text.style.cssText = 'color: #2F5597 !important';

    item_table_section.style.cssText = 'display: flex !important';
}

function getUserBingocards(item_id)
{
    try {
        fetch(getUrl(`/user/getUserBingocards/${item_id}`), {
            method: 'GET',
            headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
            }).then(async res => {
                var result = await res.json();

                const bingocardSubtableBodySection = document.getElementById("bingocard-subtable-body");

                const bingocardSubtableRows = document.getElementsByClassName("bingocard-subtable-rows");
    
                //oorspronkelijke rij leeg maken en behouden voor gebruik later
                if(bingocardSubtableRows[0].getElementsByClassName('table-bingocard-id')[0].innerText === "")
                {
                    document.getElementsByClassName("bingocard-subtable-rows")[0].style.cssText = 'display: none !important';
                    bingocardSubtableRows[0].getElementsByClassName('table-bingocard-id')[0].innerText = 1;
                }
    
                //verwijderen van bestaande rijen (wanneer er eerder op een andere toon bingokaarten knop is gedrukt)
                if(bingocardSubtableRows.length > 1)
                {      
                    for (var i = 1; i < bingocardSubtableRows.length; i++) 
                    {    
                        bingocardSubtableBodySection.removeChild(bingocardSubtableRows[i]);
                        i = i-1;
                    }
                }

                //klonen en verwijderen van de onderste rij (voor een nieuwe bingokaart) om deze iets later onderaan de neergezette rijen te kunnen plakken
                const bingocardSubtableBottomRow = document.getElementsByClassName("bingocard-table-bottom-row");

                const newBingocardRowClone = bingocardSubtableBottomRow[0].cloneNode(true);

                bingocardSubtableBottomRow[0].remove();
            
                //verwerken van de bingokaarten van een gebruiker (klonen van de tabel-rij en toevoegen aan de tabel met alle informatie per bingokaart op de pagina)
                result.forEach((bingocard) => {

                    const bingocardClone = bingocardSubtableRows[0].cloneNode(true);
                
                    bingocardClone.getElementsByClassName('table-bingocard-id')[0].innerText = bingocard.id;
                    bingocardClone.getElementsByClassName('table-bingocard-id')[0].value = bingocard.id;

                    bingocardClone.getElementsByClassName("table-bingocard-userId")[0].innerText = bingocard.userId;
                    bingocardClone.getElementsByClassName("table-bingocard-score")[0].innerText = bingocard.score;
                    bingocardClone.getElementsByClassName("table-bingocard-size")[0].innerText = displaySize(bingocard.size);

                    bingocardClone.getElementsByClassName("table-bingocard-creationDate")[0].innerText = bingocard.creationDate;
                    bingocardClone.getElementsByClassName("table-bingocard-lastAccessedOn")[0].innerText = bingocard.lastAccessedOn;

                    bingocardClone.getElementsByClassName("table-bingocard-cardItems-button")[0].value = bingocard.id;

                    bingocardClone.getElementsByClassName('table-bingocard-edit-button')[0].value = bingocard.id;
                    bingocardClone.getElementsByClassName('table-bingocard-remove-button')[0].value = bingocard.id;

                    //maak de rij zichtbaar (weghalen van eerder toegevoegde cssText)
                    bingocardClone.style.cssText = '';

                    //voeg name attribuut toe aan element (wordt gebruikt om de inhoud van de rij aan te spreken in de edit/bewerk functie later)
                    bingocardClone.setAttribute("name", bingocard.id);

                    //voeg rij(en) toe aan de tabel
                    bingocardSubtableBodySection.appendChild(bingocardClone);
                });

                //vul gebruikers id in als waarde in onderste rij
                newBingocardRowClone.getElementsByClassName('new-bingocard-user-id')[0].innerText = item_id;

                //voeg onderste rij toe aan de tabel
                bingocardSubtableBodySection.appendChild(newBingocardRowClone);
            });

    }catch(error) {
        console.log(`An error occurred: ${error.message()}`);
        return;
    }
}

function editBingocard(bingocardId)
{
    const bingocardRow = document.getElementsByName(bingocardId)[0];

    var userId = bingocardRow.getElementsByClassName('table-bingocard-userId')[0].value;
    var score = bingocardRow.getElementsByClassName('table-bingocard-score')[0].value;
    var size = processSize(bingocardRow.getElementsByClassName('table-bingocard-size')[0].value);
    var creationDate = bingocardRow.getElementsByClassName('table-bingocard-creationDate')[0].value;
    var lastAccessedOn = bingocardRow.getElementsByClassName('table-bingocard-lastAccessedOn')[0].value;

    let bingocardJson = { userId: userId, score: parseInt(score), size: size, creationDate: creationDate, lastAccessedOn: lastAccessedOn };

    let gebruikersId = document.getElementById("bingocards-table-title-id-text").value;

    fetch(getUrl(`/bingocard/update/${bingocardId}`), {
        method: 'PUT',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        body: JSON.stringify(bingocardJson)
     }).then(async res => { 

        var result = await res.json();

        if(result.id != '')
        {
            getUserBingocards(gebruikersId);
        }
     });

}

function deleteBingocard(bingocardId)
{
    let gebruikersId = document.getElementById("bingocards-table-title-id-text").value;

    fetch(getUrl(`/bingocard/delete/${bingocardId}`), {
        method: 'DELETE',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        }).then(async res => {
            var result = await res.json();

            if(result == true)
            {
                getUserBingocards(gebruikersId);
            }
        });
}

function createNewBingocard()
{
    var userId = document.getElementsByName('new-bingocard-userId')[0].value;
    var size = processSize(document.getElementsByName('new-bingocard-sizes')[0].value);
    
    let bingocardJson = { userId: userId, size: size };

    fetch(getUrl(`/bingocard/create/`), {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        body: JSON.stringify(bingocardJson)
     }).then(async res => {
            var result = await res.json();

            if(result.id != '')
            {
                let gebruikersId = document.getElementById("bingocards-table-title-id-text").value;
                document.getElementsByName('new-bingocard-sizes')[0].value = '9';

                getUserBingocards(gebruikersId);
            }
        });
}



function getBingocardItems(item_id)
{
    try {
    fetch(getUrl(`/bingocard/getBingocardItems/${item_id}`), {
        method: 'GET',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        }).then(async res => { 
    
            var result = await res.json();

            const bingocardItemSubtableBodySection = document.getElementById("bingocard-item-subtable-body");
            const bingocardItemSubtableRows = document.getElementsByClassName("bingocard-item-subtable-rows");

            //oorspronkelijke rij leeg maken en behouden voor gebruik later
            if(bingocardItemSubtableRows[0].getElementsByClassName('table-bingocard-item-id')[0].innerText === "")
            {
                document.getElementsByClassName("bingocard-item-subtable-rows")[0].style.cssText = 'display: none !important';
                bingocardItemSubtableRows[0].getElementsByClassName('table-bingocard-item-id')[0].innerText = 1;
            }

            //verwijderen van bestaande rijen (wanneer er eerder op een andere toon bingokaart-items knop is gedrukt)
            if(bingocardItemSubtableRows.length > 1)
            {   
                for (var i = 1; i < bingocardItemSubtableRows.length; i++) 
                {
                    bingocardItemSubtableBodySection.removeChild(bingocardItemSubtableRows[i]);

                    i = i-1;
                }
            }

            //klonen en verwijderen van de onderste rij (voor een nieuw bingokaart-item) om deze iets later onderaan de neergezette rijen te kunnen plakken
            const bingocardItemSubtableBottomRow = document.getElementsByClassName("bingocard-item-table-bottom-row");

            const newCardItemRowClone = bingocardItemSubtableBottomRow[0].cloneNode(true);

            bingocardItemSubtableBottomRow[0].remove();
            
            //verwerken van de bingokaart=items van een gebruiker (klonen van de tabel-rij en toevoegen aan de tabel met alle informatie per bingokaart-item op de pagina)
            result.forEach((cardItem) => {

                const cardItemClone = bingocardItemSubtableRows[0].cloneNode(true);
               
                cardItemClone.getElementsByClassName('table-bingocard-item-id')[0].innerText = cardItem.id;
                cardItemClone.getElementsByClassName('table-bingocard-item-id')[0].value = cardItem.id;

                cardItemClone.getElementsByClassName('table-bingocard-item-content')[0].innerText = cardItem.content;
                cardItemClone.getElementsByClassName('table-bingocard-item-category')[0].innerText = displayCategory(cardItem.category);
                cardItemClone.getElementsByClassName('table-bingocard-item-points')[0].innerText = cardItem.points;
                cardItemClone.getElementsByClassName('table-bingocard-item-isPremiumItem')[0].innerText = displayBool(cardItem.isPremiumItem);

                cardItemClone.getElementsByClassName('table-bingocard-item-edit-button')[0].value = cardItem.id;
                cardItemClone.getElementsByClassName('table-bingocard-item-remove-button')[0].value = cardItem.id;

                //maak de rij zichtbaar (weghalen van eerder toegevoegde cssText)
                cardItemClone.style.cssText = '';

                //voeg name attribuut toe aan element (wordt gebruikt om de inhoud van de rij aan te spreken in de edit/bewerk functie later)
                cardItemClone.setAttribute("name", cardItem.id);
                
                //voeg rij(en) toe aan de tabel
                bingocardItemSubtableBodySection.appendChild(cardItemClone);
            });

            //voeg onderste rij toe aan de tabel
            bingocardItemSubtableBodySection.appendChild(newCardItemRowClone);    
         });
    }
    catch(error) {
            console.log('An error occurred: ' + error.message());
            return;
    }
}

function editBingocardItem(cardItemId)
{
    const bingocardItemRow = document.getElementsByName(cardItemId)[0];

    var content = bingocardItemRow.getElementsByClassName('table-bingocard-item-content')[0].value;
    var category = processCategory(bingocardItemRow.getElementsByClassName('table-bingocard-item-category')[0].value);
    var points = bingocardItemRow.getElementsByClassName('table-bingocard-item-points')[0].value;
    var isPremiumItem = processBool(bingocardItemRow.getElementsByClassName('table-bingocard-item-isPremiumItem')[0].value);

    let cardItemJson = { content: content, category: category, points: parseInt(points), isPremiumItem: isPremiumItem };

    let bingocardId = document.getElementById("carditems-table-title-id-text").value;

    fetch(getUrl(`/carditem/update/${cardItemId}`), {
        method: 'PUT',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        body: JSON.stringify(cardItemJson)
     }).then(async res => { 

        var result = await res.json();

        if(result.id != '')
        {
            getBingocardItems(bingocardId);
        }
     });
}

function deleteBingocardItem(cardItemId)
{
    let bingocardId = document.getElementById("carditems-table-title-id-text").value;

    fetch(getUrl(`/bingocard/deleteBingocardItem/${bingocardId}/${cardItemId}`), {
        method: 'DELETE',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        }).then(async res => {
            var result = await res.json();

            if(result == true)
            {
                getBingocardItems(bingocardId);
            }
        });
}

function createBingocardItem()
{
    const content = document.getElementsByName('new-bingocard-item-content')[0].value;
    const category = processCategory(document.getElementsByName('new-bingocard-item-content-categories')[0].value);
    const points = document.getElementsByName('new-bingocard-item-points')[0].value;
    const isPremiumItem = processBool(document.getElementsByName('new-premium-bingocard-items')[0].value);

    let cardItemJson = { content: content, category: category, points: parseInt(points), isPremiumItem: isPremiumItem };

    fetch(getUrl(`/carditem/create/`), {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        body: JSON.stringify(cardItemJson)
     }).then(async res => { 

        var result = await res.json();

        if(result.id != '')
        {
            let bingocardId = document.getElementById("carditems-table-title-id-text").value;

            fetch(getUrl(`/bingocard/addBingocardItem/${bingocardId}/${result.id}`), {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
                }).then(async res => {
                    var resultaat = await res.json();
        
                    if(resultaat == true)
                    {
                        document.getElementsByName('new-bingocard-item-content')[0].value = '';
                        document.getElementsByName('new-bingocard-item-content-categories')[0].value = '0';
                        document.getElementsByName('new-bingocard-item-points')[0].value = '';
                        document.getElementsByName('new-premium-bingocard-items')[0].value = '0';

                        getBingocardItems(bingocardId);
                    }
                });
        }
     });    
}


function getUserSportsclubs(item_id)
{
    try {
        fetch(getUrl(`/user/getUserSportsclubs/${item_id}`), {
            method: 'GET',
            headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
            }).then(async res => {
                var result = await res.json();

                const sportsclubSubtableBodySection = document.getElementById("sportsclub-subtable-body");

                const sportsclubSubtableRows = document.getElementsByClassName("sportsclub-subtable-rows");
    
                //oorspronkelijke rij leeg maken en behouden voor gebruik later
                if(sportsclubSubtableRows[0].getElementsByClassName('table-sportsclub-id')[0].innerText === "")
                {
                    document.getElementsByClassName("sportsclub-subtable-rows")[0].style.cssText = 'display: none !important';
                    sportsclubSubtableRows[0].getElementsByClassName('table-sportsclub-id')[0].innerText = 1;
                }
    
                //verwijderen van bestaande rijen (wanneer er eerder op een andere toon sportclubs knop is gedrukt)
                if(sportsclubSubtableRows.length > 1)
                {      
                    for (var i = 1; i < sportsclubSubtableRows.length; i++) 
                    {    
                        sportsclubSubtableBodySection.removeChild(sportsclubSubtableRows[i]);
                        i = i-1;
                    }
                }

                //klonen en verwijderen van de onderste rij (voor een nieuwe sportclub) om deze iets later onderaan de neergezette rijen te kunnen plakken
                const sportsclubSubtableBottomRow = document.getElementsByClassName("sportsclub-table-bottom-row");

                const newSportsclubRowClone = sportsclubSubtableBottomRow[0].cloneNode(true);

                sportsclubSubtableBottomRow[0].remove();
            
                //verwerken van de sportclubs van een gebruiker (klonen van de tabel-rij en toevoegen aan de tabel met alle informatie per sportclub op de pagina)
                result.forEach((sportsclub) => {

                    const sportsclubClone = sportsclubSubtableRows[0].cloneNode(true);
                
                    sportsclubClone.getElementsByClassName('table-sportsclub-id')[0].innerText = sportsclub.id;
                    sportsclubClone.getElementsByClassName('table-sportsclub-id')[0].value = sportsclub.id;

                    sportsclubClone.getElementsByClassName("table-sportsclub-clubname")[0].innerText = sportsclub.clubname;
                    sportsclubClone.getElementsByClassName("table-sportsclub-description")[0].innerText = sportsclub.description;
                    sportsclubClone.getElementsByClassName("table-sportsclub-foundedOn")[0].innerText = sportsclub.foundedOn;
                    sportsclubClone.getElementsByClassName("table-sportsclub-membersAmount")[0].innerText = sportsclub.membersAmount;

                    sportsclubClone.getElementsByClassName('table-sportsclub-edit-button')[0].value = sportsclub.id;
                    sportsclubClone.getElementsByClassName('table-sportsclub-remove-button')[0].value = sportsclub.id;

                    //maak de rij zichtbaar (weghalen van eerder toegevoegde cssText)
                    sportsclubClone.style.cssText = '';

                    //voeg name attribuut toe aan element (wordt gebruikt om de inhoud van de rij aan te spreken in de edit/bewerk functie later)
                    sportsclubClone.setAttribute("name", sportsclub.id);

                    //voeg rij(en) toe aan de tabel
                    sportsclubSubtableBodySection.appendChild(sportsclubClone);
                });

                //voeg onderste rij toe aan de tabel
                sportsclubSubtableBodySection.appendChild(newSportsclubRowClone);
            });

    }catch(error) {
        console.log(`An error occurred: ${error.message()}`);
        return;
    }
}

function editSportsclub(sportsclubId)
{
    const sportsclubRow = document.getElementsByName(sportsclubId)[0];

    var clubname = sportsclubRow.getElementsByClassName('table-sportsclub-clubname')[0].value;
    var description = sportsclubRow.getElementsByClassName('table-sportsclub-description')[0].value;
    var foundedOn = sportsclubRow.getElementsByClassName('table-sportsclub-foundedOn')[0].value;
    var membersAmount = sportsclubRow.getElementsByClassName('table-sportsclub-membersAmount')[0].value;

    let sportsclubJson = { clubname: clubname, description: description, foundedOn: foundedOn, membersAmount: parseInt(membersAmount) };

    let gebruikersId = document.getElementById("sportsclubs-table-title-id-text").value;

    fetch(getUrl(`/sportsclub/update/${sportsclubId}`), {
        method: 'PUT',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        body: JSON.stringify(sportsclubJson)
     }).then(async res => { 

        var result = await res.json();

        if(result.id != '')
        {
            getUserSportsclubs(gebruikersId);
        }
     });
}

function deleteUserSportsclub(sportsclubId)
{
    let gebruikersId = document.getElementById("sportsclubs-table-title-id-text").value;

    fetch(getUrl(`/user/deleteUserSportsclub/${gebruikersId}/${sportsclubId}`), {
        method: 'DELETE',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        }).then(async res => {
            var result = await res.json();

            if(result == true)
            {
                getUserSportsclubs(gebruikersId);
            }
        });
}

function createUserSportsclub()
{
    var clubname = document.getElementsByName('new-sportsclub-clubname')[0].value;
    var description = document.getElementsByName('new-sportsclub-description')[0].value;
    var foundedOn = document.getElementsByName('new-sportsclub-foundedOn')[0].value;
    var membersAmount = document.getElementsByName('new-sportsclub-membersAmount')[0].value;

    let sportsclubJson = { clubname: clubname, description: description, foundedOn: foundedOn, membersAmount: parseInt(membersAmount) };

    fetch(getUrl(`/sportsclub/create/`), {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
        body: JSON.stringify(sportsclubJson)
     }).then(async res => {
            var result = await res.json();

            if(result.id != '')
            {
                let gebruikersId = document.getElementById("sportsclubs-table-title-id-text").value;

                fetch(getUrl(`/user/addUserSportsclub/${gebruikersId}/${result.id}`), {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'Authorization': `${sessionStorage.getItem("auth")}`},
                    }).then(async res => {
                        var resultaat = await res.json();
            
                        if(resultaat == true)
                        {
                            document.getElementsByName('new-sportsclub-clubname')[0].value = '';
                            document.getElementsByName('new-sportsclub-description')[0].value = '';
                            document.getElementsByName('new-sportsclub-foundedOn')[0].value = '1970-01-01';
                            document.getElementsByName('new-sportsclub-membersAmount')[0].value = '';

                            getUserSportsclubs(gebruikersId);
                        }
                    });
            }

        });
}

function displaySize(bingocardSize)
{
    var sizeText = bingocardSize;

    switch(bingocardSize)
    {
        case(9):
            sizeText = "3x3";
            break;

        case(16):
            sizeText = "4x4";
            break;
        
        case(25):
            sizeText = "5x5";
            break;
    }
    return sizeText;
}

function displayCategory(cardItemCategory)
{
    var categoryText = cardItemCategory;

    switch(cardItemCategory)
    {
        case(0):
            categoryText = "standaard tekst";
            break;

        case(1):
            categoryText = "speciaal font of effect";
            break;

        case(2):
            categoryText = "afbeelding";
            break;

        case(3):
            categoryText = "geluidseffect";
            break;
        
        case(4):
            categoryText = "video";
            break;

        case(5):
            categoryText= "animatie";
            break;
    }
    return categoryText;
}

function displayBool(boolValue)
{
    var boolText = "";
    switch(boolValue)
    {
        case(true):
            boolText = "Ja";
            break;
        case(false):
            boolText = "Nee";
            break;
    }
    return boolText;
}

function processSize(textSize)
{
    var size = 9;
    switch(textSize)
    {
        case("3x3"):
            size = 9;
            break;

        case("3 bij 3"):
            size = 9;
            break;
    
        case("9"):
            size = 9;
            break;

        case("4x4"):
            size = 16;
            break;

        case("4 bij 4"):
            size = 16;
            break;
    
        case("16"):
            size = 16;
            break;
    
        case("5x5"):
            size = 25;
            break;

        case("5 bij 5"):
            size = 25;
            break;
    
        case("25"):
            size = 25;
            break;
    }
    return size;
}

function processCategory(textCategory) 
{
    var category = 0;
    switch(textCategory)
    {
        case("standaard tekst"):
            category = 0;
            break;

        case("0"):
            category = 0;
            break;

        case("speciaal font of effect"):
            category = 1;
            break;

        case("1"):
            category = 1;
            break;
        
        case("afbeelding"):
            category = 2;
            break;

        case("2"):
            category = 2;
            break;

        case("geluidseffect"):
            category = 3;
            break;

        case("3"):
            category = 3;
            break;
        
        case("video"):
            category = 4;
            break;

        case("4"):
            category = 4;
            break;

        case("animatie"):
            category = 5;
            break;

        case("5"):
            category = 5;
            break;
    }
    return category;
}

function processBool(boolText)
{
    var boolValue = 0;

    if(boolText == "Ja" || boolText == "ja" || boolText == "Yes" || boolText == "yes" || boolText == "1")
    {
        boolValue = 1;
    }
    else if(boolText == "Nee" || boolText == "nee" || boolText == "No" || boolText == "no" || boolText == "0")
    {
        boolValue = 0;
    }

    return boolValue;
}