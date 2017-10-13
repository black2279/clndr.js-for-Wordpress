jQuery(document).ready(function($){
    console.info(
        'Welcome to the CLNDR demo. Click around on the calendars and' +
        'the console will log different events that fire.');
	
	// Assuming you've got the appropriate language files,
    // clndr will respect whatever moment's language is set to.
    moment.locale('it');
	
    // The order of the click handlers is predictable. Direct click action
    // callbacks come first: click, nextMonth, previousMonth, nextYear,
    // previousYear, nextInterval, previousInterval, or today. Then
    // onMonthChange (if the month changed), inIntervalChange if the interval
    // has changed, and finally onYearChange (if the year changed).
    var calendar = $('.cal1').clndr({
        events: eventArray,
        clickEvents: {
            click: function (target) {
                console.log('Cal-1 clicked: ', target);
				eventsOfTheDay = target["events"];
				
				/* Reset box */
				$('.box').empty();
				
				/* Load Box if there are events to show */
				if (eventsOfTheDay.length){
					$('.box').append("<h6>" + (target["date"]).format("dddd DD MMMM YYYY") + "</h6>")
					for (var i=0; i < eventsOfTheDay.length; i++){
						$('.box').append("<a href='" + eventsOfTheDay[i]["link"] + "' >" + eventsOfTheDay[i]["title"] + "</a>");
					}
					$('.box').show();
				}else{
					$('.box').hide();
				}
            },
            today: function () {
                console.log('Cal-1 today');
            },
            nextMonth: function () {
                console.log('Cal-1 next month');
            },
            previousMonth: function () {
                console.log('Cal-1 previous month');
            },
            onMonthChange: function () {
                console.log('Cal-1 month changed');
            },
            nextYear: function () {
                console.log('Cal-1 next year');
            },
            previousYear: function () {
                console.log('Cal-1 previous year');
            },
            onYearChange: function () {
                console.log('Cal-1 year changed');
            },
            nextInterval: function () {
                console.log('Cal-1 next interval');
            },
            previousInterval: function () {
                console.log('Cal-1 previous interval');
            },
            onIntervalChange: function () {
                console.log('Cal-1 interval changed');
            }
        },
        multiDayEvents: {
            singleDay: 'date',
            endDate: 'endDate',
            startDate: 'startDate'
        },
        showAdjacentMonths: true,
        adjacentDaysChangeMonth: false,
		template: $('#int-template').html()
    });

    // Bind all clndrs to the left and right arrow keys
    $(document).keydown( function(e) {
        // Left arrow
        if (e.keyCode == 37) {
            calendar.back();
        }

        // Right arrow
        if (e.keyCode == 39) {
            calendar.forward();
        }
    });
});