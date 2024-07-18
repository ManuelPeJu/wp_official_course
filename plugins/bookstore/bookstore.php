<?php
/**
 * Plugin Name: Bookstore
 * Description: A plugin to manage Books
 * Version: 1.0.0
 */

 if ( ! defined( 'ABSPATH' )) {
    exit; // Exit if accessed directly
};


//Ejemplo de crear un Custom Post Type
function bookstore_register_book_post_type(){
    
    $args = array(
        'labels' => array(
            'name'          => 'Books',
            'singular_name' => 'Book',
            'menu_name'     => 'Books',
            'add_new'       => 'Add New Book',
            'add_new_item'  => 'Add New Book',
            'new_item'      => 'New Book',
            'edit_item'     => 'Edit Book',
            'view_item'     => 'View Book',
            'all_items'     => 'All Books',
        ),
        'public'        => true, // determina si es público
        'has_archive'   => true, // determina si tiene archivo
        'show_in_rest'  => true, // agrega una ruta en el espacio de nombres wp/v2.
        'supports'      => array('title', 'editor', 'author', 'thumbnail', 'excerpt', )
    );
    
    register_post_type('book', $args);
    
}
add_action('init', 'bookstore_register_book_post_type');

//Ejemplo de crear una taxonomía custom
function bookstore_register_genre_taxonomy(){

    $args = array(
        'labels' => array(
            'name'          => 'Genres',
            'singular_name' => 'Genre',
            'edit_item'     => 'Edit Genre',
            'update_item'   => 'Update Genre',
            'add_new_item'  => 'Add New Genre',
            'new_item_name' => 'New Genre Name',
            'menu_name'     => 'Genre',
        ),
        'hiererchical'  => true,
        'rewrite'       => array('slug' => 'genre'),
        'show_in_rest'  => true,
    );

    register_taxonomy('genre', 'book', $args );
};
add_action('init', 'bookstore_register_genre_taxonomy');

// Ejemplo para agregar metadatos
function bookstore_add_isbn_to_quick_edit($keys, $post) {
    if($post->post_type === 'book') {
        $keys[] = 'isbn';
    }

    return $keys;
}
add_filter('postmeta_form_keys', 'bookstore_add_isbn_to_quick_edit', 10, 2);


//Ejemplo para poner en cola archivos de JS o CSS
function bookstore_enqueue_scripts() {
    $post = get_post();
    if('book' !== $post->post_type) {
        return;
    }
    wp_enqueue_style('bookstore_style', plugins_url() . '/bookstore/bookstore.css');
    wp_enqueue_script('bookstore_script', plugins_url() . '/bookstore/bookstore.js');
};
add_action('wp_enqueue_scripts', 'bookstore_enqueue_scripts');