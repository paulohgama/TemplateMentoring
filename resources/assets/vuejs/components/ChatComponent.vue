<template>
    <div id="chat-frame-box"
        :class="{waiting: (loader.type == 'waiting' && loader.active),
                done: loader.type == 'done' && loader.active}">
        <div class="dots"><span>...</span></div>

        <!-- # some status # -->
        <div class="status status-waiting">

            <h3>Atenção</h3>
            <div class="info">
                <div class="spinner">
                    <div class="lds-hourglass"></div>
                </div>
                <div v-if="!loader.refuse">Aguardando atendente...</div>
                <div v-else-if="!loader.timeout">
                    O consultor não atendeu sua chamada de chat :(
                    <a href="" class="btn-default" v-if="sender.role == 3">
                        <div class="wrap">Procurar outros consultores</div>
                    </a>
                </div>
                <div v-else>
                    O consultor recusou sua chamada de chat :(
                    <a href="" class="btn-default" v-if="sender.role == 3">
                        <div class="wrap">Procurar outros consultores</div>
                    </a>
                </div>
            </div>
            <a href="" class="btn-default" v-if="sender.role == 3 && !loader.refuse">
                <div class="wrap">Desistir do atendimento</div>
            </a>
        </div>
        <div class="status status-done">
            <h3>Atenção</h3>
            <div v-if="sender.role == 3">
                <div class="info" >
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                    Atendimento finalizado com sucesso
                </div>
                <a href="" class="btn-default"><div class="wrap">Fazer nova consulta</div></a>
            </div>
             <div v-if="sender.role == 2">
                <div class="info" >
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                    Atendimento realizado com sucesso
                </div>
                <a href="" class="btn-default"><div class="wrap">Voltar ao painel</div></a>
            </div>
        </div>
        <!-- # some status # -->

        <div class="talking-area">
            <div v-for="(item, index) in messages" :key="index" :class="item.fromUserId == sender.id ? 'msg agent-me' : 'msg agent-notme'">
                <div class="text">
                    <span class="name"> {{item.fromUserId == sender.id ? sender.name : receiver.name }} </span>
                    {{ item.message }}
                </div>
            </div>
        </div>
        <div class="panel-text">
            <p class="typing" v-if="typing">{{ receiver.name }} está digitando...</p>
            <textarea v-model="message" @keyup.enter="sendMessage" @keydown="onTyping" @keyup.delete="stopTyping" id="message" placeholder="Enviar mensagem..." ></textarea>
            <button @click="sendMessage">Enviar Mensagem</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['sender', 'receiver'],
    data () {
        return {
            loader: {type: 'waiting', active: false, refuse: false, timeout: false},
            message: '',
            messages: [],
            typing: false,
            typingClock: null,
            socket: CreateConnectionSocket,
        }
    },
    created() {
        this.loader.active = true;
        //Join Into server
        // this.socket.emit("join", {
        //     user_id: this.sender.id,
        //     name: this.sender.name,
        //     role: this.sender.role,
        //     receiver_id: this.receiver.id,
        //     chat: this.sender.chat
        // });

        //console.log(this.sender.chat);

    },
    mounted() {
        //Listen for messages
        this.socket.on('isconnected', this.startedConn);
        this.socket.on('isdiconnected', (data) => console.log(data));
        this.socket.on('receiveMessage', this.receiveMessage);
        this.socket.on('istyping', this.someoneIsTyping);
        this.socket.on('notyping', this.finishIsTyping);
        this.socket.on('finishingChat', (data) => this.finishingChat(data))

        // if is visitor, waits for consultant accept to join ->
        if(this.sender.role == 3) {
            this.socket.on('consultantAccept', (data) => {
                console.log('consultor respondeu: ', data);
                if(data.accepted) {
                        this.loader.active = false;

                } else {
                    this.loader.active = true;
                    this.loader.refuse = true;
                    this.loader.timeout = true;
                }
            });
        }
        setTimeout(() => {
            if(this.loader.active)
            {
                this.loader.timeout = false;
                //status de timeout
                this.finishTimeOut();
            }
        }, 300000);
        if(this.sender.role == '2')
        {
            this.socket.emit('startTime', {id:this.receiver.id, fromId: this.sender.id});
        }

        //If try close the window or head back
        this.unloadStartEvent();
    },
    destroyed() {
        this.socket.emit('disconnect', this.sender.id)
    },
    methods: {
        sendMessage() {
            if (this.message.trim().length > 0) {
                let messagePackage = this.createMsgObj(this.message);
                this.socket.emit('sendMessage', messagePackage);
                this.socket.emit("typing", {toUserId: this.receiver.id, name: this.receiver.name, typing:false });
                this.socket.emit('response', {toUserId: this.receiver.id});
                this.messages.push(messagePackage);
                this.storeMessage();
                this.message = "";
                this.scrollToBottom();
            }else{
                alert("Digite algo antes de enviar :)");
            }
        },

        receiveMessage(msg) {
            this.messages.push(msg);
            this.scrollToBottom();
        },
        onTyping() {
            if(this.message.length == 1 || (this.message.length%100 == 0 && this.message.length > 0))
            {
                this.socket.emit("typing", {toUserId: this.receiver.id, name: this.receiver.name, typing:true });
                this.socket.emit('response', {toUserId: this.receiver.id});
            }
        },
        stopTyping() {
            if(this.message.length == 0)
            {
                this.socket.emit("typing", {toUserId: this.receiver.id, name: this.receiver.name, typing:false });
                this.socket.emit('response', {toUserId: this.receiver.id});
            }
        },
        someoneIsTyping(data) {
            this.typing = true;
        },
        finishIsTyping(data) {
            this.typing = false;
        },
        createMsgObj() {
            return {
                fromUserId: this.sender.id,
                toUserId: this.receiver.id,
                message: this.message
            }
        },
        scrollToBottom() {
            setTimeout(function() {
                document.querySelector('.talking-area').scrollTop = document.querySelector('.talking-area').scrollHeight
            },300)
        },
        startedConn(data) {
            //consultor
            if(data.role == 2) {
                this.loader.active = false;
            }
            console.log(data.msg)
        },
        ranOutTime() {
            this.loader.active = true;
            this.loader.type= "done";
        },
        unloadStartEvent() {
        },
        unbindUnloadEvent() {
            window.removeEventListener("beforeunload", function(e) {
                console.log('unload foi removido.')
            }, true);
            window.removeEventListener("unload", function(e) {
                console.log('unload foi removido.')
            }, true);
        },
        storeMessage(){
            let consultor;
            if(this.sender.role == 2){
                consultor = 1;
                axios.post('../../mensagem', {atendimento: this.sender.chat, mensagem: this.message, msgpor: consultor})
            }
            else{
                consultor = 0;
                axios.post('../mensagem', {atendimento: this.sender.chat, mensagem: this.message, msgpor: consultor})
            }
        },
        finishingChat(data){
            $(window).unbind('beforeunload');
            $(window).unbind('unload');
            if(data.status != 7 || data.status != 6)
            {
                    if(this.sender.role == 2){
                    alert('chat encerrado');
                    axios.post('../../finalizar', {status: data.status, id: this.sender.chat, time: timer, restante: restantes});
                    window.location.href= '../';
                }
                else{
                    axios.post('../finalizar', {status: data.status, id: this.sender.chat, time: timer, restante: restantes});
                    $('#avaliation-modal').modal('show');
                }
            }
        },
        finishTimeOut()
        {
            //qual status de timeout?
            var statuss = 0;
            var chat = this.sender.chat;
            axios.post('../finalizar', {status: statuss, id: chat, time: timer, restante: restantes})
                .then((data) => {
                    console.log('Finalizado com sucesso!');
                    this.socket.emit('finishChat', {toUserId: this.receiver.id, status: statuss});
                    $('#avaliation-modal').modal('show');
                })
                .catch((e) => {
                    console.log('Erro ao finalizar: ', e)
                    this.socket.emit('finishChat', {toUserId: this.receiver.id, status: statuss});
                    $('#avaliation-modal').modal('show')
                });
        },
    }
}
</script>

<style scoped>
    .typing {
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        color: #c7bdbd;
        margin-bottom: 10px;
    }
</style>
