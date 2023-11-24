<?php
require_once 'class.php';
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \elementorWidget\ExampleWidget());
