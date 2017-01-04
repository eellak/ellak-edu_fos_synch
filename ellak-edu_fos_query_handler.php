<?php

/**
 * ellak - Edu_fos query handler.
 *
 * @package     none
 * @author      David Bromoiras
 * @copyright   2016 eellak
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Edu_fos query handler.
 * Plugin URI:  
 * Description: .
 * Version:     1.0
 * Author:      David Bromoiras
 * Author URI:  https://www.anchor-web.gr
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txtd
 *
 **/

function ellak_edu_fos_query_handler(){
    $thematiki=filter_input(INPUT_POST, $_POST['thematiki'], FILTER_SANITIZE_SPECIAL_CHARS);
    $antikimeno=filter_input(INPUT_POST, $_POST['antikimeno'], FILTER_SANITIZE_SPECIAL_CHARS);
    $vathmida=filter_input(INPUT_POST, $_POST['vathmida'], FILTER_SANITIZE_SPECIAL_CHARS);
    
    $thematiki=$_POST['thematiki'];
    $antikimeno=$_POST['antikimeno'];
    $vathmida=$_POST['vathmida'];
    
    wp_redirect("https://edu.ellak.gr/edu_fos/?thematiki=$thematiki&vathmida=$vathmida&antikimeno=$antikimeno");
}
add_action('admin_post_handle_edu_fos_query', 'ellak_edu_fos_query_handler');
add_action('admin_post_nopriv_handle_edu_fos_query', 'ellak_edu_fos_query_handler');

function filter_fos_query_by_taxonomies($query){
    if($query->is_main_query() && is_post_type_archive('edu_fos')){
        $tax_query=array('relation'=>'AND',);
        
        if (isset($_GET['thematiki'])){
            $thematiki=$_GET['thematiki'];
            if($thematiki!=='null_option'){

                array_push(
                        $tax_query,
                        array(
                        'taxonomy'=>'edu_fos_thematiki',
                        'field'=>'slug',
                        'terms'=>$thematiki
                    ));
            }
        }
        
        if (isset($_GET['antikimeno'])){
            $antikimeno=$_GET['antikimeno'];
            if($antikimeno!=='null_option'){
                array_push(
                        $tax_query,
                        array(
                        'taxonomy'=>'edu_fos_antikimeno',
                        'field'=>'slug',
                        'terms'=>$antikimeno
                    ));
            }
        }
        
        if (isset($_GET['vathmida'])){
            $vathmida=$_GET['vathmida'];
            if($vathmida!=='null_option'){
                array_push(
                        $tax_query,
                        array(
                        'taxonomy'=>'edu_fos_vathmida',
                        'field'=>'slug',
                        'terms'=>$vathmida
                    ));
            }
        }
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('post_type', 'edu_fos');
        $query->set('tax_query', $tax_query);
    }
}
add_action('pre_get_posts', 'filter_fos_query_by_taxonomies');

function add_edu_fos_query_vars_filter($vars){
    $vars[]='thematiki';
    $vars[]='antikimeno';
    $vars[]='vathmida';
    return $vars;
}
add_filter('query_vars', 'add_edu_fos_query_vars_filter');