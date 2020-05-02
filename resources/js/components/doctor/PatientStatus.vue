<template>
    <div>         
        <div class="table-responsive mt-2">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>환자이름</th>                                               
                        <th>예약시간</th>
                        <th>현재상태</th>                       
                    </tr>
                </thead>
                <tbody>                  
                    <tr v-for="appointment in appointments" :key="appointment.id" >
                        <td>{{ appointment.patient.name }}</td>                                             
                        <td>{{ appointment.app_time }}</td>
                        <td>{{ appointment.status }}</td>                       
                    </tr>                    
                </tbody>
            </table>
        </div>        
    </div>   
</template>

<script>
    export default {
        props:['user_email'],

        data(){
            return{                 
                 appointments: []
            }
        },

        created() {
            //금일치만 보여 준다.
            this.$Progress.start();//        
            axios.post('/appointment/showPatientStatus', //for arrival status
                {                       
                    doctorEmail: this.user_email                                       
                })
                .then(response => {
                    this.appointments = response.data;
                    this.$Progress.finish();//
                })      
                .catch(error => { 
                    console.log(error);
                });       
        },

        methods: {
            
        },      

        mounted() {
            Echo.private('patient-status')
                .listen('PatientStatusEvent', (appointment) => {
                    if (this.user_email == appointment.doctor_email){        
                        this.appointments.push(appointment);
                    }
                });
        }
    }
</script>
