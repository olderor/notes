
function checkLengthTextarea(textarea) {
    if (textarea.value.length > 20000)
    {
        textarea.value = textarea.value.substr(0,20000);
        alert('characters limit is 20000');
        autosize(textarea);
    }
}

function checkLengthTitle(title) {
    if (title.value.length > 29)
    {
        title.value = title.value.substr(0,29);
        alert('characters limit is 29');
    }
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

    var min = col3.offsetHeight < col2.offsetHeight ? col3 : col2;
    return min.offsetHeight < col1.offsetHeight ? min : col1;
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