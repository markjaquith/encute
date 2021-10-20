<script>
	export let type = 'Script'
	export let handle = ''
	export let methods = {}
	const scriptMethods = ['async', 'module', 'noModule']
	$: methodsUsed = Object.keys(methods).filter(k => methods[k])
	$: methodCalls = (methods => {
		const calls = []

		if (methods.includes('remove')) {
			return ['remove']
		}

		methods.forEach(method => {
			if (type === 'Script' || !scriptMethods.includes(method)) {
				calls.push(method)
			}
		})

		return calls
	})(methodsUsed)

	function makeMethodCall(method) {
		return `->${method}()`
	}
</script>

<div>{type}::get('{handle}'){methodCalls.map(makeMethodCall).join('')};</div>
