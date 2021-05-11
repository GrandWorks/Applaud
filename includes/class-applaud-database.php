<?php
class Applaud_Database{
    
    public static function vote_up($post_id)
    {
        global $wpdb;
        $table_name = self::get_table_name();
        $uuid = $wpdb->get_results('Select UUID() as uuid');

        $result = $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO `{$table_name}` (`post_id`, `number_of_votes`) VALUES (%d, 1) ON DUPLICATE KEY UPDATE number_of_votes=number_of_votes+1" , $post_id
            )
        );

        return array("post_id"=>$post_id,"number_of_votes"=>self::get_votes($post_id));
    }

    public static function vote_down($post_id)
    {
        global $wpdb;
        $wpdb->show_errors=false;
        $table_name = self::get_table_name();
        $result = $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO `{$table_name}` (`post_id`) VALUES (%d) ON DUPLICATE KEY UPDATE number_of_votes=number_of_votes-1" ,$post_id
            )
        );

        if($wpdb->last_error !== '')
        {
           
            return false;
        }
        return array($post_id,self::get_votes($post_id));
        // return $result;
    }

    public static function get_votes($post_id)
    {
        global $wpdb;
        $table_name = self::get_table_name();
        $result = $wpdb->get_results(
            $wpdb->prepare("SELECT `number_of_votes` as votes from {$table_name} WHERE post_id = %d ", $post_id)
        );
        if(sizeof($result)>0){
            return $result[0]->votes;
        }
        return "0";
    }

    public static function get_table_name()
    {
        global $table_prefix;
        return $table_prefix . "wp_applaud";
    }

    
}