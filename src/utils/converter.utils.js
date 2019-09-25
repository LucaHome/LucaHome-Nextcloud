'use strict'

export const convertAreaLoadResponse = (jsonResponse) => JSON.parse(jsonResponse,
    (key, value) => (key === 'id' || key === 'deletable')
        ? Number(value)
        : value);

export const convertNumberResponse = (jsonResponse) => JSON.parse(jsonResponse,
    (key, value) => (key === 'data' && !isNaN(value))
        ? Number(value)
        : value);

export const convertPeriodicTaskLoadResponse = (jsonResponse) => JSON.parse(jsonResponse,
    (key, value) => (key === 'id' || key === 'wirelessSocketId' || key === 'wirelessSocketState' || key === 'weekday' || key === 'hour' || key === 'minute' || key === 'periodic' || key === 'active')
        ? Number(value)
        : value);

export const convertWirelessSocketLoadResponse = (jsonResponse) => JSON.parse(jsonResponse,
    (key, value) => (key === 'id' || key === 'state' || key === 'deletable')
        ? Number(value)
        : value);
