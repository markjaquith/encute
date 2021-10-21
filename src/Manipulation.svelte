<script>
	import { createEventDispatcher } from 'svelte'
	const dispatch = createEventDispatcher()

	export let type = 'Script'
	export let handle = ''
	export let methods = {
		remove: false,
		footer: false,
		defer: false,
		module: false,
		noModule: false,
		async: false,
	}
	let { remove, footer, defer, module, noModule, async } = methods
	$: methods = {
		remove,
		footer,
		defer,
		module,
		noModule,
		async,
	}
</script>

<div>
	<!-- svelte-ignore a11y-no-onchange -->
	<select bind:value={type}>
		<option value="Script">Script</option>
		<option value="Style">Style</option>
	</select>

	<input type="text" bind:value={handle} />

	<a href="#remove" on:click|preventDefault={() => dispatch('remove')}>&times;</a>
</div>

<div class="options">
	<ul class="all">
		<li><label><input type="checkbox" value={true} bind:checked={remove} /> Remove</label></li>
		<li><label><input type="checkbox" value={true} disabled={remove} bind:checked={footer} /> Move to footer</label></li>
		<li><label><input type="checkbox" value={true} disabled={remove} bind:checked={defer} /> Defer loading</label></li>
	</ul>

	{#if type === 'Script'}
		<ul class="scripts">
			<li><label><input type="checkbox" value={true} disabled={remove} bind:checked={async} /> Load async</label></li>
			<li><label><input type="checkbox" value={true} disabled={remove || noModule} bind:checked={module} /> Load as module</label></li>
			<li><label><input type="checkbox" value={true} disabled={remove || module} bind:checked={noModule} /> Load as nomodule</label></li>
		</ul>
	{/if}
</div>

<style>
	div {
		display: flex;
	}

	div.options {
		justify-content: space-between;
	}

	ul {
		margin-bottom: 0;
	}

	a[href="#remove"] {
		color: #555;
		margin-left: auto;
		top: -0.5rem;
		position: relative;
		text-decoration: none;
		font-size: 150%;
	}

	a[href="#remove"]:hover {
		color: #cc1818;
	}
</style>
