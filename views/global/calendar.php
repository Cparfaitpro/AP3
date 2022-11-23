<link href="/public/home.css" rel="stylesheet"/>
<script src='/public/fullcalendar/lib/main.js'></script>
<link href="/public/fullcalendar/lib/main.css" rel="stylesheet">

<div id="calendar"></div>

<script>

    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        navLinks: true,
        navLinkDayClick: function(date, jsEvent) {
            console.log('day', date.toISOString());
            console.log('coords', jsEvent.pageX, jsEvent.pageY);
        },
        events: [
            <?php foreach ($calendrier as $atelier) { ?>
            { // this object will be "parsed" into an Event Object
            id: "<?= $atelier['id_atelier'] ?>",
            title: "<?= $atelier['nom_atelier'] ?>", // a property!
            start: "<?= $atelier['datejourdebut'] ?>", // a property!
            end: "<?= $atelier['datejourfin'] ?>", // a property! ** see important note below about 'end' **
            },
            <?php } ?>
        ],
        eventColor: '#378006',
        eventClick: function(info) {
            window.location.href = "/atelier/" + info.event.id;
        }
    });
    calendar.render();
});

</script>