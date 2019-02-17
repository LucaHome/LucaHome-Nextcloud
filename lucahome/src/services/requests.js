"use strict"

import requestMock from "./request.mock";
const useMockData = true;

import Axios from "axios";
Axios.defaults.headers.common.requesttoken = OC.requestToken;

export default {
    get(url) {
        if (useMockData) {
            return requestMock.getMock(url);
        }

        return Axios.get(url)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error));
    },
    put(url, data) {
        if (useMockData) {
            return requestMock.putMock(url, data);
        }

        return Axios.put(url, data)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error));
    },
    post(url, data) {
        if (useMockData) {
            return requestMock.postDeleteMock(url, data);
        }

        return Axios.post(url, data)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error));
    },
    delete(url, data) {
        if (useMockData) {
            return requestMock.postDeleteMock(url, data);
        }

        return Axios.delete(url, data)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error));
    }
}