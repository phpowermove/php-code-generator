<?php
namespace gossi\codegen\model\parts;

use gossi\docblock\tags\ParamTag;

trait ParamDocblockGeneratorTrait {

	/**
	 * Generates docblock for params
	 */
	protected function generateParamDocblock() {
		$docblock = $this->getDocblock();
		$tags = $docblock->getTags('param');
		foreach ($this->parameters as $param) {
			$ptag = $param->getDocblockTag();

			$tag = $tags->find($ptag, function (ParamTag $tag, ParamTag $ptag) {
				return $tag->getVariable() == $ptag->getVariable();
			});

			// try to update existing docblock first
			if ($tag !== null) {
				$tag->setDescription($ptag->getDescription());
				$tag->setType($ptag->getType());
			}

			// ... append if it doesn't exist
			else {
				$docblock->appendTag($ptag);
			}
		}
	}
}