<template>
    <ul class="timing-status-list">
        <li class="left-time">
            <div class="wrap">
                <span class="spriting sprite-timing-left"></span>
                <div class="content">
                    <h6 class="title">Tempo Restante</h6>
                    <span id="tempo">{{ horaImprimivel }}</span>
                </div>
            </div>
        </li>
        <li class="spent-time">
            <div class="wrap">
                <span class="spriting sprite-timing-spent"></span>
                <div class="content">
                    <h6 class="title">Tempo Gasto</h6>
                    <span id="cronometro">{{ horaImprimivel2 }}</span>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    props: ['startvalue','leftseconds', 'idatendimento', 'receiver', 'sender'],
    data() {
        return {
            tempo: '',
            cronometro: 0,
            horaImprimivel: '',
            horaImprimivel2: '',
            socket: CreateConnectionSocket,
            tempoAtual: 0,
            cronometroAtual: 0,
            TempoTimeOut: 0,
            verifica: true
        }
    },
    created() {
        this.socket.emit("join", {
            user_id: this.sender.id,
            name: this.sender.name,
            role: this.sender.role,
            receiver_id: this.receiver.id,
            chat: this.sender.chat
        });
        this.horaImprimivel = this.startvalue;
        this.tempo = parseInt(this.leftseconds);
        window.timer = 0;
        window.restantes = this.tempo;
        this.tempoAtual = this.tempo;
    },
    mounted() {
        this.socket.on('startTimer', () =>
        {
            console.log('nice');
            this.startCountdown();
        });
        this.socket.on('responseGet', () =>
        {
            this.cronometroAtual = this.cronometro;
            this.tempoAtual = this.tempo;
            this.TempoTimeOut = 0;
        });
    },
    methods: {
        startCountdown() {

            //console.log('tempo: ', tempo)
            if ((this.tempo - 1) >= 0) {
                if(this.TempoTimeOut >= 120)
                {
                    console.log('fim');
                    this.SemResposta(this.verifica);
                } else {
                var hora = parseInt(this.tempo / 3600);
                var min = parseInt(this.tempo/60 % 60);
                var seg = this.tempo % 60;
                if (hora < 10) {
                    hora = "0" + hora;
                    hora = hora.substr(0, 2);
                }
                if (min < 10) {
                    min = "0" + min;
                    min = min.substr(0, 2);
                }
                if (seg <= 9) {
                    seg = "0" + seg;
                }
                if(hora>0)
                    this.horaImprimivel = hora + ':' + min + ':' + seg;
                else
                this.horaImprimivel = min + ':' + seg;
                var hora2 = parseInt(this.cronometro / 3600);
                var min2 = parseInt(this.cronometro/60 % 60);
                var seg2 = this.cronometro % 60;
                if (hora2 < 10) {
                    hora2 = "0" + hora2;
                    hora2 = hora2.substr(0, 2);
                }
                if (min2 < 10) {
                    min2 = "0" + min2;
                    min2 = min2.substr(0, 2);
                }
                if (seg2 <= 9) {
                    seg2 = "0" + seg2;
                }
                if(hora2>0) { this.horaImprimivel2 = hora2 + ':' + min2 + ':' + seg2 }
                else { this.horaImprimivel2 = min2 + ':' + seg2; }
                //console.log('horaimp1: ', this.horaImprimivel)
                //console.log('horaimp2: ', this.horaImprimivel2)
                setTimeout(this.startCountdown, 1000);
                timer = this.cronometro;
                restantes = this.tempo;
                this.tempo--;
                this.cronometro++;

                this.TempoTimeOut++;
            }
            }
            else {
                this.socket.emit('finishChat', {toUserId: this.receiver.id, status: 1});
            }
        },
        SemResposta(verifica)
        {
                if(verifica)
                {
                    this.verifica = false;
                    this.socket.emit('finishChat', {fromUserId: this.receiver.id, toUserId: this.sender.id, status: 6});
                    axios.post('../finalizar', {status: 7, id: this.idatendimento, time: this.cronometroAtual, restante: this.tempoAtual});
                    $('#avaliation-modal').modal('show');
                }


        }
    }
}
</script>
