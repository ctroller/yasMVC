<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Paginator
 */

namespace Zend\Paginator\ScrollingStyle;

use Zend\Paginator\Paginator;

/**
 * A Google-like scrolling style.  Incrementally expands the range to about
 * twice the given page range, then behaves like a slider.  See the example
 * link.
 *
 * @link       http://www.google.com/search?q=Zend+Framework
 * @category   Zend
 * @package    Zend_Paginator
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Elastic extends Sliding
{
    /**
     * Returns an array of "local" pages given a page number and range.
     *
     * @param  Paginator $paginator
     * @param  integer $pageRange Unused
     * @return array
     */
    public function getPages(Paginator $paginator, $pageRange = null)
    {
        $pageRange  = $paginator->getPageRange();
        $pageNumber = $paginator->getCurrentPageNumber();

        $originalPageRange = $pageRange;
        $pageRange         = $pageRange * 2 - 1;

        if ($originalPageRange + $pageNumber - 1 < $pageRange) {
            $pageRange = $originalPageRange + $pageNumber - 1;
        } else if ($originalPageRange + $pageNumber - 1 > count($paginator)) {
            $pageRange = $originalPageRange + count($paginator) - $pageNumber;
        }

        return parent::getPages($paginator, $pageRange);
    }
}