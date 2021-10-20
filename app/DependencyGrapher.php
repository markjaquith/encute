<?php

namespace CWS\Encute;

class DependencyGrapher {
	protected \WP_Dependencies $dependencies;

	public function __construct(\WP_Dependencies $dependencies) {
		$this->dependencies = $dependencies;
	}

	public static function forStyles() {
		return new static(app()->make(\WP_Styles::class));
	}

	public static function forScripts() {
		return new static(app()->make(\WP_Scripts::class));
	}

	public function allRelatedNodes(array $inputs): array {
		$knownNodes = [];
		$unknownNodes = $inputs;

		while(count($unknownNodes)) {
			$node = array_shift($unknownNodes);

			if (!isset($knownNodes[$node])) {
				$relatedNodes = $this->adjacentNodes($node);
				$knownNodes[$node] = $relatedNodes;
				$unknownNodes = array_merge($unknownNodes, $relatedNodes);
			}
		}

		$uniqueRelatedNodes = [];

		foreach ($knownNodes as $nodeDependencies) {
			foreach ($nodeDependencies as $node) {
				$uniqueRelatedNodes[$node] = true;
			}
		}

		foreach ($inputs as $node) {
			$uniqueRelatedNodes[$node] = true;
		}

		return array_keys($uniqueRelatedNodes);
	}

	public function childNodes(string $handle): array {
		$children = array_filter($this->dependencies->registered, function ($dependency) use ($handle) {
			return $dependency->deps && in_array($handle, $dependency->deps);
		});

		return array_values(array_map(fn ($child) => $child->handle, $children));
	}

	public function parentNodes(string $handle): array {
		return $this->dependencies->registered[$handle]->deps ?? [];
	}

	public function adjacentNodes(string $handle): array {
		return array_values(array_unique([
			...$this->parentNodes($handle),
			...$this->childNodes($handle),
		]));
	}
}
