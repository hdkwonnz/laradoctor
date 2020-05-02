<template>
    <div>
        <div class="row">
            <div class="col-lg-1">NAME</div>
            <div class="col-lg-3">HOLIDAY</div>
            <div class="col-lg-1">MON</div>
            <div class="col-lg-1">TUE</div>
            <div class="col-lg-1">WED</div>
            <div class="col-lg-1">THU</div>
            <div class="col-lg-1">FRI</div>
        </div>
        <div>
            <div v-for="doctor in doctors" :key="doctor.id" class="row">
                <div class="col-lg-1"><a href="">{{doctor.name}}</a></div>
                <div class="col-lg-3">{{doctor.from}} ==> {{doctor.to}}</div>                
                <div class="col-lg-1">{{doctor.mon}}</div>
                <div class="col-lg-1">{{doctor.tue}}</div>
                <div class="col-lg-1">{{doctor.wed}}</div>
                <div class="col-lg-1">{{doctor.thu}}</div>
                <div class="col-lg-1">{{doctor.fri}}</div>
            </div>
        </div>     
    </div>   
</template>

<script>
    export default {
        data(){
            return{
                doctors: []        
            }
        },

        methods: {
                //, //for parameters passing test
                // { //for parameters passing test
                // //     params:{id: "222", name: "kkk"} //for parameters passing test
                // }) //for parameters passing test                              
        },

        created() {
            this.$Progress.start();//            
            axios.get('/doctor/getTimeTable')                             
                .then(response => {
                    this.doctors = response.data;
                    this.$Progress.finish();//
                })              
                .catch(() => {

                })
             
            ////multiple parameters를 passing 할때 get 으로 보낼때 예제 ==> 매우 중요
            //아래는 parameters를 passing 할때 example 
            // axios.get('/doctor/getTimeTable', {
            //     params:{id: "222", name: "kkk"
            //         }
            //     })                             
            //     .then(response => {
            //         this.doctors = response.data;
            //         this.$Progress.finish();//
            //     })              
            //     .catch(() => {
            //     })
        },

        mounted() {
            
        }
    }
</script>
