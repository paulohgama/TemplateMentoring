var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

var users = {};
var publicSockets = [];

var filterUserStatus = function(users) {
    let consultants = [];
    for (key in users) {
        if (users[key].role == 2) {
            consultants.push({ consultor_id: key, status: users[key].status });
        }
    }
    return consultants;
}

io.on('connection', function(socket) {

	socket.on("join", function(data) {
		socket.role = data.role;
        socket.status = true;
        // if(!users.hasOwnProperty(data.user_id)) {
            users[data.user_id] = socket;
        // }
	    console.log('socket conectou, total ativos: ', Object.keys(users).length);
	    //console.log(users);
	    //Precisa checar se é atendente ou visitante, se for visitante deve ser emitido uma chamada ao consultor
	    // que pode ser ignorada ou aceita. consultor 2 | visitante 3

        if (socket.role == 3 && users[data.receiver_id] != undefined) {
            console.log('emitiu notificacao ao consultor');
            users[data.receiver_id].emit("callConsultantForChat", { visitor_id: data.user_id, visitor_name: data.name, chat: data.chat });

        }
        socket.emit("isconnected", { role: socket.role, msg: data.name + ' conectou-se ao servidor :]' });

    });

    socket.on('listenForVisitorNotifications', function(data) {
        if(users[data.consultant_id]) {
            socket.role = data.role;
            socket.status = users[data.consultant_id].status;
            users[data.consultant_id] = socket;

            console.log('status atual: ', users[data.consultant_id].status)
        }else {
            socket.role = data.role;
            socket.status = true;
            users[data.consultant_id] = socket;
        }
        //console.log(data);
        console.log('socket conectou, total ativos: ', Object.keys(users).length);
        console.log(users[data.consultant_id].handshake.time);
    });

    socket.on('answerVisitorRequest', function(data) {
        if (data.accepted && users[data.visitor_id] != undefined) {
            users[data.visitor_id].emit('consultantAccept', { accepted: true });
        } else {
            users[data.visitor_id].emit('consultantAccept', { accepted: false });
        }
        console.log('resposta sendo feita: ', data);
    });

    socket.on("sendMessage", function(data) {
        console.log('socket q enviou: ', data.toUserId);
        if(users.hasOwnProperty(data.toUserId)) users[data.toUserId].emit("receiveMessage", data);
    });

    socket.on("typing", function(data) {
        console.log('data: ', data);
        if(data.typing)
        {
            if(users.hasOwnProperty(data.toUserId)) users[data.toUserId].emit("istyping");
        }
        else
        {
            if(users.hasOwnProperty(data.toUserId)) users[data.toUserId].emit("notyping");
        }

    });

    socket.on('startTime', function(data)
    {
        // console.log(users[data.id]);
        // console.log(users[data.fromId]);
        if(users.hasOwnProperty(data.id)) users[data.id].emit('startTimer');
        if(users.hasOwnProperty(data.fromId)) users[data.fromId].emit('startTimer');
        console.log('iniciando contador');
    });

    socket.on("disconnect", function(id) {
        if(users.hasOwnProperty(id)) socket.emit("isdiconnected", users[id] + " está desconectado.");
        delete users[id];
    });

    socket.on('finishChat', function(data) {
        console.log('finalizando chat');
        if(users.hasOwnProperty(data.toUserId)) users[data.toUserId].emit('finishingChat', { status: data.status });
        if(users.hasOwnProperty(data.fromUserId)) users[data.fromUserId].emit('finishingChat', { status: data.status });
    });

    socket.on('jointopublics', function() {
        console.log('A public socket connected.');
        publicSockets.push(socket);
    })

    socket.on('statusConsultor', function(data) {
        console.log('status atualizado.');
        if (users[data.id_consultor] != undefined) {
            users[data.id_consultor].status = data.status;
            //let consutants = filterUserStatus(users);
            //console.log('filtered: ', consutants)
            publicSockets.map((skt) => {
                skt.emit('mudaStatus', data);
            });
        }

    });
    socket.on('response', function(data)
    {
        if(users.hasOwnProperty(data.toUserId)) users[data.toUserId].emit('responseGet');
    });
});

http.listen(21097, function() {
    console.log('Servidor rodando em: tarotnovaera.kinghost.net:21097');
});
