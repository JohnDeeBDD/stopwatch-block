var startTimerButton = document.querySelector('.startTimer');
var pauseTimerButton = document.querySelector('.pauseTimer');
var timerDisplay = document.querySelector('.timer');
var startTime = 0;
var updatedTime = 0;
var tInterval;
var savedTime = 0;
var sessionNumber = 0;
var sessions_id = [];
var startStopArray = [];


function remove_Session($instance) {
    
    var item = jQuery($instance)[0];
    var id = item.getAttribute("id");
    for (i = 0; i< sessions_id.length; i++) {
        if (sessions_id[i] == id){
            sessions_id.splice(i, 1);
            savedTime = savedTime - (startStopArray[2 * i + 1] - startStopArray[2 * i]);
            updatedTime = startTime;
        
            getShowTime();
            startStopArray.splice(2 * i, 2);
            break;
        }
    }
    jQuery($instance)[0].closest('div').remove();
    Session_Post_Request();
    calc_Wage();

}
function Add_session_onDiv(updatedTime, startTime){
    sessionNumber++;
    var hours = Math.floor(((updatedTime - startTime) % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor(((updatedTime - startTime) % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor(((updatedTime - startTime) % (1000 * 60)) / 1000);
    var milliseconds = Math.floor(((updatedTime - startTime) % (1000 * 60)) / 100);
    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    seconds = (seconds < 10) ? "0" + seconds : seconds;
    milliseconds = (milliseconds < 100) ? (milliseconds < 10) ? "00" + milliseconds : "0" + milliseconds : milliseconds;
    jQuery(item).innerHTML = hours + ':' + minutes + ':' + seconds + ':' + milliseconds;
    var add_item = '<div>' + '<span class = "sessionspan" id = "session'+ sessionNumber + '" onclick = remove_Session(this)>'  +  ' [X] ' + '</span>' + 
    '<span>'  +hours + ':' +   minutes + ':' + seconds + ':' + milliseconds + '</span>'+ '</div>';
    var item = jQuery("#clock_session").append(add_item);
    
    sessions_id.push("session" + sessionNumber);

}

function Session_Post_Request(){
    var postID  = jQuery("#post_ID")[0].getAttribute("value");

    var send_data = JSON.stringify(startStopArray);
    jQuery.ajax('/wp-json/contractor-stopwatch/v1/save-data', {
        type: 'POST',  // http method
        data: { 'postID': postID, 'data': send_data },  // data to submit
        success: function (data, status, xhr) {

        },
        error: function (jqXhr, textStatus, errorMessage) {
            //alert('failure!');
        }
    });
}

function startTimer(){
    
    if(startStopArray.length%2==0){
        startTime = new Date().getTime();

        // change 1 to 1000 above to run script every second instead of every millisecond.
        // one other change will be needed in the getShowTime() function below for this to work. see comment there.
        tInterval = setInterval(upDateShowTime, 1);

        timerDisplay.style.background = "#FF0000";
        timerDisplay.style.cursor = "auto";
        timerDisplay.style.color = "yellow";
        
        startTimerButton.classList.add('lighter');
        pauseTimerButton.classList.remove('lighter');
        startTimerButton.style.cursor = "auto";
        pauseTimerButton.style.cursor = "pointer";
        startStopArray.push(startTime);
        Session_Post_Request();
    }
    
}
function pauseTimer(){
    
    if (updatedTime == startTime){
        // if timer never started, don't allow pause button to do anything
    } else if (startStopArray.length%2==1) {
        clearInterval(tInterval);
        savedTime += updatedTime- startTime;
        timerDisplay.style.background = "#A90000";
        timerDisplay.style.color = "#690000";
        timerDisplay.style.cursor = "pointer";
        startTimerButton.classList.remove('lighter');
        pauseTimerButton.classList.add('lighter');
        startTimerButton.style.cursor = "pointer";
        pauseTimerButton.style.cursor = "auto";
        
        startStopArray.push(updatedTime);
        Add_session_onDiv(updatedTime, startTime);
        Session_Post_Request();
        calc_Wage();
    } else {
// if the timer was already paused, when they click pause again, start the timer again
        startTimer();
    }
}
function calc_Wage(){
    var len = startStopArray.length;
    var tot_time = 0;
    for (i = 0; i<len; i+=2){
        if (i + 1 == len) break;
        tot_time += startStopArray[i+1]-startStopArray[i];
    }

    var amount = tot_time * jQuery("#rate").val()/ 1000/3600;
    amount = amount.toLocaleString(swLocale, { style: 'currency', currency: swCurrency });
    jQuery("#total").val(amount);
}

function resetTimer(){
    clearInterval(tInterval);
    var timerDisplay = document.querySelector('.timer');
    savedTime = 0;
    updatedTime = 0, startTime = 0;
    timerDisplay.innerHTML = 'Start Timer!';
    timerDisplay.style.background = "#A90000";
    timerDisplay.style.color = "#fff";
    timerDisplay.style.cursor = "pointer";
    startTimerButton.classList.remove('lighter');
    pauseTimerButton.classList.remove('lighter');
    startTimerButton.style.cursor = "pointer";
    pauseTimerButton.style.cursor = "auto";
    sessions_id = [];
    startStopArray = [];
    calc_Wage();
    jQuery("#clock_session").empty();
    Session_Post_Request();
}

function upDateShowTime(){
    updatedTime = new Date().getTime();
    getShowTime();
}

function getShowTime(){
    var difference = (updatedTime - startTime) + savedTime;
    // var days = Math.floor(difference / (1000 * 60 * 60 * 24));
    var hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((difference % (1000 * 60)) / 1000);
    var milliseconds = Math.floor((difference % (1000 * 60)) / 100);
    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    seconds = (seconds < 10) ? "0" + seconds : seconds;
    milliseconds = (milliseconds < 100) ? (milliseconds < 10) ? "00" + milliseconds : "0" + milliseconds : milliseconds;
    timerDisplay.innerHTML = hours + ':' + minutes + ':' + seconds + ':' + milliseconds;
}

jQuery('document').ready(function() {
    var postID  = jQuery("#post_ID")[0].getAttribute("value");
    jQuery.ajax('/wp-json/contractor-stopwatch/v1/get-data', {
        type: 'POST',  // http method
        data: { 'postID': postID},  // data to submit
        success: function (data, status, xhr) {

            data = JSON.parse(data);
            var index =0;
            jQuery.each(data, function(){
                startStopArray.push(data[index]);
                index ++;
            });

            savedTime = 0;

            for (i = 0; i<Math.floor(startStopArray.length/2); i++){
                Add_session_onDiv(startStopArray[2*i+1], startStopArray[2*i]);
                savedTime += startStopArray[2*i+1] - startStopArray[2*i];
            }
            getShowTime();
            calc_Wage();
            if (startStopArray.length %2){
                startStopArray.pop();
                startTimer();
            }

        },
        error: function (jqXhr, textStatus, errorMessage) {
            //alert('failure!');
        }
    });
});
function ManualSubmit(){
    if (startStopArray.length%2 == 1) return;
    var  manual_time = jQuery("#manual_text").val() * 1000;
    var now = new Date().getTime();
    startStopArray.push(now - manual_time);
    startStopArray.push(now);
    Session_Post_Request();
    savedTime+=manual_time;
    Add_session_onDiv(manual_time, 0);
    updatedTime =0, startTime = 0;
    getShowTime();
    calc_Wage();
    manual_time = 0;

}
var swLocale  = jQuery("#sw-locale")[0].getAttribute("value");
var swCurrency  = jQuery("#sw-currency")[0].getAttribute("value");
