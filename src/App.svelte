<script>
import Manipulation from './Manipulation.svelte'
import Code from './Code.svelte'

let debug = false
let hideUi = false
let manipulations = [
	{
		type: 'Script',
		handle: 'script-handle',
		methods: {
			defer: true,
			footer: true,
		}
	}
]

function addManipulation() {
	manipulations = [...manipulations, {
		type: 'Script',
		handle: '',
	}]
}
</script>

<main>
	<section class="manipulations">
		<div class="options">
			<label><input type="checkbox" value={true} bind:checked={debug} /> Show debug HTML comments around scripts and styles</label>
		</div>
		<div class="options">
			<label><input type="checkbox" value={true} bind:checked={hideUi} /> Hide WordPress UI (this screen)</label>
		</div>
		{#if !manipulations.length}
			<div class="spacer"></div>
		{/if}
		{#each manipulations as manipulation, i}
			<div class="manipulation">
				<Manipulation
					bind:type={manipulation.type}
					bind:handle={manipulation.handle}
					bind:methods={manipulation.methods}
					on:remove={() => {
						manipulations.splice(manipulations.indexOf(manipulation), 1)
						manipulations = manipulations
					}}
				/>
			</div>
		{/each}

		<button class="button" on:click={addManipulation}>New Manipulation</button>
	</section>

	<section class="code">
		<Code {manipulations} {debug} {hideUi} />
	</section>
</main>

<style>
	main {
		display: flex;
		flex-direction: row;
		gap: 4rem;
	}

	.manipulation {
		padding: 1rem;
		margin: 0.5rem 0;
		border: 1px solid #ccc;
		border-radius: 2px;
	}

	.spacer {
		height: 1rem;
	}

	.options {
		margin: 0 0 0.5rem 0;
	}
</style>
