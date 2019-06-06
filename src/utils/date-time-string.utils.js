'use strict'

const weekdayArray = ["Error", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

export default {
    getTimeString = (periodicTask) => `${("0" + periodicTask.hour).slice(-2)}:${("0" + periodicTask.minute).slice(-2)}`,

    numberToWeekday= (number) => weekdayArray[number],

    weekdayArray
}