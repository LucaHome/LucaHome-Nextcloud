"use strict"

// import axios from "nextcloud-axios";
import axios from "axios";
import axiosServiceMock from "./axios.service.mock";

const usingMockData = false;
const apiUrl = "apps/lucahome/api/v1/";

export default {
    get(url) {
        if (usingMockData) {
            return axiosServiceMock.getMock(url);
        } else {
            return axios.get(apiUrl + url)
                .then((response) => Promise.resolve(response))
                .catch((error) => Promise.reject(error))
        }
    },
    put(url, data) {
        if (usingMockData) {
            return axiosServiceMock.putMock(url, data);
        } else {
            return axios.put(apiUrl + url, data)
                .then((response) => Promise.resolve(response))
                .catch((error) => Promise.reject(error))
        }
    },
    post(url, data) {
        if (usingMockData) {
            return axiosServiceMock.postDeleteMock(url, data);
        } else {
            return axios.post(apiUrl + url, data)
                .then((response) => Promise.resolve(response))
                .catch((error) => Promise.reject(error))
        }
    },
    delete(url, data) {
        if (usingMockData) {
            return axiosServiceMock.postDeleteMock(url, data);
        } else {
            return axios.delete(apiUrl + url, data)
                .then((response) => Promise.resolve(response))
                .catch((error) => Promise.reject(error))
        }
    }
}