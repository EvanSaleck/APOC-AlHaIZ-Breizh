let zonetoken = document.getElementById("zonetoken");
let tabtoken;

fetch('/api/getAllTokenById')
.then(response => response.json())
.then(data => {
    console.log(data);
    tabtoken = data;
    for (let i = 0; i < data.length; i++) {
        let token = data[i];
        zonetoken.innerHTML += `<div class="row">
        <div class="col-4">${token.id_token}</div>
        <div class="col-4">${token.token}</div>
        <div class="col-4">
            <button class="btn btn-danger" onclick="deleteToken(${token.id_token})">Supprimer</button>
        </div>
    </div>`;
    }
})