<template>
    <div>
        <vue-snotify></vue-snotify>
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
            consultant_id: this.consultantid,
        })
        console.log('consultantid: ', this.consultantid)
    },
    mounted() {
        this.socket.on('callConsultantForChat', (data) => {
            this.notifications = this.notifications.filter((x) => {
                return x.visitor_id != data.visitor_id;
            });
            console.log(this.notifications)
            this.notifications.push(data);
            this.activePopup(data);
        })
    },
    methods: {
        activePopup(notification) {
            this.$snotify.confirm(notification.visitor_name +' está chamando!', 'Nova solicitação',{
            timeout: 300000,
            showProgressBar: true,
            closeOnClick: true,
            pauseOnHover: true,
            preventDuplicates: true,
            oneAtTime: false,

            buttons: [
                {
                    text: 'Iniciar',
                    bold: true,
                    action: (toast) => {
                        console.log('Aceitou');
                        this.emitConsultantChoose(true, notification.visitor_id, notification.chat)
                        this.$snotify.remove(toast.id);
                    },

                },
                {
                    text: 'Ignorar',
                    bold: false,
                    action: (toast) => {
                        console.log('Ignorou');
                        this.emitConsultantChoose(false, notification.visitor_id, notification.chat)
                        this.$snotify.remove(toast.id);
                    },
                },
                // {text: 'Later', action: (toast) => {console.log('Clicked: Later'); this.$snotify.remove(toast.id); } },
                // {text: 'Close', action: (toast) => {console.log('Clicked: No'); this.$snotify.remove(toast.id); }, bold: true},
            ]
            });
        },
        emitConsultantChoose(accept, id, chat) {
            if(accept) {
                this.socket.emit('answerVisitorRequest', {accepted: true, visitor_id: id });
                window.location.href = this.getBasePath() + 'painel-consultor/chat-consultor/'+chat;
            }else {
                this.socket.emit('answerVisitorRequest', {accepted: false, visitor_id: id });
                this.notifications = this.notifications.filter((x) => {
                    return x.visitor_id != id;
                });
            }
        },
        getBasePath () {
            let url = window.location.href;
            let arr = url.split("/");
            return arr[0] + "//" + arr[2] + '/'
        }
    }
}
</script>
