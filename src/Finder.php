<?php

namespace packages\PHPHtmlParser;

use packages\PHPHtmlParser\Dom\AbstractNode;
use packages\PHPHtmlParser\Dom\InnerNode;

class Finder
{
    private $id;

    /**
     * Finder constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     *
     * Find node in tree by id
     *
     * @param AbstractNode $node
     * @return bool|AbstractNode
     */
    public function find(AbstractNode $node)
    {
        if (!$node->id() && $node instanceof InnerNode) {
            return $this->find($node->firstChild());
        }

        if ($node->id() == $this->id) {
            return $node;
        }

        if ($node->hasNextSibling()) {
            $nextSibling = $node->nextSibling();
            if ($nextSibling->id() == $this->id) {
                return $nextSibling;
            }
            if ($nextSibling->id() > $this->id) {
                return $this->find($node->firstChild());
            }
            if ($nextSibling->id() < $this->id) {
                return $this->find($nextSibling);
            }
        } else if (!$node->isTextNode()) {
            return $this->find($node->firstChild());
        }

        return false;
    }
}
