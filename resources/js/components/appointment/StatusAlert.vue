<template>
 <div>    
     <alert v-model="showAlert" placement="top-right" duration="3600000" type="success" width="400px" dismissable>
        <span class="icon-ok-circled alert-icon-float-left"></span>
        <strong>appointment Status Updated</strong>
        <p>환자 {{ patientName }} 님이 대기 중 입니다...</p>
    </alert>
 </div>
</template>

<script>
    import { alert } from 'vue-strap'
    export default {
        components: {
            alert
        },

        props:['user_email'],

        data(){
            return{
                patientName: '',
                showAlert: false
            }
        },

        mounted() {           
            // Echo.channel('appointment-status')
            Echo.private('appointment-status')
            .listen('AppointmentStatus', (appointment) => {
                if (this.user_email == appointment.doctor_email){
                    this.showAlert = true;
                    //console.log("appointment from StatusAlert => " + appointment);
                    this.patientName = appointment.patient_name;
                }                
            });
        }        
    }     
</script>