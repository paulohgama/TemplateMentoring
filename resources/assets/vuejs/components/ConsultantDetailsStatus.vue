<template>
<div>    
    <div :class="'perfil-desc-content ' + status">
        <div class="container">
            <div class="row">
                <div class="col-md-4 photo">
                    <figure>
                        <img :src="'/images/especialistas/' + consultor.img_consultor" alt="">
                    </figure>
                    <div class="shares-list">
                        <ul>
                            <li><a href="http://www.facebook.com/sharer.php?u=" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a :href="'https://twitter.com/intent/tweet?text=Venha+se+consultar+também+no+site+do+Tarot+Nova+Era+http%3A%2F%2F127.0.0.1%3A8000%2Fconsultores%2Fshow%2F' + consultor.cd_consultor" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
                     <span class="status-now">{{ status == '' ? 'Online' : 'Ocupado'}}</span>
                     <slot name="slot1"></slot>    
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['statusclass', 'consultor', 'idcomponente'],
    data () {
        return {
            socket: CreateConnectionSocket,    
            status: ''        
        }
    },
    created() {
        this.status = this.statusclass ? 'offline' : '';
        this.socket.emit('jointopublics');
        this.socket.on('mudaStatus', this.changeStatus);
    },
    methods: {
        changeStatus(data) {
            console.log(data);
             data.status ? this.status = '' : this.status = 'offline';
        }
    }
}
</script>
