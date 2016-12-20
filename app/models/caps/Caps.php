<?php

namespace modl;

class Caps extends Model
{
    public $node;
    public $category;
    public $type;
    public $name;
    public $features;

    public $_struct = [
        'node'      => ['type' => 'string','size' => 128,'key' => true],
        'category'  => ['type' => 'string','size' => 16,'mandatory' => true],
        'type'      => ['type' => 'string','size' => 16,'mandatory' => true],
        'name'      => ['type' => 'string','size' => 128,'mandatory' => true],
        'features'  => ['type' => 'text','mandatory' => true],
    ];

    public function set($query, $node = false)
    {
        if(!$node)
            $this->node     = (string)$query->query->attributes()->node;
        else
            $this->node     = $node;

        if(isset($query->query)) {
            foreach($query->query->identity as $i) {
                if($i->attributes()) {
                    $this->category = (string)$i->attributes()->category;
                    $this->type     = (string)$i->attributes()->type;

                    if($i->attributes()->name) {
                        $this->name = (string)$i->attributes()->name;
                    } else {
                        $this->name = $this->node;
                    }
                }
            }

            $fet = [];
            foreach($query->query->feature as $f) {
                array_push($fet, (string)$f->attributes()->var);
            }

            $this->features = serialize($fet);
        }
    }

    public function getPubsubRoles()
    {
        $features = unserialize($this->features);

        $roles = ['owner', 'none'];

        foreach($features as $feature) {
            preg_match("/http:\/\/jabber.org\/protocol\/pubsub#(.*)-affiliation$/", $feature, $matches);
            if(!empty($matches)){
                array_push($roles, $matches[1]);
            }
        }

        return $roles;
    }

    public function isJingle()
    {
        $features = unserialize($this->features);
        return (in_array('http://jabber.org/protocol/jingle', $features));
    }
}
