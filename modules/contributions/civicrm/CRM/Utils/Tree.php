<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 1.4                                                |
 +--------------------------------------------------------------------+
 | Copyright (c) 2005 Donald A. Lobo                                  |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the Affero General Public License Version 1,    |
 | March 2002.                                                        |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the Affero General Public License for more details.            |
 |                                                                    |
 | You should have received a copy of the Affero General Public       |
 | License along with this program; if not, contact the Social Source |
 | Foundation at info[AT]socialsourcefoundation[DOT]org.  If you have |
 | questions about the Affero General Public License or the licensing |
 | of CiviCRM, see the Social Source Foundation CiviCRM license FAQ   |
 | at http://www.openngo.org/faqs/licensing.html                       |
 +--------------------------------------------------------------------+
*/

/**
 * Manage simple Tree data structure
 * example of Tree is
 *
 *                             'a'
 *                              |
 *    --------------------------------------------------------------
 *    |                 |                 |              |         |  
 *   'b'               'c'               'd'            'e'       'f'
 *    |                 |         /-----/ |                        |
 *  -------------     ---------  /     --------     ------------------------
 *  |           |     |       | /      |      |     |           |          |
 * 'g'         'h'   'i'     'j'      'k'    'l'   'm'         'n'        'o'
 *                            |
 *                  ----------------------
 *                 |          |          |
 *                'p'        'q'        'r'
 *
 *
 *
 * From the above diagram we have
 *   'a'  - root node
 *   'b'  - child node
 *   'g'  - leaf node
 *   'j'  - node with multiple parents 'c' and 'd'
 *
 *
 * All nodes of the tree (including root and leaf node) contain the following properties
 *       Name      - what is the node name ?
 *       Children  - who are it's children
 *       Data      - any other auxillary data
 *
 *
 * Internally all nodes are an array with the following keys
 *      'name' - string 
 *      'children' - array
 *      'data' - array
 *
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


class CRM_Utils_Tree {

    /**
     * Store the tree information as a string or array
     * @var string|array
     */
    var $tree;


    /**
     * Constructor for the tree.
     *
     * @param string $root 
     * @return CRM_Utils_Tree

     * @access public
     *
     */
     function CRM_Utils_Tree($nodeName)
    {
        // create the root node
        $rootNode =& $this->createNode($nodeName);

        // add the root node to the tree
        $this->tree['rootNode'] =& $rootNode;
    }

    /**
     * Find a node that matches the given string
     *
     * @param string      $name       name of the node we are searching for.
     * @param array (ref) $parentNode which parent node should we search in ?
     *
     * @return array(ref) | false node if found else false
     *
     * @access public
     */
    //public function &findNode(&$parentNode, $name)
     function &findNode($name, &$parentNode)
    {
        // if no parent node specified, please start from root node
        if(!$parentNode) {
            $parentNode =& $this->tree['rootNode'];
        }

        // first check the nodename of subtree itself
        if ($parentNode['name'] == $name) {
            return $parentNode;
        }

        $falseRet = false;
        // no children ? return false
        if ($this->isLeafNode($node)) {
            return $falseRet;
        }

        // search children of the subtree
        foreach ($parentNode['children'] as $key => $childNode) {
            $cNode =& $parentNode['children'][$key];
            if ($node =& $this->findNode($name, $cNode)) {
                return $node;
            }
        }

        // name does not match subtree or any of the children, negative result
        return $falseRet;
    }

    /**
     * Function to check if node is a leaf node.
     * Currently leaf nodes are strings and non-leaf nodes are arrays
     *
     * @param array(ref) $node node which needs to checked
     * @return boolean
     *
     * @access public
     */
     function isLeafNode(&$node)
    {
        return (count($node['children']) ? true : false);
    }


    /**
     * Create a node
     *
     * @param string $name 
     * @return array (ref)
     *
     * @access public
     */
     function &createNode($name)
    {
        $node['name'] = $name;
        $node['children'] = array();
        $node['data'] = array();
        
        return $node;
    }


    /**
     * Add node
     *
     * @param string $parentName - name of the parent ?
     * @param array  (ref)       - node to be added
     * @return none
     *
     * @access public
     */
     function addNode($parentName, &$node)
    {
        $temp = '';
        $parentNode =& $this->findNode($parentName,$temp);
     
        $parentNode['children'][] =& $node;
    }

    /**
     * Add Data
     *
     * @param string $parentName - name of the parent ?
     * @param mixed              - data to be added
     * @param string             - key to be used (optional)
     * @return none
     *
     * @access public
     */
     function addData($parentName, $childName, $data)
    {
        $temp = '';
        if ($parentNode =& $this->findNode($parentName, $temp)) {
            foreach ($parentNode['children'] as $key => $childNode ) {
                $cNode =& $parentNode['children'][$key];
                if ($cNode =& $this->findNode($childName, $parentNode) ) {
                    $cNode['data']['fKey'] =& $data;
                }
            }
        }
    }

    /**
     * Get Tree
     *
     * @param none
     * @return tree
     *
     * @access public
     */
     function getTree()
    {
        return $this->tree;
    }


    /**
     * print the tree
     *
     * @param none
     * @return none
     *
     * @access public
     */
     function display()
    {
        print_r($this->tree);
    }
}

?>
