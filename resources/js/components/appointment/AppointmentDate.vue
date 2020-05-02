<template>
    <div>
        <div class="row">
            <label for="name" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label text-md-right">예약현황</label>
            <label for="name" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-form-label text-md-right">{{ selectedDate }}</label>
            <label for="name" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label text-md-right">Date</label>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">                    
                <input @input="showByDate()" type="date" name="date" v-model="selectedDate" class="form-control" required>
            </div>
            <label v-if="countSw" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-form-label text-md-right">총 {{ count[0] }}명</label>
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
                    <!-- 아래는 pagination을 사용하지 않을때 -->
                    <!-- <tr v-for="appointment in appointments" :key="appointment.id" > -->
                    <tr v-for="appointment in appointments.data" :key="appointment.id" >                       
                        <td @click.prevent="updateAppointment(appointment.id,appointment.doctor_email,appointment.app_date)">
                            <a href="javascript:void(0)">{{ appointment.patient.name }}</a>                            
                        </td>
                        <td>{{ appointment.doctor.name }}</td>
                        <td>{{ appointment.app_date }}</td>
                        <td>{{ appointment.app_time }}</td>
                        <td>
                            {{ appointment.status }}
                        </td>                        
                    </tr>
                </tbody>
            </table>           
        </div> <!-- end table-responsive -->

        <!-- for pagination -->
        <!-- <pagination :data="appointments" @pagination-change-page="getResults"></pagination> -->
        <pagination :data="appointments" align="center" :limit="2" @pagination-change-page="getResults"></pagination> 

    </div>   
</template>

<script>
    export default {
        data(){
            return{
                 countSw:false,
                 selectedDate: '',
                 count: {},//중요
                 //appointments: []
                 appointments: {}//중요
            }
        },

        methods: {
            //아래는 pagination을 사용할때 한개의 parameter 전달만 가능하다.
            // getResults(page = 1) { //for pagination
            //     this.$Progress.start();
            //     axios.get('/appointment/showAppointmentByDate?page=' + page)
            //         .then(response => {
            //             this.appointments = response.data;
            //         });
            //         this.$Progress.finish();
            //     },
            
            //아래는 pagination을 사용할때 한개 이상의 parameter 전달이 가능하다.
            getResults(page = 1) { //for pagination
                this.$Progress.start();////
                axios.get('/appointment/showAppointmentByDate?page=', { ////에러가 나면 옆의 "?page="을 제거 해 볼것.22/02/2020
                    params: {page: page, q: this.selectedDate}
                })
                    .then(response => {
                        this.appointments = response.data;
                    });
                    this.$Progress.finish();////
                },


            updateAppointment(id,doctorEmail,appDate){
                var message = "환자가 도착하였습니까?";
                var result = confirm(message);
                if (result == true) {
                    this.$Progress.start();//
                    axios.post('/appointment/updateAppointment', //for alert message
                    {
                        id: id                    
                    })
                    .then(response => {
                        this.showByDate();//update 후 refresh 한다.
                        this.$Progress.finish();//
                    }) //;                    
                    .catch(error => {
                        //
                    });                    
                }                
            },

            //아래는 pagination을 사용하지 않고 controller('/appointment/showAppointmentByDate')에서
            //두개의 parameter를 json으로 return하면 이곳 vue에서 받아서 처리한다.
            //pagination을 사용 할때는 두개의 parameter를 json으로 return하면 이곳 vue에서 어떻게
            //하는지 아직 방법을 차지 못 했음.(15FEB2020)
            // showByDate(){
            //     let query = this.selectedDate;
            //     this.$Progress.start();//
            //     axios.get('/appointment/showAppointmentByDate?q=' + query)
            //     .then(response => {
            //         //this.appointments = response.data;
            //         //아래 count 와 appointments는 AppointController에서 two objects를 동시에 보냄
            //         this.count = response.data.count;//매우 중요
            //         this.appointments = response.data.appointments[0];//매우 중요[0]사용.                    
            //         this.countSw = true;
            //         this.$Progress.finish();//
            //         })
            //     // .then((data) => {
            //     //   //this.users = data.data
            //     // })
            //     .catch(() => {

            //     })
            // }  
            
            //아래는 pagination을 사용 할때 한개의 parameter 처리만 가능
            // showByDate(){
            //     let query = this.selectedDate;
            //     this.$Progress.start();//
            //     axios.get('/appointment/showAppointmentByDate?q=' + query)  
            //     .then(({data}) =>
            //       (this.appointments = data))                
            //     .catch(() => {

            //     })
            // }
            
            //아래는 pagination을 사용 할때 한개 이상의 parameter 처리가 가능
            showByDate(){
                let query = this.selectedDate;
                this.$Progress.start();//
                //axios.get('/appointment/showAppointmentByDate?q=' + query)
                axios.get('/appointment/showAppointmentByDate', {
                    params:{q: query}
                    })                            
                .then(({data}) =>
                  (this.appointments = data))                
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
