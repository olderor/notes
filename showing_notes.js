function checkLengthTextarea(textarea) {
    if (textarea.value.length > 1000)
    {
        textarea.value = textarea.value.substr(0,1000);
        alert('characters limit is 1000');
        autosize(textarea);
    }
    textarea.setAttribute('value', textarea.value);
}

function checkLengthTitle(title) {
    if (title.value.length > 29)
    {
        title.value = title.value.substr(0,29);
        alert('characters limit is 29');
    }
    title.setAttribute('value', title.value);
}

function changeImportance(select) {
    form = select.parentNode.parentNode;
    form.classList = "";
    form.classList.add("panel");
    console.log(select.value);
    switch (select.value) {
        case "5":
            form.classList.add('panel-primary');
            break;
        case "4":
            form.classList.add('panel-danger');
            break;
        case "3":
            form.classList.add('panel-info');
            break;
        case "2":
            form.classList.add('panel-success');
            break;
        case "1":
            form.classList.add('panel-warning');
            break;
        default:
            form.classList.add('panel-default');
            break;
    }
}

function getHeight(col) {
    if (col == null || col == undefined)
        return 0;
    for (var i = 0; i < col.childNodes.length; i++)
       if (col.childNodes[i].name == 'height')
           return +col.childNodes[i].value;
    return 0;
}

function getColumnWithMinHeight() {
    var col1 = document.getElementById('col-sm-4-1');
    var col2 = document.getElementById('col-sm-4-2');
    var col3 = document.getElementById('col-sm-4-3');

    var col1H = getHeight(col1);
    var col2H = getHeight(col2);
    var col3H = getHeight(col3);

    var min  = col3H < col2H ? col3 : col2;
    var minH = col3H < col2H ? col3H : col2H;
    return minH < col1H ? min : col1;
    /*
    var min = col3.offsetHeight < col2.offsetHeight ? col3 : col2;
    return min.offsetHeight < col1.offsetHeight ? min : col1;*/
}

