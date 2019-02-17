module.exports = {
	root: true,
	env: {
		browser: true,
		es6: true,
		node: true,
		jest: true
	},
	globals: {
		oc_config: true,
		oca_contacts: true,
		n: true,
		t: true,
		OC: true,
		OCA: true,
		Vue: true,
		VueRouter: true
	},
	parserOptions: {
		parser: 'babel-eslint',
		ecmaVersion: 6,
		sourceType: "module",
		allowImportExportEverywhere: true
	},
	extends: [
		'plugin:vue/essential',
		'plugin:vue/recommended'
	],
	settings: {
		'import/resolver': {
			webpack: {
				config: 'webpack.common.js'
			},
			node: {
				paths: ['src'],
				extensions: ['.js', '.vue']
			}
		}
	},
	plugins: ['vue', 'node'],
	rules: {}
}
