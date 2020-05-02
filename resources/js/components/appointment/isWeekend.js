//중요한 예제
//DoctorSchedule.vue에서 import 하여 사용한다.
//https://forum.vuejs.org/t/possible-to-call-external-javascript-functions-with-vuejs/16533
//https://stackoverflow.com/questions/21675631/typeerror-getday-is-not-a-function
function is_weekend(selectedDate)
{
    // var today = selectedDate.getDay();
    // return today;

    var convertedDate = new Date(selectedDate);

    return (convertedDate.getDay());
    
}

export {is_weekend}