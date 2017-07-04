$(document).ready(function () {
    var calendar = $('#calendar').calendar({
        language: 'fr-FR',
        events_source: '/evenement/ajax/liste',
        first_day: 1,
        view: 'month',
        weekbox: false,
        views: {
            year: {slide_events: 0, enable: 0},
            month: {slide_events: 0, enable: 0},
            week: {enable: 0},
            day: {enable: 0}
        },
        modal: "#calendar-events-modal",
        modal_type: "ajax",
        modal_title: function (event) {
            $('#calendar-events-modal-title').html(event.title)
            $('#calendar-events-modal-bouton-edition').attr('href', event.url_edition);
        },
        tmpl_path: "/libraries/calendar/tmpls/"
    });
});