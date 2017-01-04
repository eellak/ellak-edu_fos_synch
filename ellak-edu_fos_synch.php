<?php

/**
 * ellak - Educational FOS Synch Plugin
 *
 * @package     none
 * @author      David Bromoiras
 * @copyright   2016 Your Name or Company Name
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Educational FOS Synch Plugin
 * Plugin URI:  
 * Description: Synch csv entries to edu_fos cpt.
 * Version:     0.1
 * Author:      David Bromoiras
 * Author URI:  https://www.anchor-web.gr
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txtd
 *

  /* PLUGIN DOCUMENTATION AT https://team.ellak.gr/projects/sites/wiki/Greek-edu-fos/ */


function ellak_edu_fos_synch_posts(){
    $custom_base_dir=get_stylesheet_directory();
    $list_of_edu_fos=array(); //associative array of developers with number of contrbutions
    //access the file with the list of the developer logins and the contributions total
    if(file_exists($custom_base_dir.'/edu_fos_final.csv')){
        $tmp_query=new WP_Query(array('post_type'=>'edu_fos'));
        if($tmp_query->have_posts()){
            while($tmp_query->have_posts()){
                $tmp_query->the_post();
                wp_delete_post(get_the_ID(), true);
            }
        }
        
        $edu_fos_csv=fopen($custom_base_dir.'/edu_fos_final.csv', 'r');
        
        $edu_fos_list_args=array(
            
        );
        //$existing_edu_fos_list=get_posts();
        
        //get rid of the first two lines with the excel titles and blank row
        fgetcsv($edu_fos_csv);
        //fgetcsv($edu_fos_csv);
        
        //do useful stuff with the useful data in the file...
        while (! feof($edu_fos_csv)){
            $edu_fos_txt_line=fgetcsv($edu_fos_csv);
            //$contributor_line_csv_array=str_getcsv($contributor_line);
            $title=$edu_fos_txt_line[0];
            $thematiki=$edu_fos_txt_line[1];
            //check for multiple terms in the thematiki field, split  on # delimiter
            if(mb_strpos($thematiki, '#')){
                //$thematiki=array();
                $thematiki=mb_split('#', $thematiki);
            }
            $antikimeno=$edu_fos_txt_line[2];
            $vathmida=$edu_fos_txt_line[3];
            //check for multiple terms in the vathmida field, split  on # delimiter
            if(mb_strpos($vathmida, '#')){
                //$vathmida=array();
                $vathmida=mb_split('#', $vathmida);
            }
            $url=$edu_fos_txt_line[4];
            $description=$edu_fos_txt_line[5];
            $adia=$edu_fos_txt_line[6];
            $idos=$edu_fos_txt_line[7];
            $litourgiko=$edu_fos_txt_line[8];
            
            
            //if (file_exists($custom_base_dir.'/user/info/'.$contributor_username.'.json')){
                //$contributor_info_str=file_get_contents($custom_base_dir.'/user/info/'.$contributor_username.'.json', false, NULL, 0, 5000); //setting the max size for security
                //$contributor_info=json_decode($contributor_info_str);
                if($post_id=post_exists($title)){
//                    if(get_post_status($post_id)!=='publish'){
//                        $tmp_post=array('ID'=>$post_id, 'post_status'=>'publish');
//                    }
                    $tmp_post=array('ID'=>$post_id, 'post_title'=>$title, 'post_content'=>$description);
                    wp_update_post($tmp_post);
                    update_field('edu_fos_url', $url, $post_id);
                    wp_set_post_terms($post_id, $thematiki, 'edu_fos_thematiki');
                    wp_set_post_terms($post_id, $antikimeno, 'edu_fos_antikimeno');
                    wp_set_post_terms($post_id, $vathmida, 'edu_fos_vathmida');
                    wp_set_post_terms($post_id, $adia, 'edu_fos_adia');
                    wp_set_post_terms($post_id, $idos, 'edu_fos_idos');
                    wp_set_post_terms($post_id, $litourgiko, 'edu_fos_litourgiko');
//                    update_field('contributor_username', $contributor_username, $post_id);
//                    update_field('contributor_full_name', $contributor_info->name, $post_id);
//                    //if($contributor_info.gravatar_id!="")
//                        update_field('contributor_avatar_url', $contributor_info->avatar_url, $post_id);
//                    //else
//                    //   update_field('contributor_avatar_url', $contributor_info.gravatar_id, $post_id);
//                    update_field('contributor_github_url', $contributor_info->html_url, $post_id);
//                    update_field('contributor_email', $contributor_info->email, $post_id);
//                    update_field('contributor_personal_webpage', $contributor_info->blog, $post_id);
//                    update_field('contributor_company', $contributor_info->company, $post_id);
//                    update_field('contributor_location', $contributor_info->location, $post_id);
//                    update_field('contributions_number', $contributions_number, $post_id);
//                    update_field('repos_number', $contributor_info->public_repos, $post_id);
//                    update_field('followers_number', $contributor_info->followers, $post_id);     
                }
                else{
                    $post_id=wp_insert_post(array('post_type'=>'edu_fos', 'post_title'=>$title, 'post_content'=>$description, 'post_status'=>'publish'));
                    update_field('edu_fos_url', $url, $post_id);
                    wp_set_post_terms($post_id, $thematiki, 'edu_fos_thematiki');
                    wp_set_post_terms($post_id, $antikimeno, 'edu_fos_antikimeno');
                    wp_set_post_terms($post_id, $vathmida, 'edu_fos_vathmida');
                    wp_set_post_terms($post_id, $adia, 'edu_fos_adia');
                    wp_set_post_terms($post_id, $idos, 'edu_fos_idos');
                    wp_set_post_terms($post_id, $litourgiko, 'edu_fos_litourgiko');
                    
//                    update_field('contributor_username', $contributor_username, $post_id);
//                    update_field('contributor_full_name', $contributor_info->name, $post_id);
//                    //if($contributor_info.gravatar_id!="")
//                        update_field('contributor_avatar_url', $contributor_info->avatar_url, $post_id);
//                    //else
//                    //    update_field('contributor_avatar_url', $contributor_info.gravatar_id, $post_id);
//                    update_field('contributor_github_url', $contributor_info->html_url, $post_id);
//                    update_field('contributor_email', $contributor_info->email, $post_id);
//                    update_field('contributor_personal_webpage', $contributor_info->blog, $post_id);
//                    update_field('contributor_company', $contributor_info->company, $post_id);
//                    update_field('contributor_location', $contributor_info->location, $post_id);
//                    update_field('contributions_number', $contributions_number, $post_id);
//                    update_field('repos_number', $contributor_info->public_repos, $post_id);
//                    update_field('followers_number', $contributor_info->followers, $post_id);
//                    //update_field('', $contributor_info.id, $post_id);
                }
            //}
            //fclose($contributor_info_file);
        }
        fclose($edu_fos_csv);
    }
}
register_activation_hook(__FILE__, 'ellak_edu_fos_synch_posts');
//add_action('init', 'ellak_github_contributors_synch_posts');

/* Add monthly scheduling interval */
//function ellak_add_my_scheduling_intervals($schedules){
//    //error_log('check 3-4');
//    $schedules['ellak_weekly']=array('interval'=>604800, 'display'=>__('Once weekly'));
//    $schedules['ellak_monthly']=array('interval'=>2635200, 'display'=>__('Once monthly'));
//    return $schedules;
//}
//add_filter('cron_schedules', 'ellak_add_my_scheduling_intervals');

//register_activation_hook(__FILE__, 'ellak_activate_contributors_synch');
///* Monthly schedule the synching of files with posts */
//function ellak_activate_contributors_synch(){
//    if(! wp_next_scheduled('ellak_monthly_synch_contributors')){
//        
//        if(!wp_schedule_event(time()+60, '1min', 'ellak_monthly_synch_contributors'))
//                error_log('check 1-2');
//    }
//}
//add_action('ellak_monthly_synch_contributors', 'ellak_github_contributors_synch_posts');
//
//register_deactivation_hook(__FILE__, 'ellak_deactivate_contributors_synch');
//function ellak_deactivate_contributors_synch() {
//	wp_clear_scheduled_hook('ellak_monthly_synch_contributors');
//}
//?>
