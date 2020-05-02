<template>
    <div>   
        <form v-if="formMsg" method="POST" action="" @submit.prevent="showAvailable()">           
            <div class="form-group row">
                <label for="name" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-form-label text-md-right">Doctor</label>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <!-- <select class="form-control" name="id">
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>-->
                    <select class="form-control" v-model="doctorId">
                        <option disabled value="">Please select one</option>
                        <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id" required>{{ doctor.name }}</option>                       
                    </select> 
                    <span v-if="errors.doctorId" class="error text-danger">{{ errors.doctorId[0] }}</span>
                    <!-- server side validation example -->
                    <!-- vue server side validation => www.youtube.com/watch?v=Iq4qGVkFNdo -->
                </div>

                <label for="date" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-form-label text-md-right">Date</label>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">                    
                    <input type="date" name="date" v-model="selectedDate" class="form-control" required>
                </div>                                                   
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-lg btn-primary">
                        Click
                    </button>
                </div>
            </div>
        </form>

        <!-- <div>*****{{ statuses.length }}*****</div> -->
        <!-- <div v-if="!statuses.length && errorMsg == true">예약이 완료되었거나 담당의사가 휴진하는 날 입니다.</div> -->
        <div v-if="statusSw">예약이 완료되었거나 담당의사가 휴진하는 날 입니다.</div>

        <div v-if="bodyMsg" class="mt-3">
            <!-- <div class="row" v-for="status in statuses" :key="status.id"> -->
            <div class="row">
                <div v-if="status.app_0800 != null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div v-if="status.app_0800 == user_patient_id" class="btn btn-success">
                        08:00 {{user_name}}님예약=><a href="#" class="text-danger" @click.prevent="cancelAppointment(status.id,'app_0800',status.doctor_id,status.app_date,'08:00')">취소?</a>
                    </div>
                    <div v-else class="btn btn-warning">
                        <span>08:00 이미예약</span>
                    </div>
                </div>      
                <div v-if="status.app_0800 == null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" class="btn btn-info text-light" @click.prevent="addAppointment(status.id,'app_0800',status.doctor_id,status.app_date,'08:00')">08:00 예약가능</a> 
                </div>
                <div v-if="status.app_0815 != null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div v-if="status.app_0815 == user_patient_id" class="btn btn-success">
                        08:15 {{user_name}}님예약=><a href="#" @click.prevent="cancelAppointment(status.id,'app_0815',status.doctor_id,status.app_date,'08:15')">취소?</a>
                    </div>
                    <div v-else>
                        <span>08:15 이미예약</span>
                    </div>               
                </div>      
                <div v-if="status.app_0815 == null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" class="btn btn-info text-light" @click.prevent="addAppointment(status.id,'app_0815',status.doctor_id,status.app_date,'08:15')">08:15 예약가능</a> 
                </div>
                <div v-if="status.app_0830 != null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div v-if="status.app_0830 == user_patient_id">
                        08:30 {{user_name}}님예약=><a href="#" @click.prevent="cancelAppointment(status.id,'app_0830',status.doctor_id,status.app_date,'08:30')">취소?</a>
                    </div>
                    <div v-else>
                        <span>08:30 이미예약</span>
                    </div>                                  
                </div>      
                <div v-if="status.app_0830 == null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" @click.prevent="addAppointment(status.id,'app_0830',status.doctor_id,status.app_date,'08:30')">08:30 예약가능</a> 
                </div>
                <div v-if="status.app_0845 != null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div v-if="status.app_0845 == user_patient_id">
                        08:45 {{user_name}}님예약=><a href="#" @click.prevent="cancelAppointment(status.id,'app_0845',status.doctor_id,status.app_date,'08:45')">취소?</a>
                    </div>
                    <div v-else>
                        <span>08:45 이미예약</span>
                    </div>                                                
                </div>      
                <div v-if="status.app_0845 == null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" @click.prevent="addAppointment(status.id,'app_0845',status.doctor_id,status.app_date,'08:45')">08:45 예약가능</a> 
                </div>
                <div v-if="status.app_0900 != null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div v-if="status.app_0900 == user_patient_id">
                        09:00 {{user_name}}님예약=><a href="#" @click.prevent="cancelAppointment(status.id,'app_0900',status.doctor_id,status.app_date,'09:00')">취소?</a>
                    </div>
                    <div v-else>
                        <span>09:00 이미예약</span>
                    </div>                    
                </div>      
                <div v-if="status.app_0900 == null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" @click.prevent="addAppointment(status.id,'app_0900',status.doctor_id,status.app_date,'09:00')">09:00 예약가능</a> 
                </div>
                <div v-if="status.app_1300 != null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div v-if="status.app_1300 == user_patient_id">
                        13:00 {{user_name}}님예약=><a href="#" @click.prevent="cancelAppointment(status.id,'app_1300',status.doctor_id,status.app_date,'13:00')">취소?</a>
                    </div>
                    <div v-else>
                        <span>13:00 이미예약</span>
                    </div>    
                </div>      
                <div v-if="status.app_1300 == null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" @click.prevent="addAppointment(status.id,'app_1300',status.doctor_id,status.app_date,'13:00')">13:00 예약가능</a> 
                </div>
                <div v-if="status.app_1315 != null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div v-if="status.app_1315 == user_patient_id">
                        13:15 {{user_name}}님예약=><a href="#" @click.prevent="cancelAppointment(status.id,'app_1315',status.doctor_id,status.app_date,'13:15')">취소?</a>
                    </div>
                    <div v-else>
                        <span>13:15 이미예약</span>
                    </div>                        
                </div>      
                <div v-if="status.app_1315 == null" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" @click.prevent="addAppointment(status.id,'app_1315',status.doctor_id,status.app_date,'13:15')">13:15 예약가능</a> 
                </div>            
            </div>
        </div>
        
        <div v-if="confirmMsg">
            {{ returnMsg }} {{ selectedTime }} {{ selectedDate }}
        </div>        
    </div>   
