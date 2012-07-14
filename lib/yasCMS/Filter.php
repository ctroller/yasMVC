<?php

namespace yasCMS;

final class Filter
{

    private function __construct()
    {
        
    }

    public static function HTML($html)
    {
        # Get array representations of the safe tags and attributes:
        # Parse the HTML into a document object:
        $dom = new \DOMDocument();
        $dom->loadHTML('<div>' . $html . '</div>');

        # Loop through all of the nodes:
        $stack = new \SplStack();
        $stack->push($dom->documentElement);

        while ($stack->count() > 0) {
            # Get the next element for processing:
            $element = $stack->pop();

            # Add all the element's child nodes to the stack:
            foreach ($element->childNodes as $child) {
                if ($child instanceof DOMElement) {
                    $stack->push($child);
                }
            }

            # And now, we do the filtering:
            # It's not a safe tag; unwrap it:
            while ($element->hasChildNodes()) {
                $element->parentNode->insertBefore($element->firstChild, $element);
            }

            # Finally, delete the offending element:
            $element->parentNode->removeChild($element);
        }

        # Finally, return the safe HTML, minus the DOCTYPE, <html> and <body>:
        $html = $dom->saveHTML();
        $start = strpos($html, '<div>');
        $end = strrpos($html, '</div>');

        return substr($html, $start + 5, $end - $start - 5);
    }

}
