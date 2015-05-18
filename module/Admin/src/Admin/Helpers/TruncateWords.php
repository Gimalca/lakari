<?php
/**
 * helper
 * 
 * @author
 * @version 
 */
namespace helper;

use Zend\View\Helper\AbstractHelper;

/**
 * View Helper
 */
class TruncateWords extends AbstractHelper
{

    public function __invoke($words, $limit, $append = ' &hellip;') {
        // Add 1 to the specified limit becuase arrays start at 0
        $limit = $limit+1;
        // Store each individual word as an array element
        // Up to the limit
        $words = explode(' ', $words, $limit);
        // Shorten the array by 1 because that final element will be the sum of all the words after the limit
        array_pop($words);
        // Implode the array for output, and append an ellipse
        $words = implode(' ', $words) . $append;
        // Return the result
        return $words;
    }

}
