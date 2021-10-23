<?php defined('WPINC') or die ?>
<style>
.encute {
	box-sizing: border-box;
}

.encute-card {
	padding: 0.5rem 2rem 1rem 2rem;
	border: 1px solid #555;
	background: #fff;
	margin-bottom: 2rem;
}

.encute-pre {
	background: #f5f5f5;
	padding: 1rem;
	border-radius: 2px;
	display: inline-block;
}

.encute-pre span {
	color: #aaa;
}
</style>

<div class="wrap encute">
	<h1><?php echo esc_html($title) ?></h1>
	<div class="encute-card">
		<h2 class="title">Getting Started</h2>
		<p><b>Encute</b> allows you to manipulate the enqueued scripts and styles on the front of your site.</p>
		<p>The first thing you'll need is a file at <code>wp-content/mu-plugins/encute.php</code> with this wrapper:</p>
<pre class="encute-pre">
&lt;?php
use CWS\Encute\{Plugin, Script, Style};

add_action(Plugin::class, function(Plugin $plugin) {
  <span>// Optional debugging — inserts HTML comments around scripts and styles.</span>
  <span>// $plugin->debug();</span>

  <b>// YOUR SCRIPT AND STYLE MANIPULATIONS GO HERE.</b>
});
</pre>

		<p>Use the tool below to help you generate code.</p>
	</div>

	<div class="encute-card">
		<h2 class="title">Code Generation Tool</h2>
		<div id="encute-code-generation">Loading&hellip;</div>
</div>
