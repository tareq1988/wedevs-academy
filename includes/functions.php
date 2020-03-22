<?php

/**
 * Insert a new address
 *
 * @param  array  $args
 *
 * @return int|WP_Error
 */
function wd_ac_insert_address( $args = [] ) {
    global $wpdb;

    if ( empty( $args['name'] ) ) {
        return new \WP_Error( 'no-name', __( 'You must provide a name.', 'wedevs-academy' ) );
    }

    $defaults = [
        'name'       => '',
        'address'    => '',
        'phone'      => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    if ( isset( $data['id'] ) ) {

        $id = $data['id'];
        unset( $data['id'] );

        $updated = $wpdb->update(
            $wpdb->prefix . 'ac_addresses',
            $data,
            [ 'id' => $id ],
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s'
            ],
            [ '%d' ]
        );

        wd_ac_address_purge_cache( $id );

        return $updated;

    } else {

        $inserted = $wpdb->insert(
            $wpdb->prefix . 'ac_addresses',
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s'
            ]
        );

        if ( ! $inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'wedevs-academy' ) );
        }

        wd_ac_address_purge_cache();

        return $wpdb->insert_id;
    }
}

/**
 * Fetch Addresses
 *
 * @param  array  $args
 *
 * @return array
 */
function wd_ac_get_addresses( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC'
    ];

    $args = wp_parse_args( $args, $defaults );

    $last_changed = wp_cache_get_last_changed( 'address' );
    $key          = md5( serialize( array_diff_assoc( $args, $defaults ) ) );
    $cache_key    = "all:$key:$last_changed";

    $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}ac_addresses
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
    );

    $items = wp_cache_get( $cache_key, 'address' );

    if ( false === $items ) {
        $items = $wpdb->get_results( $sql );

        wp_cache_set( $cache_key, $items, 'address' );
    }

    return $items;
}

/**
 * Get the count of total address
 *
 * @return int
 */
function wd_ac_address_count() {
    global $wpdb;

    $count = wp_cache_get( 'count', 'address' );

    if ( false === $count ) {
        $count = (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}ac_addresses" );

        wp_cache_set( 'count', $count, 'address' );
    }

    return $count;
}

/**
 * Fetch a single contact from the DB
 *
 * @param  int $id
 *
 * @return object
 */
function wd_ac_get_address( $id ) {
    global $wpdb;

    $address = wp_cache_get( 'book-' . $id, 'address' );

    if ( false === $address ) {
        $address = $wpdb->get_row(
            $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ac_addresses WHERE id = %d", $id )
        );

        wp_cache_set( 'book-' . $id, $address, 'address' );
    }

    return $address;
}

/**
 * Delete an address
 *
 * @param  int $id
 *
 * @return int|boolean
 */
function wd_ac_delete_address( $id ) {
    global $wpdb;

    wd_ac_address_purge_cache( $id );

    return $wpdb->delete(
        $wpdb->prefix . 'ac_addresses',
        [ 'id' => $id ],
        [ '%d' ]
    );
}

/**
 * Purge the cache for books
 *
 * @param  int $book_id
 *
 * @return void
 */
function wd_ac_address_purge_cache( $book_id = null ) {
    $group = 'address';

    if ( $book_id ) {
        wp_cache_delete( 'book-' . $book_id, $group );
    }

    wp_cache_delete( 'count', $group );
    wp_cache_set( 'last_changed', microtime(), $group );
}
