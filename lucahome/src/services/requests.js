'use strict'

import Axios from 'axios'
import requestMock from './request.mock'
import { generateUrl } from 'nextcloud-server/dist/router'

const useMockData = false
const baseUrl = '/apps/lucahome/'

export default {
	get(url) {
		if (useMockData) {
			return requestMock.getMock(url)
		}

		return Axios.get(generateUrl(baseUrl + url, ''))
			.then((response) => Promise.resolve(response))
			.catch((error) => Promise.reject(error))
	},
	put(url, data) {
		if (useMockData) {
			return requestMock.putMock(url, data)
		}

		return Axios.put(generateUrl(baseUrl + url, ''), data)
			.then((response) => Promise.resolve(response))
			.catch((error) => Promise.reject(error))
	},
	post(url, data) {
		if (useMockData) {
			return requestMock.postDeleteMock(url, data)
		}

		return Axios.post(generateUrl(baseUrl + url, ''), data)
			.then((response) => Promise.resolve(response))
			.catch((error) => Promise.reject(error))
	},
	delete(url, data) {
		if (useMockData) {
			return requestMock.postDeleteMock(url, data)
		}

		return Axios.delete(generateUrl(baseUrl + url, ''), data)
			.then((response) => Promise.resolve(response))
			.catch((error) => Promise.reject(error))
	}
}
