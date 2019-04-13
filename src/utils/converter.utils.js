'use strict'

export default {
    convertAreaLoadResponse(jsonResponse) {
        return JSON.parse(jsonResponse, (key, value) => {
            if (key === 'id' || key === 'deletable') {
                return Number(value);
            }

            return value;
        });
    },
    convertNumberResponse(jsonResponse) {
        return JSON.parse(jsonResponse, (key, value) => {
            if (key === 'data' && !isNaN(value)) {
                return Number(value);
            }

            return value;
        });
    },
    convertPeriodicTaskLoadResponse(jsonResponse) {
        return JSON.parse(jsonResponse, (key, value) => {
            if (key === 'id' || key === 'wirelessSocketId' || key === 'wirelessSocketState' || key === 'weekday'
                || key === 'hour' || key === 'minute' || key === 'periodic' || key === 'active') {
                return Number(value);
            }

            return value;
        });
    },
    convertWirelessSocketLoadResponse(jsonResponse) {
        return JSON.parse(jsonResponse, (key, value) => {
            if (key === 'id' || key === 'state' || key === 'deletable') {
                return Number(value);
            }

            return value;
        });
    }
}
