function add_custom_charakter() {
    var options = document.getElementById('charakter');
    var value = document.getElementById('custom-charakter').value;
    var valid = value != "";
    for (i = 0; i < options.length; i++) {
        if (options[i].value == value) {
            valid = false;
            break;
        }
    }
    if (valid) {
        var option = document.createElement('option');
        option.text = value;
        document.getElementById('charakter').add(option);
    }
    document.getElementById('custom-charakter').value = "";
    document.getElementById('rasse-form').doNotSubmit();
}

function add_custom_farbe() {
    var options = document.getElementById('farbe');
    var value = document.getElementById('custom-farbe').value;
    var valid = value != "";
    for (i = 0; i < options.length; i++) {
        if (options[i].value == value) {
            valid = false;
            break;
        }
    }
    if (valid) {
        var option = document.createElement('option');
        option.text = value;
        document.getElementById('farbe').add(option);
    }
    document.getElementById('custom-farbe').value = "";
    document.getElementById('rasse-form').doNotSubmit();
}

function add_custom_fell() {
    var options = document.getElementById('fell');
    var value = document.getElementById('custom-fell').value;
    var valid = value != "";
    for (i = 0; i < options.length; i++) {
        if (options[i].value == value) {
            valid = false;
            break;
        }
    }
    if (valid) {
        var option = document.createElement('option');
        option.text = value;
        document.getElementById('fell').add(option);
    }
    document.getElementById('custom-fell').value = "";
    document.getElementById('rasse-form').doNotSubmit();
}