<?php

namespace CWS\Encute\Tests\Unit;

use CWS\Encute\DependencyGrapher;

class DependencyGrapherTest extends \WP_UnitTestCase {

	public function test_it_can_be_instantiated() {
		$grapher = new DependencyGrapher(wp_scripts());
		$this->assertInstanceOf(DependencyGrapher::class, $grapher );
	}

	public function test_children_are_found() {
		$dependencies = new \WP_Dependencies;
		$dependencies->add('encute-parent', '#parent', []);
		$dependencies->add('encute-child1', '#child1', ['encute-parent']);
		$dependencies->add('encute-child2', '#child2', ['encute-parent']);
		$grapher = new DependencyGrapher($dependencies);
		$this->assertEquals(['encute-child1', 'encute-child2'], $grapher->childNodes('encute-parent'));
	}

	public function test_no_children_are_found_when_there_are_not_any() {
		$dependencies = new \WP_Dependencies;
		$dependencies->add('encute-parent', '#parent', []);
		$dependencies->add('encute-sibling', '#sibling1', []);
		$grapher = new DependencyGrapher($dependencies);
		$this->assertEquals([], $grapher->childNodes('encute-parent'));
	}

	public function test_parents_are_found() {
		$dependencies = new \WP_Dependencies;
		$dependencies->add('encute-father', '#father', []);
		$dependencies->add('encute-mother', '#mother', []);
		$dependencies->add('encute-child', '#child', ['encute-father', 'encute-mother']);
		$grapher = new DependencyGrapher($dependencies);
		$this->assertEquals(['encute-father', 'encute-mother'], $grapher->parentNodes('encute-child'));
	}

	public function test_all_adjacent_nodes_are_found() {
		$dependencies = new \WP_Dependencies;
		$dependencies->add('encute-father', '#father', []);
		$dependencies->add('encute-mother', '#mother', []);
		$dependencies->add('encute-child', '#child', ['encute-father', 'encute-mother']);
		$dependencies->add('encute-grandchild', '#grandchild', ['encute-child']);
		$grapher = new DependencyGrapher($dependencies);
		$this->assertEquals(['encute-father', 'encute-mother', 'encute-grandchild'], $grapher->adjacentNodes('encute-child'));
	}

	public function test_all_related_nodes_are_found() {
		$dependencies = new \WP_Dependencies;
		$dependencies->add('encute-adam', '#adam', []);
		$dependencies->add('encute-father', '#father', ['encute-adam']);
		$dependencies->add('encute-mother', '#mother', []);
		$dependencies->add('encute-child', '#child', ['encute-father', 'encute-mother']);
		$dependencies->add('encute-rando1', '#rando1', []);
		$dependencies->add('encute-grandchild1', '#grandchild1', ['encute-child', 'encute-rando1']);
		$dependencies->add('encute-sibling', '#sibling', ['encute-father', 'encute-mother']);
		$dependencies->add('encute-rando2', '#rando2', []);
		$dependencies->add('encute-grandchild2', '#grandchild2', ['encute-sibling', 'encute-rando2']);
		$grapher = new DependencyGrapher($dependencies);
		$expected = [
			'encute-adam',
			'encute-child',
			'encute-father',
			'encute-mother',
			'encute-rando1',
			'encute-grandchild1',
			'encute-sibling',
			'encute-rando2',
			'encute-grandchild2',
		];
		sort($expected);
		foreach ($expected as $entryNode) {
			$actual = $grapher->allRelatedNodes([$entryNode]);
			sort($actual);
			$this->assertEquals($expected, $actual);
		}
	}
}
