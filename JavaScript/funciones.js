function uncheckOthers(id){
    var elm = document.getElementsByTagName('input');
    for(var i = 0; i < elm.length; i++){
        if(elm.item(i).type == "checkbox" && elm.item(i) != id)
            elm.item(i).checked = false;
    }
}