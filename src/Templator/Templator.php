<?php

namespace Templator;

class Templator {

    /**
     * Templator version
     * @var string
     */
    public $version = '0.0.1';

    /**
     * Configuration
     * @var array
     */
    public $_config = array(
        'path'  => array(
            'root'      => 'templates',
            'base'      => 'base',
            'pages'     => 'pages',
            'widgets'   => 'widgets'
        ),
        'cache' => NULL
    );

    /**
     * Data
     * @var array
     */
    public $_data    = array();

    /**
     * Widgets
     * @var array
     */
    public $_widgets = array();


    /**
     * Constructor
     * 
     * @param array $config
     */
    public function __construct($config = array())
    {
        if(is_array($config))
        {
            $this->_config = array_merge($this->_config, $config);
        }
    }

    /****************************************************************************/

    /**
    * Set data
    * 
    * @param  array|string   $key  
    * @param  string         $value
    * @return \Templator\Templator
    */
    public function data($key = NULL, $value = NULL)
    {
        if($key)
        {
            if(is_array($key))
            {
                foreach ($key as $k => $v)
                {
                    $this->_data[$k] = $v;
                }
            }
            else
            {
                $this->_data[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Set widgets
     * 
     * @param  array  $widgets
     * @return \Templator\Templator
     */
    public function blocks($widgets = array())
    {
        // Check
        if($widgets AND is_array($widgets))
        {
            $this->_widgets = $widgets;

            return $this;
        }

        die('Widgets must be an array');
    }

    /**
     * Renders a template
     * 
     * @param  string $base
     * @param  string $page
     * @return string The rendered template
     */
    public function render($base = NULL, $page = NULL)
    {
        // Checking
        ($base AND $page) OR die('Base template and page must be set!');

        // Base template
        $file  = "{% extends '/" . $this->_config['path']['base'] . '/' . $base . ".html' %}";

        // Widgets
        if($this->_widgets)
        {
            foreach ($this->_widgets as $position => $items)
            {
                $file .= "{% block " . $position . " %}";
                
                foreach ($items as $item)
                {
                    $file .= "{% include '" . $this->_config['path']['widgets'] . '/' . $item . ".html' %}";
                }

                $file .= "{% endblock %}";
            }
        }

        // Content
        $file .= "{% block content %}";
        $file .= file_get_contents($this->_config['path']['root'] . '/' . $this->_config['path']['pages'] . '/' . $page . '.html');
        $file .= "{% endblock %}";

        // Twig it!
        $config             = array('cache' => $this->_config['cache']);
        $loader_filesystem  = new \Twig_Loader_Filesystem($this->_config['path']['root']);
        $loader_string      = new \Twig_Loader_String();
        $loader             = new \Twig_Loader_Chain(array($loader_filesystem, $loader_string));
        $twig               = new \Twig_Environment($loader, $config);

        // Return
        return $twig->render($file, $this->_data);
    }

}
