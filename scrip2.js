function validateActor(form){
    fail = validateActorName(form.actName.value);
    if (fail == "") return true;
    else {alert(fail); return false;}
}
function validateActorName(field){
    if (field == "")
        return "Enter actor name!\n";
    else if (field.length < 2)
        return "Actor name must be at least 2 characters!\n";
    else
        return "";
}

function validateMovie(form) {
    fail = validateTitle(form.Title.value);
    fail+= validateGenre(form.Genre.value);
    fail+= validatePrice(form.Price.value);
    fail+= validateID(form.ActID.value);
    fail+= validateYear(form.Year.value);
    if (fail == "") return true;
    else {alert(fail); return false;}
}
function validateTitle(field) {
    if (field=="")
        return "Enter movie title!\n";
    else if (/[^a-zA-Z 0-9-]/.test(field))
        return "Only letters, numbers and dashes are allowed in title.\n";
    else
        return "";
}
function validateGenre(field) {
    if (field=="")
        return "Enter movie genre!\n";
    else if (/[^a-zA-Z 0-9-]/.test(field))
        return "Only letters, numbers and dashes are allowed in genre.\n";
    else if (field.length < 3)
        return "Genre must be at least 3 characters!\n";
    else
        return "";
}
function validatePrice(field) {
    if (field=="")
        return "Enter a price!\n";
    else if (/[^0-9.]/.test(field))
        return "Enter a numerical value in the price field!\n";
    else if (field<0)
        return "Enter a non-negative value in the price field!\n";
    else
        return "";
}
function validateID(field) {
    if (field=="")
        return "Enter a price!\n";
    else if (/[^0-9]/.test(field))
        return "Enter a numerical value in the actor ID field!\n";
    else if (field<0)
        return "Enter a non-negative value in the actor ID field!\n";
    else
        return "";

}
function validateYear(field) {
    if (field=="")
        return "Enter a year!\n";
    else if (/[^0-9]/.test(field))
        return "Enter a numerical value in the year field!\n";
    else if (field<0)
        return "Enter a non-negative value in the year field!\n";
    else
        return "";
}


function validateSearch(form) {
    if (form.searchTerm.value==""){
        alert("Please enter search.")
        return false;
    }
    else
        return true;
}

function verif(ID) {
    if (ID<0) return false;
    else
        return true;
}

function myFunctionMovies() {
    var actorsContainer = document.getElementById("actors-container");
    actorsContainer.classList.add("display-none");
    var moviesContainer = document.getElementById("movies-container");
    moviesContainer.classList.remove("display-none");
    var panel = document.getElementById("search-panel-movie");

    var panel = document.getElementById("search-panel-actor");
    if (panel.style.right == "0px")
        panel.style.right = "-350px";
}

function myFunctionActors() {
    var actorsContainer = document.getElementById("actors-container");
    actorsContainer.classList.remove("display-none");
    var moviesContainer = document.getElementById("movies-container");
    moviesContainer.classList.add("display-none");

    var panel = document.getElementById("search-panel-movie");
    if (panel.style.right == "0px")
        panel.style.right = "-350px";
}

function toggleSearchPanel(type){
    if (type=="movie"){
        var panel = document.getElementById("search-panel-movie");
        if (panel.style.right == "0px")
            panel.style.right = "-350px";
        else
            panel.style.right = "0px";
    }
    else if (type=="actor"){
        var panel = document.getElementById("search-panel-actor");
        if (panel.style.right == "0px")
            panel.style.right = "-350px";
        else
            panel.style.right = "0px";
    }
}
