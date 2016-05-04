var offset = 0;
var count = 9;

var notes = [];
var loading = false;
var needLoad = true;

$('textarea').each(function () {
    autosize(this);
});

$(window).scroll(function(){
    if((($(window).scrollTop()+$(window).height())+250)>=$(document).height()){
        if (needLoad)
            loadNextNotes();
    }
});

$.get("actions/get_notes.php?deleted=" + (deleted ? 1 : 0) + "&offset=" + document.getElementById('offset').value + "&count=" + document.getElementById('count').value, function(loaded){
    notes = JSON.parse(loaded);
    if (notes.length == 0)
        needLoad = false;
    loadNextNotes();
});