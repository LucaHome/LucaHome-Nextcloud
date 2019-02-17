"use strict"

import requestMock from "./request.mock";
const useMockData = false;

import Axios from "axios";
//Axios.defaults.headers.common.requesttoken = OC.requestToken;

const baseUrl = "http://localhost:8080/nextcloud/apps/lucahome/api/v1/";

export default {
    get(url) {
        if (useMockData) {
            return requestMock.getMock(url);
        }

        return Axios.get(baseUrl + url)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error));
    },
    put(url, data) {
        if (useMockData) {
            return requestMock.putMock(url, data);
        }

        return Axios.put(baseUrl + url, data)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error));
    },
    post(url, data) {
        if (useMockData) {
            return requestMock.postDeleteMock(url, data);
        }

        return Axios.post(baseUrl + url, data)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error));
    },
    delete(url, data) {
        if (useMockData) {
            return requestMock.postDeleteMock(url, data);
        }

        return Axios.delete(baseUrl + url, data)
            .then((response) => Promise.resolve(response))
            .catch((error) => Promise.reject(error));
    }
}