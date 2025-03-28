//WebSocket
var conn = new WebSocket('ws://localhost:8080');
    
conn.onopen = function(e) {
    //console.log("Connection established!");
};

conn.onmessage = function(e) {
//    console.log(e.data);
    showMessages('other', e.data);
};

var formMSG = document.getElementById('formsg');
var input_message = document.getElementById('msg');
var input_name = document.getElementById('name');
var btn_env = document.getElementById('btnenv');
var area_content = document.getElementById('content');

    const form = document.querySelector('#formMessage');
    
    form.addEventListener('submit', event =>{
        event.preventDefault();

        if (inp_message.value != '') {
            var msg = {'name': inp_name.value, 'msg': inp_message.value};
            msg = JSON.stringify(msg);
    
            conn.send(msg);
    
        // const formData = new FormData(form);
        // fetch('/store', {
        //     method: 'POST',
        //     mode: 'cors',
        //     body: formData
        // });

            showMessages('me', msg);
    
            inp_message.value = '';
        }
    });

function showMessages(how, data) {
    data = JSON.parse(data);

    console.log(data);

    var div = document.createElement('div');
    div.setAttribute('class', how);

    var div_txt = document.createElement('div');
    div_txt.setAttribute('class', 'text');

    var h5 = document.createElement('h5');
    h5.textContent = data.name;

    var p = document.createElement('p');
    p.textContent = data.msg;

    div_txt.appendChild(h5);
    div_txt.appendChild(p);

    div.appendChild(img);
    div.appendChild(div_txt);

    area_content.appendChild(div);
}