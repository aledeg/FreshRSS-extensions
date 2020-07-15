const adjustedDates = function (e) {
    let content = e.innerHTML;
    let date = moment(e.dateTime);
    let zoneDate = moment.parseZone(e.dateTime);
    content = content.replace(zoneDate.format('HH:mm'), date.format('HH:mm'));
    content = content.replace(zoneDate.format('MMMM'), date.format('MMMM'));
    content = content.replace(zoneDate.format('D'), date.format('D'));
    content = content.replace(zoneDate.format('YYYY'), date.format('YYYY'));
    content = content.replace(zoneDate.format('Do').replace(/[0-9]/g, ''), date.format('Do').replace(/[0-9]/g, ''));
    e.innerHTML = content;
}

const relativeDates = function (e) {
    e.innerHTML = moment(e.dateTime).fromNow();
}

const hours12 = function (e) {
    let content = e.innerHTML;
    let date = dateFormatConfiguration.adjustedDates ? moment(e.dateTime) : moment.parseZone(e.dateTime);
    let zoneDate = moment.parseZone(e.dateTime);
    e.innerHTML = content.replace(zoneDate.format('HH:mm'), date.format('hh:mm A'));
}

const dateFormat = function () {
    document.querySelectorAll('time[datetime]').forEach(e => {
        if (dateFormatConfiguration.relativeDates) {
            relativeDates(e);
        } else if (dateFormatConfiguration.hour12Dates) {
            hours12(e);
        } else if (dateFormatConfiguration.adjustedDates) {
            adjustedDates(e);
        }

        e.removeAttribute('dateTime');
    });
}

window.onload = function () {
    moment.locale(context.i18n.language);
    dateFormat();
}

document.body.addEventListener('freshrss:load-more', dateFormat);
