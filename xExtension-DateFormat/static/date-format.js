const adjustedDates = (e) => {
    let content = e.innerHTML;
    let date = moment(e.dateTime);
    let zoneDate = moment.parseZone(e.dateTime);
    const timeFormat = dateFormatConfiguration.hour12Dates ? 'hh:mm A' : 'HH:mm';
    content = content.replace(zoneDate.format('HH:mm'), date.format(timeFormat));
    content = content.replace(zoneDate.format('MMMM'), date.format('MMMM'));
    content = content.replace(zoneDate.format('D'), date.format('D'));
    content = content.replace(zoneDate.format('YYYY'), date.format('YYYY'));
    content = content.replace(zoneDate.format('Do').replace(/[0-9]/g, ''), date.format('Do').replace(/[0-9]/g, ''));
    e.innerHTML = content;
}

const relativeDates = (e) => {
    e.innerHTML = moment(e.dateTime).fromNow();
}

const hours12 = (e) => {
    let content = e.innerHTML;
    let date = moment.parseZone(e.dateTime);
    e.innerHTML = content.replace(date.format('HH:mm'), date.format('hh:mm A'));
}

const dateFormat = () => {
    document.querySelectorAll('time[datetime]').forEach(e => {
        if (dateFormatConfiguration.relativeDates) {
            relativeDates(e);
        } else if (dateFormatConfiguration.adjustedDates) {
            adjustedDates(e);
        } else if (dateFormatConfiguration.hour12Dates) {
            hours12(e);
        }

        e.removeAttribute('dateTime');
    });
}

window.onload = () => {
    moment.locale(context.i18n.language);
    dateFormat();
}

document.body.addEventListener('freshrss:load-more', dateFormat);
