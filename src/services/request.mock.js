var areaList = [{
		id: 1,
		filter: 'Sleeping Room',
		name: 'Sleeping Room'
	},
	{
		id: 2,
		filter: 'Living Room',
		name: 'Living Room'
	},
	{
		id: 3,
		filter: 'Working Room',
		name: 'Working Room'
	},
	{
		id: 4,
		filter: 'Kitchen',
		name: 'Kitchen'
	}
]

var wirelessSocketList = [{
		id: 0,
		icon: 'fas fa-lightbulb',
		name: 'Light Sleeping',
		area: 'Sleeping Room',
		code: '11010A',
		state: false,
		description: ''
	},
	{
		id: 1,
		icon: 'fas fa-headphones',
		name: 'Sound TV',
		area: 'Living Room',
		code: '11010B',
		state: false,
		description: ''
	},
	{
		id: 2,
		icon: 'fab fa-raspberry-pi',
		name: 'Raspberry Pi MediaCenter',
		area: 'Living Room',
		code: '11010C',
		state: false,
		description: ''
	},
	{
		id: 3,
		icon: 'fas fa-lightbulb',
		name: 'Light Couch',
		area: 'Living Room',
		code: '11010D',
		state: true,
		description: ''
	},
	{
		id: 4,
		icon: 'fas fa-hdd',
		name: 'Backup Drive',
		area: 'Working Room',
		code: '11010E',
		state: false,
		description: ''
	},
	{
		id: 5,
		icon: 'fas fa-tablet-alt',
		name: 'Media Mirror Kitchen',
		area: 'Kitchen',
		code: '11011A',
		state: true,
		description: ''
	},
	{
		id: 6,
		icon: 'fas fa-lightbulb',
		name: 'Light Ceiling',
		area: 'Living Room',
		code: '11000A',
		state: false,
		description: ''
	}
]

var getMock = (url) => {
	if (url.includes('area')) {
		return Promise.resolve({
			message: null,
			data: areaList,
			status: 'success'
		})
	} else if (url.includes('wireless_socket')) {
		return Promise.resolve({
			message: null,
			data: wirelessSocketList,
			status: 'success'
		})
	} else {
		return Promise.resolve({
			message: 'Invalid url',
			data: null,
			status: 'error'
		})
	}
}

var putMock = (url, data) => {
	if (url.includes('area')) {
		return Promise.resolve({
			message: null,
			data: data.id + 1,
			status: 'success'
		})
	} else if (url.includes('wireless_socket')) {
		return Promise.resolve({
			message: null,
			data: data.id + 1,
			status: 'success'
		})
	} else {
		return Promise.resolve({
			message: 'Invalid url',
			data: null,
			status: 'error'
		})
	}
}

// eslint-disable-next-line
var postDeleteMock = (url, data) => {
	if (url.includes('area')) {
		return Promise.resolve({
			message: null,
			data: 0,
			status: 'success'
		})
	} else if (url.includes('wireless_socket')) {
		return Promise.resolve({
			message: null,
			data: 0,
			status: 'success'
		})
	} else {
		return Promise.resolve({
			message: 'Invalid url',
			data: null,
			status: 'error'
		})
	}
}

export default {
	getMock,
	putMock,
	postDeleteMock
}
