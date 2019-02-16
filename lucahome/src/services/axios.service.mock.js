var areaList = [{
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

var wirelessSocketList = [{
        id: 0,
        icon: "fas fa-lightbulb",
        name: "Light Sleeping",
        area: "Sleeping Room",
        code: "11010A",
        state: false,
        description: ""
    },
    {
        id: 1,
        icon: "fas fa-headphones",
        name: "Sound TV",
        area: "Living Room",
        code: "11010B",
        state: false,
        description: ""
    },
    {
        id: 2,
        icon: "fab fa-raspberry-pi",
        name: "Raspberry Pi MediaCenter",
        area: "Living Room",
        code: "11010C",
        state: false,
        description: ""
    },
    {
        id: 3,
        icon: "fas fa-lightbulb",
        name: "Light Couch",
        area: "Living Room",
        code: "11010D",
        state: true,
        description: ""
    },
    {
        id: 4,
        icon: "fas fa-hdd",
        name: "Backup Drive",
        area: "Working Room",
        code: "11010E",
        state: false,
        description: ""
    },
    {
        id: 5,
        icon: "fas fa-tablet-alt",
        name: "Media Mirror Kitchen",
        area: "Kitchen",
        code: "11011A",
        state: true,
        description: ""
    },
    {
        id: 6,
        icon: "fas fa-lightbulb",
        name: "Light Ceiling",
        area: "Living Room",
        code: "11000A",
        state: false,
        description: ""
    }
];

var getMock = (url) => {
    switch (url) {
        case "area":
            var jsonResponseArea = {
                error: null,
                response: areaList,
                status: "success"
            };
            return Promise.resolve(jsonResponseArea)

        case "wireless_socket":
            var jsonResponseWirelessSocket = {
                error: null,
                response: wirelessSocketList,
                status: "success"
            };
            return Promise.resolve(jsonResponseWirelessSocket)

        default:
            var jsonResponseDefault = {
                error: "Invalid url",
                response: null,
                status: "error"
            };
            return Promise.resolve(jsonResponseDefault)
    }
};

var putMock = (url, data) => {
    switch (url) {
        case "area":
            var jsonResponseArea = {
                error: null,
                response: data.id + 1,
                status: "success"
            };
            return Promise.resolve(jsonResponseArea)

        case "wireless_socket":
            var jsonResponseWirelessSocket = {
                error: null,
                response: data.id + 1,
                status: "success"
            };
            return Promise.resolve(jsonResponseWirelessSocket)

        default:
            var jsonResponseDefault = {
                error: "Invalid url",
                response: null,
                status: "error"
            };
            return Promise.resolve(jsonResponseDefault)
    }
};

// eslint-disable-next-line
var postDeleteMock = (url, data) => {
    switch (url) {
        case "area":
            var jsonResponseArea = {
                error: null,
                response: 0,
                status: "success"
            };
            return Promise.resolve(jsonResponseArea)

        case "wireless_socket":
            var jsonResponseWirelessSocket = {
                error: null,
                response: 0,
                status: "success"
            };
            return Promise.resolve(jsonResponseWirelessSocket)

        default:
            var jsonResponseDefault = {
                error: "Invalid url",
                response: null,
                status: "error"
            };
            return Promise.resolve(jsonResponseDefault)
    }
};

export default {
    getMock,
    putMock,
    postDeleteMock
}