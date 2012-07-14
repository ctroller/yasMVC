<?php

class Navigation
{

    private $entries = array();
    private $entriesById = array();

    public function addChild(Navigation_Entry &$entry)
    {
        $this->entries[] = $entry;
        $this->entriesById[$entry->navigation_entry_id] = $entry;
    }

    public function addEntryChild($parent_id, Navigation_Entry &$entry)
    {
        $this->entriesById[$parent_id]->addChild($entry);
    }

    public function getEntries()
    {
        return $this->entries;
    }

}

const NAVIGATION_TYPE_PAGE = 1;
const NAVIAGTION_TYPE_EXTERNAL = 2;

class Navigation_Entry
{

    private $childs = array();

    public function hasChilds()
    {
        return count($this->childs) > 0;
    }

    public function addChild(Navigation_Entry $child)
    {
        $this->childs[] = $child;
    }

    public function getChilds()
    {
        return $this->childs;
    }
    
    public function getTarget() {
        switch( $this->navigation_type ) {
            case NAVIGATION_TYPE_PAGE:
                return SCRIPT_PATH . $this->navigation_target . '/';
                break;
        }
    }

}

$db = yasCMS\Registry::getInstance()->get('db');
$sql = "SELECT e.*, l.* FROM navigation_entry AS e LEFT JOIN navigation AS n ON n.navigation_id = e.navigation_id LEFT JOIN navigation_entry_lang AS l ON l.navigation_entry_id = e.navigation_entry_id WHERE navigation_identifier = 'main' AND language_code = :lang AND visible = 1 ORDER BY sorting DESC, e.navigation_entry_id ASC";
$ident = 'main';
$stmt = $db->prepare($sql);
$stmt->bindParam(':lang', yasCMS\Registry::getInstance()->get('lang'), PDO::PARAM_STR);
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Navigation_Entry');
$stmt->execute();
$navEntries = $stmt->fetchAll();
$navigation = new Navigation();
$skipped = array();
foreach ($navEntries as $navEntry) {
    if ($navEntry->parent_id === null)
        $navigation->addChild($navEntry);
    else
        $skipped[] = $navEntry;
}

foreach ($skipped as $skip_entry) {
    $navigation->addEntryChild($skip_entry->parent_id, $skip_entry);
}

return $navigation;