//alert('contractor-stopwatch.js active!');
var startTimerButton = document.querySelector('.startTimer');
var pauseTimerButton = document.querySelector('.pauseTimer');
var timerDisplay = document.querySelector('.timer');
var startTime;
var updatedTime;
var difference;
var tInterval;
var savedTime = 0;
var paused = 0;
var running = 0;
var cnt = 0;
var sessions_id = [];
var sessions_startstamp = [];
var sessions_endstamp = [];
var sessions_totaltime = 0;

function removeMe($instance){
    
    var item = jQuery($instance)[0];
    var id = item.getAttribute("id");
    for (i = 0; i< sessions_id.length; i++) {
        if (sessions_id[i] == id){
            sessions_id.splice(i, 1);
            
            savedTime = savedTime - (sessions_endstamp[i] - sessions_startstamp[i]);
            updatedTime = startTime;
            getShowTime();
            sessions_endstamp.splice(i, 1);
            sessions_startstamp.splice(i, 1);
            break;
        }
    }
    jQuery($instance)[0].closest('div').remove();
    
    
}
function Add_sessions_onDiv(){
    
    cnt++;
    
    var hours = Math.floor(((updatedTime - startTime) % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor(((updatedTime - startTime) % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor(((updatedTime - startTime) % (1000 * 60)) / 1000);
    var milliseconds = Math.floor(((updatedTime - startTime) % (1000 * 60)) / 100);
    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    seconds = (seconds < 10) ? "0" + seconds : seconds;
    milliseconds = (milliseconds < 100) ? (milliseconds < 10) ? "00" + milliseconds : "0" + milliseconds : milliseconds;
    jQuery(item).innerHTML = hours + ':' + minutes + ':' + seconds + ':' + milliseconds;
    var add_item = '<div>' + '<span class = "sessionspan" id = "session'+ cnt + '" onclick = removeMe(this)>'  +  ' [X] ' + '</span>' + 
    '<span>'  +  minutes + ':' + seconds + ':' + milliseconds + '</span>'+ '</div>';
    var item = jQuery("#clock_session").append(add_item);            

    sessions_id.push("session" + cnt);
    sessions_startstamp.push(startTime);
    sessions_endstamp.push(updatedTime);
    
}


function Send_GetRequest(){
    var id  = jQuery("#post_ID")[0].getAttribute("value");
    jQuery.ajax({
      type: "GET",
      url: 'http://ec2-52-90-97-71.compute-1.amazonaws.com/wp-json/contractor-stopwatch/v1/get-data?postID='+ id,
    //   data: data,
      success: function(data){
            // do something;
      },
      dataType: "text"
    });
}

function Send_PostRequest(){
    var id  = jQuery("#post_ID")[0].getAttribute("value");
    
    var formData = {
       "postID":id,
       "sessions":[
          { 
             "start":startTime,
             "stop":updatedTime
          }
       ]
    }
    
    jQuery.ajax({
      type: "POST",
      url: 'http://ec2-52-90-97-71.compute-1.amazonaws.com/wp-json/contractor-stopwatch/v1/save-data',
      data: formData,
      dataType: "text",
      success: function(data){
            //do something;
      },
      
    });
}
function startTimer(){

    if(!running){
        startTime = new Date().getTime();
        tInterval = setInterval(upDateShowTime, 1);
// change 1 to 1000 above to run script every second instead of every millisecond. one other change will be needed in the getShowTime() function below for this to work. see comment there.
        paused = 0;
        running = 1;
        timerDisplay.style.background = "#FF0000";
        timerDisplay.style.cursor = "auto";
        timerDisplay.style.color = "yellow";
        startTimerButton.classList.add('lighter');
        pauseTimerButton.classList.remove('lighter');
        startTimerButton.style.cursor = "auto";
        pauseTimerButton.style.cursor = "pointer";
    }
}
//svn relocate protocol://currentUser@server/path protocol://newUser@server/path
function pauseTimer(){
    if (!difference){
        // if timer never started, don't allow pause button to do anything
    } else if (!paused) {
        clearInterval(tInterval);
        savedTime= difference;
        paused = 1;
        running = 0;
        timerDisplay.style.background = "#A90000";
        timerDisplay.style.color = "#690000";
        timerDisplay.style.cursor = "pointer";
        startTimerButton.classList.remove('lighter');
        pauseTimerButton.classList.add('lighter');
        startTimerButton.style.cursor = "pointer";
        pauseTimerButton.style.cursor = "auto";
        Add_sessions_onDiv();
        Send_PostRequest();
    } else {
// if the timer was already paused, when they click pause again, start the timer again
        startTimer();
    }
}
function resetTimer(){
    clearInterval(tInterval);
    if (difference && !paused){
        Send_PostRequest();
        Add_sessions_onDiv();
    }
    var timerDisplay = document.querySelector('.timer');
    
    savedTime = 0;
    difference = 0;
    paused = 0;
    running = 0;
    timerDisplay.innerHTML = 'Start Timer!';
    timerDisplay.style.background = "#A90000";
    timerDisplay.style.color = "#fff";
    timerDisplay.style.cursor = "pointer";
    startTimerButton.classList.remove('lighter');
    pauseTimerButton.classList.remove('lighter');
    startTimerButton.style.cursor = "pointer";
    pauseTimerButton.style.cursor = "auto";
    
    sessions_endstamp = [];
    sessions_id = [];
    sessions_startstamp = [];
    jQuery("#clock_session").empty();
    
}
function upDateShowTime(){
    updatedTime = new Date().getTime();
    getShowTime();
}
function getShowTime(){
    difference = (updatedTime - startTime) + savedTime;
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