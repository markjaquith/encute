<script>
	import ManipulationCodeRepresentation from './ManipulationCodeRepresentation.svelte'
	export let debug = false
	export let manipulations = []
	$: console.log({ manipulations })
	$: validManipulations = manipulations.filter(m => m.handle.length && Object.keys(m.methods).filter(k => m.methods[k]).length)
</script>

<pre>
&lt;?php
use CWS\Encute\&lbrace;Plugin, Script, Style&rbrace;;

add_action(Plugin::class, function(Plugin $plugin) &lbrace;{#if debug}<div>$plugin->debug();</div>{/if}{#each validManipulations as manipulation}
		<div><ManipulationCodeRepresentation {...manipulation} /></div>{/each}&rbrace;);
</pre>

<style>
	div {
		margin-left: 4rem;
	}
</style>