function formatDate(date) {

    var dd = date.getUTCDay();
    if (dd < 10) dd = '0' + dd;

    var mm = date.getUTCMonth() + 1;
    if (mm < 10) mm = '0' + mm;

    var yy = date.getUTCFullYear();

    var ss = date.getUTCSeconds();
    if (ss < 10) ss = '0' + ss;

    var MM = date.getUTCMinutes();
    if (MM < 10) MM = '0' + MM;

    var hh = date.getUTCHours();
    if (hh < 10) hh = '0' + hh;

    return yy + '-' + mm + '-' + dd + ' ' + hh + ':' + MM + ':' + ss;
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function showNote(id, importance, title, text, datetime) {
    offset++;
    document.getElementById('offset').value = offset;
    var col = getColumnWithMinHeight();

    var newNote = '<form onsubmit="onSubmitForm(this);" method="post" id="form' + id + '" action="actions/update_note.php">';
    newNote += '<div class="panel ';
    switch (importance) {
        case '5':
            newNote += 'panel-primary';
            break;
        case '4':
            newNote += 'panel-danger';
            break;
        case '3':
            newNote += 'panel-info';
            break;
        case '2':
            newNote += 'panel-success';
            break;
        case '1':
            newNote += 'panel-warning';
            break;
        default:
            newNote += 'panel-default';
            break;
    }
    newNote += '">';
    newNote += '<input type="hidden" name="noteid" value="' + id + '">';
    newNote += '<div class="panel-heading"><input onKeyUp="checkLengthTitle(this);" autocomplete="off" class="form-control input-lg panel-title title" type="text" name="title" placeholder="Title" value="';
    newNote += title + '">';
    if (deleted)
        newNote += '<button class="close restore" aria-label="Close" id="submit">✓</button>';
    else
        newNote += '<button type="button" class="close" aria-label="Close" id="delete" onclick="deleteNote(this);"><span aria-hidden="true">&times;</span></button>';

    newNote += '<select class="form-control" name="importance" onchange="changeImportance(this);">'
    newNote += '<option value="5"' + (importance == '5' ? " selected" : "") + '>Emergency</option>'
    newNote += '<option value="4"' + (importance == '4' ? " selected" : "") + '>Highly important</option>'
    newNote += '<option value="3"' + (importance == '3' ? " selected" : "") + '>Important</option>'
    newNote += '<option value="2"' + (importance == '2' ? " selected" : "") + '>Regular</option>'
    newNote += '<option value="1"' + (importance == '1' ? " selected" : "") + '>Non-important</option>'
    newNote += '<option value="0"' + (importance == '0' ? " selected" : "") + '>Irrelevant</option>'
    newNote += '</select>';
    newNote += '</div> <div class="panel-body"><textarea onKeyUp="checkLengthTextarea(this);" autocomplete="off" class="form-control input-lg panel-title" name="text"  style="background: none; height: auto;" type="text" placeholder="Your text">';
    newNote += text + '</textarea>';
    newNote += '<div style="padding-top: 5px;">';
    if (!deleted)
        newNote += '<button class="btn btn-lg btn-primary" id="submit">Save</button>';
    newNote += '<label class="text-right datetime" id="date" style="width: calc(100% - 85px);text-align: right;">';
    newNote += datetime;
    newNote += '</label>';
    newNote += '</div></div></form></div>';

    if (id < 0)
        col.innerHTML = newNote + col.innerHTML;
    else
        col.innerHTML = col.innerHTML + newNote;
    var length = text.length;
    if (length < 65)
        length = 65;

    for (var i = 0; i < col.childNodes.length; i++)
        if (col.childNodes[i].name == 'height') {
            col.childNodes[i].value = +col.childNodes[i].value + length;
            break;
        }

    $('textarea').each(function () {
        autosize(this);
    });

}

function showLoadedNotes() {
    for (var i = 0; i < notes.length; i++)
        showNote(notes[i]['id'], notes[i]['importance'], notes[i]['title'], notes[i]['text'], notes[i]['datetime']);
}

function getNotesFromServer() {
    var d = deleted ? 1 : 0;
    $.get("actions/get_notes.php?deleted=" + d + "&offset=" + document.getElementById('offset').value + "&count=" + document.getElementById('count').value, function(loaded){
        //console.log(loaded);
        notes = JSON.parse(loaded);
        if (notes.length == 0)
            needLoad = false;
        loading = false;
    });
}

function loadNextNotes() {
    if(loading == false){
        loading = true;
        showLoadedNotes();
        getNotesFromServer();
    }
}

function SubForm(form) {
    $.ajax({
        url: 'actions/update_note.php',
        type: 'post',
        data: $('#' + form.id).serialize(),
        success: function () {
            if (!deleted) {
                form['submit'].innerHTML = "Save";
                form['submit'].style = "";
                var time = getCookie('time');
                //console.log(time);
                if (time != null && time != undefined)
                    form.childNodes[0].childNodes[3].childNodes[1].childNodes[1].innerHTML = time.replace('+', ' ');
                if (form['noteid'].value < 0) {
                    var lastId = getCookie('lastId');
                    form['noteid'].value = lastId;
                    form.id = "form" + lastId;
                }
            }
        }
    });
}

function deleteNote(button) {
    button.form.style = "display: none;";
    $.ajax({
        url: 'actions/delete_note.php',
        type: 'post',
        data: $('#' + button.form.id).serialize(),
        success: function () {
        }
    });
}

function h(e) {
    $(e).height(e.scrollHeight - 20);
    //$(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight - 20);
}

function onSubmitForm(form) {
    event.preventDefault();
    if (!deleted) {
        form['submit'].innerHTML = '<div data-loader="circle"></div>';
        form['submit'].style = 'padding: 1.5px 16px;';
    }
    else
        form.style = "display: none;";
    
    SubForm(form);
}

function newNote() {
    //var col = getColumnWithMinHeight();
    var count = +document.getElementById('count').value + 1;
    document.getElementById('count').value = count;

    showNote(-count, 0, "", "", formatDate(new Date()));
}