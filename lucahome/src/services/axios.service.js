"use strict"

import axios from "nextcloud-axios";

var areaList = [
    {
        id: 1,
        filter: "Sleeping Room",
        name: "Sleeping Room"
    },
    {
        id: 2,
        filter: "Living Room",
        name: "Living Room"
    },
    {
        id: 3,
        filter: "Working Room",
        name: "Working Room"
    },
    {
        id: 4,
        filter: "Kitchen",
        name: "Kitchen"
    }
];

var wirelessSocketList = [
    {
        id: 0,
        icon: require("@/assets/img/wireless_socket/light_on.png"),
        name: "Light Sleeping",
        area: "Sleeping Room",
        code: "11010A",
        state: false,
        description: ""
    },
    {
        id: 1,
        icon: require("@/assets/img/wireless_socket/sound_on.png"),
        name: "Sound TV",
        area: "Living Room",
        code: "11010B",
        state: false,
        description: ""
    },
    {
        id: 2,
        icon: require("@/assets/img/wireless_socket/raspberry_on.png"),
        name: "Raspberry Pi MediaCenter",
        area: "Living Room",
        code: "11010C",
        state: false,
        description: ""
    },
    {
        id: 3,
        icon: require("@/assets/img/wireless_socket/light_on.png"),
        name: "Light Couch",
        area: "Living Room",
        code: "11010D",
        state: true,
        description: ""
    },
    {
        id: 4,
        icon: require("@/assets/img/wireless_socket/storage_off.png"),
        name: "Backup Drive",
        area: "Working Room",
        code: "11010E",
        state: false,
        description: ""
    },
    {
        id: 5,
        icon: require("@/assets/img/wireless_socket/mediamirror_off.png"),
        name: "Media Mirror Kitchen",
        area: "Kitchen",
        code: "11011A",
        state: true,
        description: ""
    },
    {
        id: 6,
        icon: require("@/assets/img/wireless_socket/light_off.png"),
        name: "Light Ceiling",
        area: "Living Room",
        code: "11000A",
        state: false,
        description: ""
    }
];

export default {
    get(url) {
        switch(url){
            case "area":
                return Promise.resolve(areaList)
            case "wireless_socket":
                return Promise.resolve(wirelessSocketList)
            default:
                return Promise.resolve([])
        }

        /*
        return axios.get(OC.linkToOCS("apps/lucahome/api/v1/", 2) + url)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error))
        */
    },
    put(url, data) {
        return axios.put(OC.linkToOCS("apps/lucahome/api/v1/", 2) + url, data)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error))
    },
    post(url, data) {
        return axios.post(OC.linkToOCS("apps/lucahome/api/v1/", 2) + url, data)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error))
    },
    delete(url, data) {
        return axios.delete(OC.linkToOCS("apps/lucahome/api/v1/", 2) + url, data)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error))
    }
}