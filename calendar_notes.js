var date;
getFormatedDate();

var offset = 0;
var count = 9;

var notes = [];
var loading = false;
var needLoad = true;
var firstLoad = true;

$('textarea').each(function () {
    autosize(this);
});

$(window).scroll(function(){
    if((($(window).scrollTop()+$(window).height())+250)>=$(document).height()){
        if (needLoad && !firstLoad)
            loadNextNotesInDate();
    }
});


function getFormatedDate() {

    var date = new Date();
    var dd = date.getUTCDay() + 1;

    var mm = date.getUTCMonth() + 1;

    var yy = date.getUTCFullYear();

    format(dd, mm, yy);
}

function format(dd, mm, yy) {
    if (dd < 10) dd = '0' + dd;

    if (mm < 10) mm = '0' + mm;

    date = yy + '-' + mm + '-' + dd;
}


function selectDay(id, month, year, dayDiv) {
    var day = +dayDiv.childNodes[0].innerHTML;
    month = +month + 1;
    year = +year;
    console.log(day + " " + month + " " + year);
    clearNotes();
    format(day, month, year);

    $.get("actions/get_notes.php?deleted=" + (deleted ? 1 : 0) + "&offset=" + document.getElementById('offset').value + "&count=" + document.getElementById('count').value
        + "&date=" + date, function(loaded){
        notes = JSON.parse(loaded);
        if (notes.length == 0)
            needLoad = false;
        loadNextNotesInDate();
    });
}

function clearNotes() {
    notes = [];
    offset = 0;
    needLoad = true;
    firstLoad = true;
    document.getElementById('offset').value = offset;
    var div = document.getElementById('table_notes');
    div.innerHTML = "";

    div.innerHTML = '<div class="col-sm-4" id="col-sm-4-1">' +
        '<input type="hidden" name="height" value="0">' +
        '</div>' +
        '<div class="col-sm-4" id="col-sm-4-2">' +
        '<input type="hidden" name="height" value="0">' +
        '</div>' +
        '<div class="col-sm-4" id="col-sm-4-3">' +
        '<input type="hidden" name="height" value="0">' +
        '</div>';

}

function getNotesInDateFromServer() {
    $.get("actions/get_notes.php?deleted=" + (deleted ? 1 : 0) + "&offset=" + document.getElementById('offset').value + "&count=" + document.getElementById('count').value
        + "&date=" + date, function(loaded){
        //console.log(loaded);
        notes = JSON.parse(loaded);
        if (notes.length == 0)
            needLoad = false;
        loading = false;
        firstLoad = false;
    });
}

function loadNextNotesInDate() {
    if(loading == false){
        loading = true;
        showLoadedNotes();
        getNotesInDateFromServer();
    }
}

$.get("actions/get_notes.php?deleted=" + (deleted ? 1 : 0) + "&offset=" + document.getElementById('offset').value + "&count=" + document.getElementById('count').value
    + "&date=" + date, function(loaded){
    notes = JSON.parse(loaded);
    if (notes.length == 0)
        needLoad = false;
    loadNextNotesInDate();
});