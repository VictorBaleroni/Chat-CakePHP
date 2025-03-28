//WebSocket
var conn = new WebSocket('ws://localhost:8080');
    
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
//    console.log(e.data);
    showMessages('other', e.data);
};

const form = document.querySelector('#formMessage');
var input_message = document.getElementById('msg');
var input_name = document.getElementById('name');
var area_content = document.getElementById('content');
    
    form.addEventListener('submit', event =>{
        event.preventDefault();

        const formData = new FormData(form);
        fetch('/addmessage', {
            method: 'POST',
            mode: 'cors',
            body: formData
        });

        if (input_message.value != '') {
            var msg = {'name': input_name.value, 'msg': input_message.value};
            msg = JSON.stringify(msg);
    
            conn.send(msg);
    
            showMessages('me', msg);
    
            input_message.value = '';
        }
    });

function showMessages(how, data) {
    data = JSON.parse(data);

    console.log(data);

    var ul = document.createElement('ul');
    ul.setAttribute('class', 'chat-messages');

    var li = document.createElement('li');
    li.setAttribute('class', how + ' message');

    var h5 = document.createElement('h5');
    h5.textContent = data.name;

    var p = document.createElement('p');
    p.textContent = data.msg;

    li.appendChild(h5);
    li.appendChild(p);

    ul.appendChild(li);

    area_content.appendChild(ul);
}

