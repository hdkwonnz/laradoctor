<template>
    <div>
        <div class="row">
            <label for="name" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-form-label text-md-right">예약현황</label>
            <label for="name" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-form-label text-md-right">{{ selectedDate }}</label>
            <label for="name" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label text-md-right">Date</label>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">                    
                <input @input="showByDate()" type="date" name="date" v-model="selectedDate" class="form-control" required>
            </div>
        </div>
       
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>환자 이름</th>
                        <th>의사 이름</th>
                        <th>예약 일자</th>
                        <th>예약 시간</th>
                        <th>현재 상태</th>                       
                    </tr>
                </thead>
                <tbody>                  
                    <tr v-for="appointment in appointments" :key="appointment.id" >
                        <td>{{ appointment.patient.name }}</td>
                        <td>{{ appointment.doctor.name }}</td>
                        <td>{{ appointment.app_date }}</td>
                        <td>{{ appointment.app_time }}</td>
                        <td>{{ appointment.status }}</td>                       
                    </tr>                    
                </tbody>

            </table>
        </div> <!-- end table-responsive -->
              

        
    </div>   
</template>

<script>
    export default {
        data(){
            return{
                 selectedDate: '',
                 appointments: []
            }
        },

        methods: {
            showByDate(){
                let query = this.selectedDate;
                this.$Progress.start();//
                axios.get('/doctor/showAppointmentByDate?q=' + query)
                .then(response => {
                    this.appointments = response.data;
                    this.$Progress.finish();//
                })
                // .then((data) => {
                //   //this.users = data.data
                // })
                .catch(() => {

                })
            }  
            
            
        },

        created() {           
            
        },

        mounted() {
            
        }
    }
</script>
