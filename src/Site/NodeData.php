<?php

namespace Eidosmedia\Cobalt\Site;

use Eidosmedia\Cobalt\Commons\Entity;

class NodeData extends Entity {

    private $docs = [];

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getId() {
        return $this->data['id'];
    }

    public function getParentId() {
        return $this->data['parentId'];
    }

    public function getName() {
        return $this->data['name'];
    }

    public function getTitle() {
        return $this->data['title'];
    }

    public function getSummary() {
        if (isset($this->data['summary'])) {
            return $this->data['summary'];
        } else {
            return null;
        }
    }

    public function getDescription() {
        if (isset($this->data['description'])) {
            return $this->data['description'];
        } else {
            return null;
        }
    }

    public function getKind() {
        return $this->data['sys']['kind'];
    }

    public function getBaseType() {
        return $this->data['sys']['baseType'];
    }

    public function getType() {
        return $this->data['sys']['type'];
    }

    public function getCreationTime() {
        return new \DateTime($this->data['sys']['creationTime']);
    }

    public function getCreatedBy($byId = false) {
        return $this->data['sys']['createdBy'][$byId ? 'userId' : 'userName'];
    }

    public function getUpdateTime() {
        return new \DateTime($this->data['sys']['updateTime']);
    }

    public function getUpdatedBy($byId = false) {
        return $this->data['sys']['updatedBy'][$byId ? 'userId' : 'userName'];
    }

    public function getAuthors() {
        if (isset($this->data['authors'])) {
            return $this->data['authors'];
        } else {
            return null;
        }
    }

    public function getPictureId() {
        if (isset($this->data['picture'])) {
            return $this->data['picture'];
        } else {
            return null;
        }
    }

    public function getSectionPath() {
        return $this->data['pubInfo']['sectionPath'];
    }

    public function getCanonical() {
        if (isset($this->data['pubInfo']['canonical'])) {
            return $this->data['pubInfo']['canonical'];
        } else {
            return null;
        }
    }

    public function getContent() {
        if (isset($this->data['files']) && isset($this->data['files']['content']) && isset($this->data['files']['content']['data'])) {
            return $this->data['files']['content']['data'];
        } else {
            return null;
        }
    }

    public function getContentDocument() {
        if (isset($this->docs['content'])) {
            return $this->docs['content'];
        }
        $content = $this->getContent();
        if ($content == null) {
            return null;
        }
        $this->docs['content'] = \DOMDocument::loadXML($content);
        return $this->docs['content'];
    }

    public function transformContentDocument($xsl) {
        $contentDocument = $this->getContentDocument();
        if ($contentDocument == null) {
            return null;
        }
        if (!($xsl instanceof \DOMDocument)) {
            $xsl = \DOMDocument::loadXML($xsl);
        }
        $processor = new \XSLTProcessor();
        $processor->importStyleSheet($xsl);
        return $processor->transformToXml($contentDocument);
    }

    public function getTemplateName() {
        if (isset($this->data['attributes']) && isset($this->data['attributes']['template'])) {
            return $this->data['attributes']['template'];
        }
        return null;
    }

    private function getTemplate() {
        $templateName = $this->getTemplateName();
        if ($templateName == null) {
            return null;
        }
        return $this->data['files']['templates']['data'][$templateName];
    }

    public function getZonesNames() {
        $template = $this->getTemplate();
        if ($template == null) {
            return [];
        }
        return array_keys($template['zones']);
    }

    public function getZoneIds($zoneName) {
        $template = $this->getTemplate();
        if ($template == null) {
            return null;
        }
        $zone = $template['zones'][$zoneName];
        $sequences = $zone['sequences'];
        $maxItems = 0;
        foreach ($sequences as $sequence) {
            $maxItems += $sequence['maxItems'];
        }
        $links = $this->data['links']['pagelink'][$zoneName];
        return array_map(function($link) {
            return $link['targetId'];
        } , array_slice($links, 0, $maxItems));
    }

}