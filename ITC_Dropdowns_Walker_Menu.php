<?php

  /**
   * From the Walker class.
   *  This removes the classnames and adds accessibility tags, modified version of UW 2014 theme walker for ITC megamenus
   */

class ITC_Dropdowns_Walker_Menu extends Walker_Nav_Menu
{

public function start_lvl( &$output, $depth = 0, $args = array() ) {
    //$output .= '<ul class="submenu-' . $depth . '">';
    if ($depth == 0) {
      $output .= '<div class="mega-wrap"><ul role="group" id="menu-' . $this->CURRENT . '" aria-labelledby="menu-' . $this->CURRENT . '" aria-expanded="false" class="mega-container">';
    } else {
      $output .= '<ul class="section-container">';
    }
    
}

public function end_lvl( &$output, $depth = 0, $args = array() ) {
    if ($depth == 0) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    } else {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}

public function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    $element->has_children = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);
    return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
}


public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $this->CURRENT = $item->post_name;
    $title = ! empty( $item->title ) ? $item->title : $item->post_title;

    $controls = $depth == 0 && $item->has_children ? 'aria-controls="menu-'.$item->post_name.'" aria-expanded="false" aria-haspopup="true"' : '';

    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $classes     = $depth == 0 ? array( 'dawgdrops-item-itc', $item->classes[0] ) : array();
    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );

    $li_classnames = ! empty($classes) ? 'class="'. $class_names .'"' : '';
    $li_attributes = $depth == 0 ? ' ' : '';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

    $attributes .= $depth == 0 && $item->has_children ? ' class="dropdown-toggle"' : '';

    $attributes .= $depth >= 1                ? ' tabindex="-1" '                                : '';
    $attributes .= ' title="'. $title .'" ';
    $attributes .= $controls;
    $attributes .= ' id="' . $this->CURRENT . '"';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $title, $item->ID ) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= $indent . '<li ' . $li_attributes . $li_classnames . '>' . $item_output;
}

public function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= '</li>';
}

}
