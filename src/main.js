import App from './App.svelte'

const target = document.getElementById('encute-code-generation')
target.innerHTML = ''

const app = new App({ target })

export default app
