<?php

add_action( 'rest_api_init', 'wp_api_add_posts_endpoints' );
function wp_api_add_posts_endpoints() {
  register_rest_route( 'applaud/v2', '/upVote', array(
        'methods' => 'POST',
        'callback' => 'up_vote',
    ));
    register_rest_route( 'applaud/v2', '/getVotes/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_vote',
    ));
}

function up_vote( $request_data ) {
    $request_id = json_decode($request_data->get_body())->ID;

   $response = Applaud_Database::vote_up($request_id);
    return json_encode($response);
}


function get_vote( $request_data ) {
    $request_id = $request_data["id"];

    $response = Applaud_Database::get_votes($request_id);

    return json_encode(array("number_of_votes" => $response));
}