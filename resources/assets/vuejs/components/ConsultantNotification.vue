<template>
    <div class="row r-m single-box">
        <div class="col-lg-7">
            <div class="wrap d-flex align-items-start wrap-xs">
                <!-- Spinner -->
                <div class="spinner">
                    <div class="lds-dual-ring"></div>
                </div>
                <!-- End spinner -->
                <div class="content">
                    <p class="alerting">
                        <span>Mantenha esta janela aberta</span> para ser alertado quando novos atendimentos
                        forem iniciados
                    </p>
                    <div v-if="notifications">
                        <div class="btns d-flex flex-wrap align-items-center mb-3" v-for="(notification,index) in notifications" :key="index">
                            <span class="d-block w-100 mb-1 notify">
                                <strong>{{ notification.visitor_name}}</strong> está te chamando!
                            </span>
                            <a :href="'chat-consultor/'+notification.chat" class="btn btn-accept"
                            @click.prevent="emitConsultantChoose(true, notification.visitor_id, notification.chat)">Iniciar atendimento</a>
                            <a href="" class="btn btn-deny"
                            @click.prevent="emitConsultantChoose(false, notification.visitor_id, notification.chat)">Ignorar atendimento</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="wrap">
                <h4>Status de sua conexão:</h4>
                <p class="paragraph">Aguardando novo atendimento</p>
                <div class="center-sprite">
                    <span class="spriting sprite-timeglass"></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['consultantid'],
    data() {
        return {
            notifications: [],
            socket: CreateConnectionSocket,
        }
    },
    created() {
         this.socket.emit("listenForVisitorNotifications", {
            role: 2,
            consultant_id: this.consultantid
         })
    },
    mounted() {
        this.socket.on('callConsultantForChat', this.answerVisitor)
    },
    methods: {
        answerVisitor(data) {
            console.log('Novo pedido de chat por: ', data.visitor_name);
            //if there's already a call from a SAME visitor, it removes the old notification and the new one is added.
             this.notifications = this.notifications.filter((x) => {
                    return x.visitor_id != data.visitor_id;
            });
            console.log(this.notifications)
            this.notifications.push(data);
        },
        emitConsultantChoose(accept, id, chat) {
            if(accept) {
                this.socket.emit('answerVisitorRequest', {accepted: true, visitor_id: id });
                window.location.href = 'painel-consultor/chat-consultor/'+chat;
            }else {
                this.socket.emit('answerVisitorRequest', {accepted: false, visitor_id: id });
                this.notifications = this.notifications.filter((x) => {
                    return x.visitor_id != id;
                });
            }
        }
    }
}
</script>

<style scoped>
    .notify {
        font-family: Poppins, sans-serif;
        font-size: 14px;
    }
</style>
