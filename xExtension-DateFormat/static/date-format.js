const adjustedDates = function () {
    document.querySelectorAll('time[datetime]').forEach(e => {
        let content = e.innerHTML;
        let date = moment(e.dateTime);
        let zoneDate = moment.parseZone(e.dateTime);
        content = content.replace(zoneDate.format('HH:mm'), date.format('HH:mm'));
        content = content.replace(zoneDate.format('MMMM'), date.format('MMMM'));
        content = content.replace(zoneDate.format('D'), date.format('D'));
        content = content.replace(zoneDate.format('YYYY'), date.format('YYYY'));
        content = content.replace(zoneDate.format('Do').replace(/[0-9]/g, ''), date.format('Do').replace(/[0-9]/g, ''));
        e.innerHTML = content;
    });
}

const relativeDates = function () {
    document.querySelectorAll('time[datetime]').forEach(e => {
        e.innerHTML = moment(e.dateTime).fromNow();
    });
}

const hours12 = function () {
    document.querySelectorAll('time[datetime]').forEach(e => {
        let content = e.innerHTML;
        let date = dateFormatConfiguration.adjustedDates ? moment(e.dateTime) : moment.parseZone(e.dateTime);
        let zoneDate = moment.parseZone(e.dateTime);
        e.innerHTML = content.replace(zoneDate.format('HH:mm'), date.format('hh:mm A'));
    });
}

const dateFormat = function () {
    if (dateFormatConfiguration.relativeDates) {
        relativeDates();
    } else if (dateFormatConfiguration.hour12Dates) {
        hours12();
    } else if (dateFormatConfiguration.adjustedDates) {
        adjustedDates();
    }
}

window.onload = function () {
    moment.locale(context.i18n.language);
    dateFormat();
}

document.body.addEventListener('freshrss:load-more', dateFormat);
