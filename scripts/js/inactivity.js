//all credit to https://thisinterestsme.com/javascript-detect-user-activity/

function activityWatcher() {

    //The number of seconds that have passed
    //since the user was active.
    var secondsSinceLastActivity = 0;

    //Five minutes. 30min * 60sec = 1800 seconds.
    var maxInactivity = (1800);

    //Setup the setInterval method to run
    //every second. 1000 milliseconds = 1 second.
    setInterval(function () {
        secondsSinceLastActivity++;
        //if the user has been inactive or idle for longer
        //then the seconds specified in maxInactivity
        if (secondsSinceLastActivity > maxInactivity) {
            //Redirect them to your logout.php page.
            console.log('User has been inactive for more than ' + maxInactivity + ' seconds');
            location.href = 'logout.php';
        }
    }, 1000);

    //The function that will be called whenever a user is active
    function activity() {
        //reset the secondsSinceLastActivity variable
        //back to 0
        secondsSinceLastActivity = 0;
    }

    //An array of DOM events that should be interpreted as
    //user activity.
    var activityEvents = [
        'mousedown', 'mousemove', 'keydown',
        'scroll', 'touchstart'
    ];

    //add these events to the document.
    //register the activity function as the listener parameter.
    activityEvents.forEach(function (eventName) {
        document.addEventListener(eventName, activity, true);
    });


}

activityWatcher();