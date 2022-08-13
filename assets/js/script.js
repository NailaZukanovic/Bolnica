var ukloni_odobren = document.getElementsByClassName("ukloni_odobren");
for(var i=0;i<ukloni_odobren.length;i++){
    ukloni_odobren[i].addEventListener("click",(e) => {
        if(!confirm("da li ste sigurni da zelite da uklonite korisnika?")){
            e.preventDefault();
        }
    });
}

var pacijent_poruke = document.getElementById("pacijent_poruke");
if(pacijent_poruke){
    pacijent_poruke.scrollTop = pacijent_poruke.scrollHeight;
}