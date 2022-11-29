

moment.locale('en');

var deviceTime,
    serverTime,
    actualTime,
    subtractTime,
    timeOffset;

// Run each second lap to show times in real time
var updateDisplay = function() {
    // Show static time data

    thisTime = actualTime.tz($timezone);
    subtractTime = subtractTime.tz($timezone);

    $('.date-time').html(thisTime.format('ddd, DD MMM, YYYY - H:mm:ss'));
    $('.timezone').html('GMT '+thisTime.format('Z'));

    if($('.input-daterange.datetime').is('div') && $('.input-daterange.datetime').find('input:text').val()==''){
        $('.input-daterange.datetime #start').attr('placeholder', subtractTime.format('DD MMM YYYY hh:mm A'));
        $('.input-daterange.datetime #start').attr('data-selected', subtractTime.format('YYYY-MM-D H:mm'));

        $('.input-daterange.datetime #end').attr('placeholder', thisTime.format('DD MMM YYYY hh:mm A'));
        $('.input-daterange.datetime #end').attr('data-selected', thisTime.format('YYYY-MM-D H:mm'));
    }
};

var timerHandler = function() {
    // Get current time on the device
    actualTime = moment();
    subtractTime = moment().subtract(3, 'hours');

    // Add the calculated offset
    actualTime.add(timeOffset);
    subtractTime.add(timeOffset);

    // Show our new results
    updateDisplay();

    // Re-run this next second wrap
    setTimeout(timerHandler, (1000 - (new Date().getTime() % 1000)));
};

// Fetch the servern time through a HEAD request to current URL
// using asynchronous request.
var fetchServerTime = function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        var dateHeader = xmlhttp.getResponseHeader('Date');

        // Just store the current time on device for display purpose
        deviceTime = moment();

        // Turn the "Date:" header field into a "moment" object,
        // use JavaScript Date() object as parser
        serverTime = moment(new Date(dateHeader)); // Read

        // Store the differences between device time and server time
        timeOffset = serverTime.diff(moment());

        // Now when we've got all data, trigger the timer for the first time
        timerHandler();
    }
    xmlhttp.open("HEAD", window.location.href);
    xmlhttp.send();
}

// Trigger the whole procedure
fetchServerTime();
