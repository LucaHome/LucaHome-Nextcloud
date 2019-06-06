'use strict'

import axios from 'axios'
import requestMock from './request.mock'

const useMockData = false
const baseUrl = '/nextcloud/index.php/apps/wirelesscontrol/'

export default {
	get(url) {
		if (useMockData) {
			return requestMock.getMock(url);
		}

		return axios(baseUrl + url)
			.then((response) => Promise.resolve(JSON.stringify(response.data)))
			.catch((error) => Promise.reject(error));
	},
	post(url, data) {
		if (useMockData) {
			return requestMock.postDeleteMock(url, data);
		}

		delete data['id'];

		return axios({
			method: 'post',
			url: baseUrl + url,
			contentType: 'application/json',
			data: data
		})
			.then((response) => Promise.resolve(JSON.stringify(response.data)))
			.catch((error) => Promise.reject(error));
	},
	put(url, data) {
		if (useMockData) {
			return requestMock.putMock(url, data);
		}

		return axios({
			method: 'put',
			url: baseUrl + url + '/' + data.id,
			contentType: 'application/json',
			data: data
		})
			.then((response) => Promise.resolve(JSON.stringify(response.data)))
			.catch((error) => Promise.reject(error));
	},
	delete(url, id) {
		if (useMockData) {
			return requestMock.postDeleteMock(url, id);
		}

		return axios({
			method: 'delete',
			url: baseUrl + url + '/' + id
		})
			.then((response) => Promise.resolve(JSON.stringify(response.data)))
			.catch((error) => Promise.reject(error));
	}
}