</template>

<script>
    //아래 import는 중요한 예제임.별도로 js file을 만들고 그것을 import하여 사용한다.(09/02/2020)
    //vue에서 외부의(resources/js/components/appointment) javascript file 를 사용하는 예제
    //is_weekend는 isWeekend.js 안에 있는 function
    import {is_weekend} from './isWeekend.js' //https://forum.vuejs.org/t/possible-to-call-external-javascript-functions-with-vuejs/16533
    export default {
        props:['user_email','user_name','user_patient_id'],

        data(){
            return{
                formMsg: true,
                bodyMsg: false,
                confirmMsg: false,
                selectedTime: '',
                returnMsg: '',
                //errorMsg: false,
                selectedDate: '',
                doctorId: '',
                doctors: [],
                // statuses: [],
                status: {},
                statusSw: false, //1302Feb 추가
                errors: []              
            }
        },

        methods: {
            cancelAppointment(statusId, colTime, doctorId, appDate,appTime){
                var message = "정말로 예약을 취소 하시겠습니까?";
                var result = confirm(message);
                if (result == true) {
                    this.$Progress.start();//
                    axios.post('/appointment/cancelAppointment',
                    {
                        statusId: statusId,
                        colTime: colTime,
                        doctorId: doctorId,
                        appDate: appDate,
                        appTime: appTime
                    })
                    .then(response => {
                        this.formMsg = false,
                        this.bodyMsg = false,
                        this.confirmMsg = true,
                        this.returnMsg = response.data,
                        this.selectedTime = appTime,
                        //this.showAvailable(),
                        this.$Progress.finish();//
                    }) //;                    
                    .catch(error => {
                        console.log(error);
                    });    
                }                                
            },

            addAppointment(statusId, colTime, doctorId, appDate,appTime){
                var message = "정말로 예약을 하시겠습니까?";
                var result = confirm(message);
                if (result == true) {
                    this.$Progress.start();//
                    axios.post('/appointment/addAppointment',
                        {
                            statusId: statusId,
                            colTime: colTime,
                            doctorId: doctorId,
                            appDate: appDate,
                            appTime: appTime
                        })
                        .then(response => {
                            this.formMsg = false,
                            this.bodyMsg = false,
                            this.confirmMsg = true,
                            this.returnMsg = response.data,
                            this.selectedTime = appTime,
                            //this.showAvailable(),
                            this.$Progress.finish();//                            
                        }) //;                    
                        .catch(error => {
                            //console.log(error);
                            // <!-- server side validation example -->매우 중요
                            // <!-- vue server side validation => www.youtube.com/watch?v=Iq4qGVkFNdo -->
                            if (error.response.status == 422){ //status => error status
                                this.errors = error.response.data.errors;
                            }                            
                        })                      
                }        
            },
            
            showAvailable(){
                //선택한 날짜가 주말인지 체크.별도로 js file을 만들고 그것을 import하여 사용한다.(09FEB2020)                                                        
                var today = is_weekend(this.selectedDate); //import {is_weekend} from './isWeekend.js'
                if (today == 0 || today == 6){
                    this.bodyMsg = false; //전에 내용이 있으면 지운다.
                    alert("선택하신 날짜는 휴일 입니다...");
                    return false;
                }

                if (this.doctorId == ""){
                    alert("Please select one of doctors...");
                    return false;
                }
                this.$Progress.start();//
                axios.post('/appointment/showStatus',
                    {
                        selectedDate: this.selectedDate,
                        doctorId: this.doctorId
                    })                    
                    // .then(response => {                       
                    //     this.status = response.data,
                    //     this.errorMsg = true,
                    //     this.bodyMsg = true,
                    //     this.$Progress.finish();//
                    .then(response => {                       
                        this.status = response.data
                        if (this.status == "" || this.status == null){
                            this.bodyMsg = false //status가 비어 있으면 두번째 화면은 숨기고 
                            this.statusSw = true //휴진 혹은 예약완료 메시지만 보여준다. 13FEB2020 추가.
                        } else {
                            //this.errorMsg = true
                            this.bodyMsg = true
                            this.statusSw = false
                        }
                        
                        this.$Progress.finish();//
                    }) //;               
                    .catch(error => {
                        // <!-- server side validation example -->매우 중요
                        // <!-- vue server side validation => www.youtube.com/watch?v=Iq4qGVkFNdo -->
                        if (error.response.status == 422){ //status => error status
                            this.errors = error.response.data.errors;
                        }
                    });                    
            },

            showDoctors(){
                this.$Progress.start();//
                axios.get('/appointment/showDoctors')
                .then(response => {
                    this.doctors = response.data,
                    this.$Progress.finish();//
                });               
            }
        },

        created() {
            if (this.user_patient_id == "" || this.user_patient_id == null){ //data base에는 NULL로 되어 있음
                this.formMsg = false;
                alert("아직 환자번호 입력이 안되었습니다... ");
            }else{
               this.showDoctors();
            }            
        },

        mounted() {
            //console.log('Component mounted.')
        }
    }
</script>
