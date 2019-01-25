<template>
    <div>
    <ul class="row consultant-list" v-if="consultores.length > 0">                 
            <li v-for="(consultor, index) in filteredConsultants" :class="'col-lg-4 col-md-6 item ' + consultor.status" :key="index">
                <div class="wrap-card">
                    <div class="cheader">
                        <h2 class="name">{{ consultor.nm_consultor }}</h2>
                        <h3 class="specialization">
                            <div v-if="consultor.especialidades">
                                <div v-if="consultor.especialidades.length == 1">
                                    {{ consultor.especialidades[0] }}
                                </div>
                                <div v-if="consultor.especialidades.length == 2">
                                     {{ consultor.especialidades[0] }} e {{ consultor.especialidades[1] }}
                                </div>
                                <div v-if="consultor.especialidades.length > 2">
                                     {{ consultor.especialidades[0] }} e {{ consultor.especialidades[1] }} ...
                                </div>
                            </div>

                        </h3>
                        <div class="text-center">
                            <span class="status-now">{{ consultor.status == 'offline' ? 'ocupado' : consultor.status }}</span>
                        </div>
                    </div>
                    <div class="perfil-photo">
                        <figure>
                            <img :src="'/images/especialistas/' + consultor.img_consultor" alt="especialistas">
                        </figure>
                    </div>
                    <p class="description text-justify p-3">
                        {{ consultor.ds_consultor }}
                    </p>
                    <div class="cfooter">
                        <div v-if="consultor.status == 'online'">
                            <a :href="'/consultores/show/' + consultor.cd_consultor" class="btn">
                                <div class="spriting"></div>chamar</a>
                        </div>
                        <div v-else>
                            <a :href="'/consultores/show/' + consultor.cd_consultor " class="btn" id="ocupado">
                                <div class="spriting"></div>chamar</a>
                        </div>
                    </div>
                </div>
            </li>      
       
        <div v-if="consultores.length == 0">
            <div class="col-12 h2-title center-sprite text-center">
                Não há consultores
            </div>
        </div>
    </ul>
</div>
</template>

<script>
export default {    
    props: ['consultores'],
    data () {
        return {
            socket: CreateConnectionSocket,
            filteredConsultants: []
        }
    },
    created() {
        //Listen for messages
        this.filteredConsultants = this.consultores;
        this.socket.emit('jointopublics');
        this.socket.on('mudaStatus', this.changeStatus);
    },
    methods: {
        changeStatus(data) {
            console.log(data);
            this.updateFilteredConsultantStatus(data);
        },
        updateFilteredConsultantStatus(data) {     
            this.filteredConsultants.forEach((x, index) => {                   
                if(x.cd_consultor == data.id_consultor) {
                    x.status = data.status ? 'online' : 'offline'
                }
            })                
        }
    }
}
</script>
